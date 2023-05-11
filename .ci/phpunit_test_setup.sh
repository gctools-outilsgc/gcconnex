apk --no-cache add \
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
  curl \
  git

curl -sS https://getcomposer.org/installer | php5 -- --install-dir=/usr/local/bin --filename=composer
ln -s /usr/bin/php5 /usr/bin/php

cd /tmp
git clone https://github.com/gctools-outilsgc/gcconnex.git && cd gcconnex

composer config --no-plugins allow-plugins.composer/installers true
composer install

cd mod && ../vendor/bin/phpunit --log-junit /tmp/results.xml
