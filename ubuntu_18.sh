sudo apt install apache2
sudo add-apt-repository ppa:ondrej/php
sudo add-apt-repository ppa:ondrej/apache2
sudo apt-get update
sudo apt install php5.6
sudo apt install php5.6-mysql php5.6-memcached memcached php5.6-xml php5.6-gd php5.6-zip php5.6-mbstring php5.6-opcache

{ \
	echo 'opcache.memory_consumption=128'; \
	echo 'opcache.interned_strings_buffer=8'; \
	echo 'opcache.max_accelerated_files=4000'; \
	echo 'opcache.revalidate_freq=60'; \
	echo 'opcache.fast_shutdown=1'; \
	echo 'opcache.enable_cli=1'; \
	echo 'opcache.enable_file_override=1'; \
} > /etc/php/5.6/apache2/conf.d/opcache-recommended.ini

# directories
sudo mkdir -p /sites/gcconnex/htdocs/elgg
sudo mkdir /sites/gcconnex/elggdata
sudo chown www-data:www-data /sites/gcconnex/htdocs/elgg
sudo chown www-data:www-data /sites/gcconnex/elggdata

sudo -uwww-data git clone https://github.com/gctools-outilsgc/gcconnex.git /sites/gcconnex/htdocs/elgg/

# apache2 site config

sudo a2enmod rewrite
sudo systemctl restart apache2

#LoadModule rewrite_module modules/mod_rewrite.so
#DocumentRoot /sites/gcconnex/htdocs/elgg
#Options Indexes FollowSymLinks
#<Directory "/sites/gcconnex/htdocs/elgg">
#        DirectoryIndex index.php
#        Options FollowSymLinks MultiViews
#        AllowOverride All
#        Order allow,deny
#        allow from all
#	Require all granted
#</Directory>


sudo -uwww-data cp /sites/gcconnex/htdocs/elgg/install/config/htaccess.dist /sites/gcconnex/htdocs/elgg/.htaccess

sudo apt install composer
sudo composer install --no-dev