#!/bin/sh

# automated install
if [ $INIT ]
then
	echo "init detected for $INIT, running install script."
	php /var/www/html/install/cli/docker_installer.php
fi

echo "starting memcached service"
service memcached start

echo "Starting server"
$@
