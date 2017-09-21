#!/bin/sh
##############################################################
#
# Author: Ruslan Khissamov, email: rrkhissamov@gmail.com
#
##############################################################
# Update System
echo 'System Update'
apt-get -y update
echo 'Update completed'
# Install help app
apt-get -y install libssl-dev git-core pkg-config build-essential curl gcc g++
# Download & Unpack Node.js - v. 0.6.2
echo 'Download Node.js - v. 0.6.2'
mkdir /tmp/node-install
cd /tmp/node-install
wget http://nodejs.org/dist/v0.6.2/node-v0.6.2.tar.gz
tar -zxf node-v0.6.2.tar.gz
echo 'Node.js download & unpack completed'
# Install Node.js
echo 'Install Node.js'
cd node-v0.6.2
./configure && make && make install
echo 'Node.js install completed'
