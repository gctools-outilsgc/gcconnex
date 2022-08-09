#!/bin/sh

# automated install
if [ $INIT ]
then
	echo "init detected for $INIT, running install script."
	php5 /var/www/html/install/cli/docker_installer.php
fi

# Start server - depending on the image, one of these will work
echo "Starting server"
$@
