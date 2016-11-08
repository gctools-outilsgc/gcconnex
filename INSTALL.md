## Installation instructions
**Note: GCconnex does not work with PHP7 - GCconnex ne fonctionne pas avec PHP7**

### Ubuntu 14.04
#### Install Git, Apache, MySQL, PHP and libs
    sudo aptitude install git apache2 mysql-server php5 libapache2-mod-php php5-mysql php5-gd
When prompted, enter a root password for MySQL.

#### Fork and Clone GCConnex Github Repo
    git clone -b gcconnex https://github.com/tbs-sct/gcconnex.git

#### Create data directory
    mkdir gcconnex_data

#### Set permissions
    chmod 777 gcconnex
    chmod 777 gcconnex/engine
    chmod 700 gcconnex_data
    sudo chown www-data:www-data gcconnex_data

#### Create link to gcconnex in /var/www/html folder
    cd /var/www/html/
    sudo ln -s /path/to/gcconnex gcconnex

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
The final step to getting the GCconnex experience is to reorder and enable/disable plugins in the Administration section of your installation.

### Elgg Installation Instructions
http://learn.elgg.org/en/1.x/intro/install.html
