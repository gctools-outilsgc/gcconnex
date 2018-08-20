# First stage, install composer and its dependencies and fetch vendor files
FROM alpine:3.7
RUN apk --no-cache add \
  php5 \
  php5-dom \
  php5-phar \
  php5-gd \
  php5-iconv \
  php5-json \
  php5-mysql \
  php5-openssl \
  php5-xml \
  php5-zlib \
  php5-curl \
  curl
RUN mkdir /app && mkdir /app/pleio && curl -sS https://getcomposer.org/installer | php5 -- --install-dir=/usr/local/bin --filename=composer
RUN ln -s /usr/bin/php5 /usr/bin/php
WORKDIR /app
COPY composer.json composer.json /app/
COPY mod/pleio/composer.json /app/pleio/

ARG COMPOSER_ALLOW_SUPERUSER=1
ARG COMPOSER_NO_INTERACTION=1
RUN composer install

WORKDIR /app/pleio
RUN composer install

# Second stage, build usable container
FROM alpine:3.7
LABEL maintainer="Luc Belliveau <luc.belliveau@nrc-cnrc.gc.ca>, Ilia Salem"
RUN \
  apk --no-cache add \
    apache2 \
    php5 \
    php5-apache2 \
    php5-ctype \
    php5-curl \
    php5-dom \
    php5-gd \
    php5-iconv \
    php5-json \
    php5-mysql \
    php5-xml \
	php5-zip \
	php5-openssl \
    php5-curl \
    curl \
    php5-opcache \
    libmemcached-libs \
  && apk update \
  && apk --no-cache add php5-mysqli \
  && mkdir -p /var/www/html/vendor \
  && mkdir -p /data \
  && mkdir -p /run/apache2 \
  && chown apache /data \
  && ln -s /dev/stderr /var/log/apache2/error.log \
  && ln -s /dev/stdout /var/log/apache2/access.log \
  && sed -i '/#LoadModule rewrite_module modules\/mod_rewrite.so/c\LoadModule rewrite_module modules\/mod_rewrite.so' /etc/apache2/httpd.conf \
  && sed -i '/DocumentRoot "\/var\/www\/localhost\/htdocs"/c\DocumentRoot "\/var\/www\/html"' /etc/apache2/httpd.conf \
  && sed -i '/Options Indexes FollowSymLinks/c\\' /etc/apache2/httpd.conf \
  && sed -i '/AllowOverride None/c\\' /etc/apache2/httpd.conf \
  && sed -i '/Options Indexes FollowSymLinks/c\\' /etc/apache2/httpd.conf \
  && sed -i '/<Directory "\/var\/www\/localhost\/htdocs">/c\<Directory "\/var\/www\/html">\nDirectoryIndex index.php\nOptions FollowSymLinks MultiViews\nAllowOverride All\nOrder allow,deny\nallow from all\n' /etc/apache2/httpd.conf

RUN { \
		echo 'opcache.memory_consumption=128'; \
		echo 'opcache.interned_strings_buffer=8'; \
		echo 'opcache.max_accelerated_files=4000'; \
		echo 'opcache.revalidate_freq=60'; \
		echo 'opcache.fast_shutdown=1'; \
		echo 'opcache.enable_cli=1'; \
		echo 'opcache.enable_file_override=1'; \
} > /etc/php5/conf.d/opcache-recommended.ini

# install memcached
ENV PHPIZE_DEPS autoconf file g++ gcc libc-dev make pkgconf re2c php5-dev php5-pear \
 zlib-dev libmemcached-dev cyrus-sasl-dev libevent-dev openssl-dev
ENV PHP_PEAR_PHP_BIN /usr/bin/php5
RUN set -xe \
    && apk add --no-cache \
    --virtual .phpize-deps \
    $PHPIZE_DEPS \
    && sed -i 's/^exec $PHP -C -n/exec $PHP -C/g' $(which pecl) \
    && pecl install memcache-2.2.7 \
    && mv $(INSTALL_ROOT)/usr/lib/php5/modules/memcache.so /usr/lib/php5/modules/memcache.so \
    && echo "extension=memcache.so" > /etc/php5/conf.d/memcache.ini \
    && rm -rf /usr/share/php \
    && rm -rf /tmp/* \
    && apk del .phpize-deps

COPY ./install/config/htaccess.dist /var/www/html/.htaccess
COPY --from=0 /app/vendor/ /var/www/html/vendor/
COPY . /var/www/html
COPY --from=0 /app/pleio/vendor/ /var/www/html/mod/pleio/vendor/
RUN chown apache:apache /var/www/html

WORKDIR /var/www/html
EXPOSE 80
EXPOSE 443

RUN chmod +x docker/start.sh

# Start Apache in foreground mode
RUN rm -f /run/apache2/httpd.pid
ENTRYPOINT [ "docker/start.sh" ]
CMD  ["/usr/sbin/httpd -D FOREGROUND"]

