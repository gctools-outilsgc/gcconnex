#!/bin/sh
# Package/startup gate only. Apache request behavior is verified separately.
set -eu

fail() {
    echo "PHP runtime check failed: $*" >&2
    exit 1
}

. /etc/os-release
[ "$ID" = ubuntu ] && [ "$VERSION_ID" = 22.04 ] || fail 'expected Ubuntu 22.04'
. /usr/local/share/gcconnex-runtime/runtime-packages.env

verify_package() {
    actual=$(dpkg-query -W -f='${Status}\t${Version}' "$1") || fail "missing $1"
    expected=$(printf 'install ok installed\t%s' "$2")
    [ "$actual" = "$expected" ] || fail "$1: expected $2, found $actual"
    printf '%s\t%s\n' "$1" "$2"
}

for package in libapache2-mod-php5.6 php5.6 php5.6-cli php5.6-common \
    php5.6-gd php5.6-mbstring php5.6-json php5.6-mysql php5.6-zip \
    php5.6-xml php5.6-curl php5.6-opcache php5.6-readline; do
    verify_package "$package" "$PHP56_VERSION"
done
verify_package php5.6-memcache "$PHP56_MEMCACHE_VERSION"

check_ini() {
    php5.6 "$@" -r '
        // The supplier appends its package revision to PHP_VERSION.
        // Exact revisions are checked with dpkg above; this checks the engine version.
        if (PHP_VERSION_ID !== 50640 || ini_get("session.upload_progress.enabled") != "0") {
            fwrite(STDERR, "Unexpected PHP version or upload-progress startup setting\n");
            exit(1);
        }
    ' || fail 'PHP startup configuration'
}

check_ini
# Inspect the Apache startup INI tree without starting a web server. This does
# not attest configuration overrides or the effective SAPI in running workers.
PHP_INI_SCAN_DIR=/etc/php/5.6/apache2/conf.d \
    check_ini -c /etc/php/5.6/apache2/php.ini
apache2ctl -t
modules=$(apache2ctl -M) || fail 'Apache module inventory'
printf '%s\n' "$modules" | grep -q 'php5_module' || fail 'Apache PHP 5 module missing'
echo 'PHP package and startup checks passed.'
