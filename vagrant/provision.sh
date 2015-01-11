#! /usr/bin/env bash

set -u	# exit if using uninitialised variable
set -e	# exit if some command in this script fails
trap "echo $0 failed because a command in the script failed" ERR

# The directory containing this script.
# We can't auto-detect this script's path (e.g. `readlink -f "$0"`)
# because Vagrant runs provisionsers from /tmp/vagrant-shellxxx.sh
VAGRANT_DIR=/vagrant/vagrant
REPO_ROOT=`dirname "$VAGRANT_DIR"`


apt-get install -y \
	apache2 \
	php5 php5-mysql libapache2-mod-php5


# run Apache as the ‘vagrant’ user & group so it can write to the filesystem
sed \
        -e 's/^export APACHE_RUN_USER=.*$/export APACHE_RUN_USER=vagrant/' \
        -e 's/^export APACHE_RUN_GROUP=.*$/export APACHE_RUN_GROUP=vagrant/' \
        -i /etc/apache2/envvars

# configure Apache to serve this repository
# allow the rules in the repo's .htaccess files
REPO_WEB_ROOT="$REPO_ROOT"/src/www
APACHE_WEB_ROOT=/var/www/openbay
ln -s "$REPO_WEB_ROOT" "$APACHE_WEB_ROOT"
sed \
        -e 's+DocumentRoot /var/www/html+DocumentRoot '"$APACHE_WEB_ROOT"'+' \
        -e 's+^</VirtualHost>$+\
        <Directory '"$APACHE_WEB_ROOT"'>\
                AllowOverride All\
        </Directory>\
</VirtualHost>+' \
        -i /etc/apache2/sites-enabled/000-default.conf

a2enmod rewrite
service apache2 restart


# At the time of writing (Jan 2015) IsoHunt's remote sphinx is down.
# Installing it locally.
"$VAGRANT_DIR"/sphinx.sh
