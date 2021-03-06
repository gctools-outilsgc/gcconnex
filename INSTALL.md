## Installation instructions
**Note: GCconnex does not work with PHP7 - GCconnex ne fonctionne pas avec PHP7**

### Ubuntu 14.04
#### Install Aptitude
    sudo apt-get update
    sudo apt-get install aptitude
#### Install Git, Apache, MySQL, PHP and libs
    sudo aptitude install git apache2 mysql-server php5 libapache2-mod-php5 php5-mysql php5-gd
When prompted, enter a root password for MySQL.

#### Fork and Clone GCConnex Github Repo
    git clone -b gcconnex https://github.com/gctools-outilsgc/gcconnex.git

#### Install Composer 
Setup [Composer](https://getcomposer.org/download/): 
Download the install off the site. Default name of the file is "installer"
Go into the directory the file was downloaded to (Example: cd /home/username/Downloads).

    sudo php installer --install-dir=/bin --filename=composer
    
#### Composer Dependencies
Go into your gcconnex directory. (Example: cd /home/username/gcconnex)

    composer install

#### Create data directory
Create a data directory, not in the gcconnex directory!

    mkdir gcconnex_data
Example Location: /home/username/gcconnex_data

#### Set permissions
    chmod 777 gcconnex
    chmod 777 gcconnex/engine
    chmod 700 gcconnex_data
    sudo chown www-data:www-data gcconnex_data

#### Create link to gcconnex in /var/www/html folder
    cd /var/www/html/
    sudo ln -s /EXAMPLE/PATH/TO/gcconnex gcconnex

#### Create a database and a user for the database
    mysql -u root -p
    CREATE DATABASE gcconnexdb;
    GRANT ALL ON gcconnexdb.* TO gcconnex@localhost IDENTIFIED BY 'password';
    QUIT;
Choose a better password

#### Enable mod_rewrite in Apache
    sudo a2enmod rewrite
    sudo nano /etc/apache2/sites-available/000-default.conf

Add the following inside the ```<VirtualHost *:80></VirtualHost>``` tag
```
<Directory /var/www/html/gcconnex>
  Options Indexes FollowSymLinks MultiViews
  AllowOverride All
  Order allow,deny
  allow from all
</Directory>
```

Save and close (Ctrl-o then Ctrl-x if you are using nano)

    sudo service apache2 restart

#### Install Elgg
Goto ```http://localhost/gcconnex```.  Follow instructions.  You will need to enter the database information and the path to the data folder.

#### Reset permissions
    chmod 775 gcconnex
    chmod 775 gcconnex/engine

#### Configure Plugins
The final step to getting the GCconnex experience is to reorder and
enable/disable plugins in the Administration section of your installation.

A quick way to sort and activate plugins in the correct order is to activate
the "Plugin Loader" plugin. Do this by going into `Configure`-> `Plugins` -> ctrl+f `Plugin Loader` -> `Activate`
Then go to
`Configure`->`Utilities`->`Plugin Loader` menu and click on the `Import`
button.

The plugin_config file has `friend_request` as enabled, but for an unknown reason does not activate it properly. So go into `Configure` -> `Plugins` and ctrl+f for `Friend Request` and activate `Friend request 4.0`

### Elgg Installation Instructions
http://learn.elgg.org/en/1.x/intro/install.html
