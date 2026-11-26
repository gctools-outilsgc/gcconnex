#!/bin/sh
# Rebuild the pinned supplier source; never relabel unmodified vendor binaries.
set -eu
. /recipe/runtime-packages.env
export DEBIAN_FRONTEND=noninteractive
export DEB_BUILD_OPTIONS='parallel=4 noautodbgsym'
export DEBFULLNAME='GCconnex local runtime build'
export DEBEMAIL='noreply@example.invalid'
export QUILT_PATCHES=debian/patches
export QUILT_PATCH_OPTS='--fuzz=0'

mkdir -p /build /out/debs /out/provenance /out/source
cd /build
source_url="https://launchpad.net/~ondrej/+archive/ubuntu/php/+sourcefiles/php5.6/$PHP56_SOURCE_VERSION"
while read -r digest filename; do
    curl --fail --location --retry 3 --connect-timeout 20 --max-time 240 \
        "$source_url/$filename" --output "$filename"
done < /recipe/php56-source.sha256
sha256sum --check /recipe/php56-source.sha256
# All three source artifacts are hash-pinned above, including the signed .dsc.
dpkg-source --no-check --extract "php5.6_${PHP56_SOURCE_VERSION}.dsc" php-source
cd php-source
test "$(dpkg-parsechangelog -S Version)" = "$PHP56_SOURCE_VERSION"
printf '%s  %s\n' \
    d86f6d18d7e51a162eea3b9d88df4a29682d3107fd4ed6297408420c1a98bd93 ext/openssl/xp_ssl.c \
    3244394faf14e3149b7099ab2ac2915518dd8ea38b2ec52d658b6f2c5e64c1e1 /recipe/0265-openssl-stream-hostname-verification.patch \
    | sha256sum --check -
quilt import -P 0265-openssl-stream-hostname-verification.patch \
    /recipe/0265-openssl-stream-hostname-verification.patch
quilt push
printf '%s  %s\n' d7cfe3cb3a5663af27ea92aa655174a6a73a2fb3cb2005077cfca51f79975b1d \
    ext/openssl/xp_ssl.c | sha256sum --check -
dch --newversion "$PHP56_VERSION" --distribution jammy --force-distribution \
    'Local backport of CVE-2026-91767 and CVE-2026-91769; retain supplier revision 105 fixes.'
dpkg-buildpackage --no-sign --jobs=4
cp /build/*.dsc /build/*.tar.xz /out/source/
cp /build/*.buildinfo /build/*.changes /out/provenance/

# Export only the existing application's runtime package set, not extra SAPIs.
for package in libapache2-mod-php5.6 php5.6 php5.6-cli php5.6-common \
    php5.6-gd php5.6-mbstring php5.6-json php5.6-mysql php5.6-zip \
    php5.6-xml php5.6-curl php5.6-opcache php5.6-readline; do
    found=0
    for archive in /build/"${package}_${PHP56_VERSION}_"*.deb; do
        test -f "$archive" || continue
        test "$(dpkg-deb -f "$archive" Package)" = "$package"
        test "$(dpkg-deb -f "$archive" Version)" = "$PHP56_VERSION"
        cp "$archive" /out/debs/
        found=$((found + 1))
    done
    test "$found" -eq 1
done
cp /recipe/php56-source.sha256 /out/provenance/
cp /recipe/0265-openssl-stream-hostname-verification.patch /out/provenance/
cp debian/changelog /out/provenance/php56-changelog
dpkg-query -W -f='${Package}\t${Version}\t${Architecture}\n' > /out/provenance/build-packages.tsv
cd /out/debs
sha256sum ./*.deb > /out/provenance/rebuilt-packages.sha256
