# Reuse only immutable dependency artifacts; never resolve the unlocked Pleio
# dependencies or copy application sources from this older production image.
FROM phanoix/gcconnex@sha256:fcea945fe594bd71a04f23c35b379064de89a038f492d3e05ed4b231cb536a1a AS dependencies

# OpenSSL is built into PHP's CLI and Apache SAPIs. Rebuild the complete pinned
# supplier source package, retaining its October patches and Debian hardening.
FROM ubuntu:22.04@sha256:0a9887931b0e38af2e3487ed39e29436b0535c4f3f52e57745baaf79d1898956 AS php-build
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update && apt-get install -y --no-install-recommends \
        ca-certificates software-properties-common gpg-agent \
    && add-apt-repository --yes --enable-source ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y --no-install-recommends build-essential devscripts equivs fakeroot quilt \
    && apt-get build-dep -y --no-install-recommends 'php5.6=5.6.40-105+ubuntu22.04.1+deb.sury.org+1' \
    && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y --no-install-recommends curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*
COPY docker/runtime-packages.env docker/php56-source.sha256 docker/build-php56.sh /recipe/
COPY docker/patches/0265-openssl-stream-hostname-verification.patch /recipe/
RUN sh /recipe/build-php56.sh

# Optional export target for the rebuilt packages and exact local source package.
FROM scratch AS php-artifacts
COPY --from=php-build /out/ /

FROM ubuntu:22.04@sha256:0a9887931b0e38af2e3487ed39e29436b0535c4f3f52e57745baaf79d1898956
ENV DEBIAN_FRONTEND=noninteractive

LABEL org.gcconnex.runtime.php-source="https://launchpad.net/~ondrej/+archive/ubuntu/php/+sourcepub/18893905" \
      org.gcconnex.runtime.local-backports="CVE-2026-91767,CVE-2026-91769" \
      org.gcconnex.runtime.dependency-image="phanoix/gcconnex@sha256:fcea945fe594bd71a04f23c35b379064de89a038f492d3e05ed4b231cb536a1a"

COPY docker/runtime-packages.env /usr/local/share/gcconnex-runtime/runtime-packages.env
COPY --from=php-build /out/debs/ /tmp/php-debs/
COPY --from=php-build /out/provenance/ /usr/local/share/gcconnex-runtime/source-build/
RUN apt-get update && apt-get install -y --no-install-recommends \
        ca-certificates software-properties-common gpg-agent \
    && add-apt-repository --yes ppa:ondrej/php \
    && apt-get update \
    && . /usr/local/share/gcconnex-runtime/runtime-packages.env \
    && apt-get install -y --no-install-recommends \
        apache2 curl memcached \
        /tmp/php-debs/*.deb \
        "php5.6-memcache=$PHP56_MEMCACHE_VERSION" \
    && dpkg-query -W -f='${Package}\t${Version}\t${Architecture}\n' \
        > /usr/local/share/gcconnex-runtime/packages.tsv \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/php-debs \
    && mkdir -p /var/www/html/vendor /data \
    && chown www-data /data \
    && ln -sf /dev/stderr /var/log/apache2/error.log \
    && ln -sf /dev/stdout /var/log/apache2/access.log

RUN a2enmod rewrite headers

RUN { \
  echo 'opcache.memory_consumption=128'; \
  echo 'opcache.interned_strings_buffer=8'; \
  echo 'opcache.max_accelerated_files=4000'; \
  echo 'opcache.revalidate_freq=60'; \
  echo 'opcache.fast_shutdown=1'; \
  echo 'opcache.enable_cli=1'; \
  echo 'opcache.enable_file_override=1'; \
  } > /etc/php/5.6/apache2/conf.d/opcache-recommended.ini

# Startup mitigation from PHP's 2026-10-23 follow-up, for both SAPIs.
COPY docker/99-gcconnex-security.ini /etc/php/5.6/mods-available/gcconnex-security.ini
RUN phpenmod -v 5.6 -s ALL gcconnex-security
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/check-runtime.sh /usr/local/bin/gcconnex-check-runtime
COPY docker/runtime-entrypoint.sh /usr/local/bin/gcconnex-runtime-entrypoint

# Application sources always come from this checkout. Only the two vendor trees
# come from the dependency donor, whose OS and PHP runtime are never used.
COPY . /var/www/html
COPY --from=dependencies /var/www/html/vendor/ /var/www/html/vendor/
COPY --from=dependencies /var/www/html/mod/pleio/vendor/ /var/www/html/mod/pleio/vendor/
COPY docker/settings.env.php /var/www/html/engine/settings.php
RUN chown www-data:www-data /var/www/html \
    && chmod +x /usr/local/bin/gcconnex-check-runtime \
        /usr/local/bin/gcconnex-runtime-entrypoint /var/www/html/docker/start.sh \
    && test ! -e /var/www/html/docs/security-investigation-2026-10-23.md \
    && gcconnex-check-runtime

WORKDIR /var/www/html
EXPOSE 80 443

# Start Apache in foreground mode
RUN rm -f /run/apache2/httpd.pid
ENTRYPOINT ["/usr/local/bin/gcconnex-runtime-entrypoint"]
CMD  ["apache2ctl -D FOREGROUND"]
