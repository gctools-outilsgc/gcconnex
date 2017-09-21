#!/bin/sh

# Install etherpad-lite
git clone git://github.com/Pita/etherpad-lite.git /usr/share/etherpad-lite
sh /usr/share/etherpad-lite/bin/installDeps.sh

# Configure Etherpad settings
cp settings.json.template /usr/share/etherpad-lite/settings.json
nano /usr/share/etherpad-lite/settings.json

# Create a user called etherpad-lite
useradd -r -d /bin/false etherpad-lite

# Create a log folder for the service /var/log/etherpad-lite
mkdir /var/log/etherpad-lite

# Ensure the etherpad-lite user have full access to the log and the git folder
chown -R etherpad-lite /var/log/etherpad-lite

# Copy following script to /etc/init.d/ and configure the variables
cp ep-daemon /etc/init.d/etherpad-lite

# Make sure the script is marked as executable
chmod +x /etc/init.d/etherpad-lite

# Enable it with
update-rc.d etherpad-lite defaults
