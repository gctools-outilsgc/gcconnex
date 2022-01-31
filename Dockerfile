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
RUN mkdir /app && mkdir /app/pleio && mkdir /app/paas_integration && curl -sS https://getcomposer.org/installer | php5 -- --install-dir=/usr/local/bin --filename=composer
RUN ln -s /usr/bin/php5 /usr/bin/php
WORKDIR /app
COPY composer.json composer.json /app/
COPY mod/pleio/composer.json /app/pleio/
COPY mod/paas_integration/composer.json /app/paas_integration/

ARG COMPOSER_ALLOW_SUPERUSER=1
ARG COMPOSER_NO_INTERACTION=1
RUN composer install

WORKDIR /app/pleio
RUN composer install

WORKDIR /app/paas_integration
RUN composer install



# Second stage, build usable container
FROM ubuntu:18.04
ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
		software-properties-common \
	&& apt-get clean \
	&& rm -fr /var/lib/apt/lists/*

RUN add-apt-repository ppa:ondrej/php

RUN apt-get update && apt-get install -y --no-install-recommends \
            apache2 \
            curl \
            libapache2-mod-php5.6 \
            php5.6 \
            php5.6-gd \
            php5.6-mbstring \
            php5.6-json \
            php5.6-mysql \
            php5.6-zip \
            php5.6-xml \
            php5.6-curl \
            php5.6-opcache \
            php5.6-memcache \
        && apt-get clean \
        && rm -fr /var/lib/apt/lists/* \
        && mkdir -p /var/www/html/vendor \
        && mkdir -p /data \
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

COPY ./docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./install/config/htaccess.dist /var/www/html/.htaccess
COPY --from=0 /app/vendor/ /var/www/html/vendor/
COPY . /var/www/html
COPY --from=0 /app/pleio/vendor/ /var/www/html/mod/pleio/vendor/
COPY --from=0 /app/paas_integration/vendor/ /var/www/html/mod/paas_integration/vendor/
RUN chown www-data:www-data /var/www/html

WORKDIR /var/www/html
EXPOSE 80
EXPOSE 443

RUN chmod +x docker/start.sh

# Start Apache in foreground mode
RUN rm -f /run/apache2/httpd.pid
ENTRYPOINT [ "docker/start.sh" ]
CMD  ["apache2ctl -D FOREGROUND"]
