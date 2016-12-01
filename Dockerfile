FROM ubuntu:14.04
MAINTAINER Luc Belliveau <luc.belliveau@nrc-cnrc.gc.ca>

# Install dependencies
RUN apt-get update
RUN apt-get install -y git apache2 php5 libapache2-mod-php5 php5-mysql php5-gd php5-curl

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Modify Apache config
WORKDIR /etc/apache2/sites-available
RUN echo '<Directory /var/www/html>\nOptions Indexes FollowSymLinks MultiViews\nAllowOverride All\nOrder allow,deny\nallow from all\n</Directory>\n' | sed '/^<VirtualHost \*:80>/r /dev/stdin' 000-default.conf > tmp
RUN mv tmp 000-default.conf
WORKDIR /var/www/html

# Start Apache in foreground mode
CMD /usr/sbin/apache2ctl -D FOREGROUND

