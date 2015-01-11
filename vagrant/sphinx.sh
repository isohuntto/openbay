#! /usr/bin/env bash

set -u	# exit if using uninitialised variable
set -e	# exit if some command in this script fails
trap "echo $0 failed because a command in the script failed" ERR

# The directory containing this script.
VAGRANT_DIR=/vagrant/vagrant

# https://github.com/isohuntto/openbay/wiki/sphinx says version 2.1.9
# http://sphinxsearch.com/docs/archives/2.1.9/installing-debian.html
apt-get install -y \
	mysql-client unixodbc libpq5 \
	python3

wget http://sphinxsearch.com/files/sphinxsearch_2.1.9-release-0ubuntu11~trusty_amd64.deb
dpkg -i sphinxsearch_*
rm -f sphinxsearch_*

service sphinxsearch stop
cp "$VAGRANT_DIR"/sphinx.conf /etc/sphinxsearch/sphinx.conf
"$VAGRANT_DIR"/sphinx_passwords.py
indexer --all
service sphinxsearch start
