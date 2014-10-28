#!/usr/bin/env bash

# ---------------------------------------------------------------
# NFQ Penktos komandos vagrant setupas.
# Padarytas pagal: https://www.dropbox.com/s/bsil21u5f9sqy2p/%5BNFQ%20Akademija%5D%20Serverio%20diegimas.pdf
# Ant ubuntu padarom: sudo apt-get install nfs-kernel-server nfs-common portmap
# ---------------------------------------------------------------

export DEBIAN_FRONTEND=noninteractive

# Update repo.
apt-get update

# Install nfs deamon
apt-get -y install nfs-common portmap

# Install apache2
apt-get -y install apache2

# Disable default virtual host.
a2dissite 000-default

# Link vagrant dir with www.
rm -rf /var/www
ln -fs /vagrant /var/www

# Install php5.
apt-get -y install php5-cli php5 php5-mcrypt php5-intl php5-curl
apt-get -y install php5-xdebug php5-mysql php5-gd 

# Enable mcrypt.
sudo php5enmod mcrypt

# Configure mysql root password and install mysql server.
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password 123'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password 123'
sudo apt-get -y install mysql-server mysql-client

# Configure php5 timezone.
echo "date.timezone = Europe/Vilnius" >> /etc/php5/mods-available/custom.ini
ln -s /etc/php5/mods-available/custom.ini /etc/php5/cli/conf.d/custom.ini
ln -s /etc/php5/mods-available/custom.ini /etc/php5/apache2/conf.d/custom.ini

# Enable apache2 rewrite module.
a2enmod rewrite php5

# Install git.
apt-get -y install git 

# Install composer.
apt-get -y install curl
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Install phpmyadmin
# sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/dbconfig-install boolean true'
# sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/app-password-confirm password 123'
# sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/admin-pass password 123'
# sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/app-pass password 123'
# sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2'﻿
# apt-get -q -y install phpmyadmin

# Configure apache2 virtualhosts.
echo "<VirtualHost *:80> 
 DocumentRoot \"/var/www/web\" 
 ServerName receptai.dev 
 <Directory /var/www/web> 
 Options Indexes FollowSymLinks MultiViews 
 AllowOverride All
 Require all granted
 </Directory> 
 ErrorLog /var/log/apache2/receptai.error.log 
 CustomLog /var/log/apache2/receptai.access.log combined 
</VirtualHost>" >> /etc/apache2/sites-available/receptai.conf

# Enable virtual website.
a2ensite receptai

# Reload apache2
service apache2 restart 
