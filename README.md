Openbay is not supported
=======

Warm greetings to all of our guests!

Isohunt team is closing down the Openbay project support and  the competition itself because of the very low activity on the project. We’ve got hold of the developers that took part in the competition and offered them a long-term cooperation.

We are very disappointed that your activity lowered to such a level that even a 50 000$ reward couldn’t motivate you.

However, if you’re ready to cooperate and work on the project with us, send us an e-mail to openbay@hush.com.

Good code and less bugs to everybody!



CHANGELOG:
----------

- Full migration to Yii2
- Comment module created
- Rating module created
- Complains module created

GETTING STARTED
---------------

The installation steps are tested on virtual machine managed by VirtualBox.
The virtual PC was configured with 2 network cards, the first one attached to NAT, the second one - Host-only adapter. You'll need the IP of host only-adapter to configure host machine, where you're intending to develop and test openbay. If the second adapter wasn't configured automatically - edit */etc/network/interfaces* file by adding
```
auto eth1
iface eth1 inet static
address 192.168.56.101
netmask 255.255.255.0
```
Then restart.

By default VirtualBox Host-only network address is 192.168.56.*. If not - refer to Linux networking and VirtualBox documentation.
#### Operating system

Install Ubuntu 14.04 32-bit minimal from [here](https://help.ubuntu.com/community/Installation/MinimalCD) on your virtual pc. To reduce system overhead, do not install packets which are not necessary for you. In this case, to control installation, only *Basic Server* and *OpenSSH Server* are chosen. During installation create user named, for example, **openpirate**. The installation is quite trivial, for details visit [official site](https://help.ubuntu.com/community/Installation/MinimalCD).

#### Install some useful and necessary software
```
$ sudo apt-get update
$ sudo apt-get install git curl
```
This will install curl and git to your system.

#### Checkout working copy
If you want to checkout to different path - fix path in configs.
*TODO: Change repo name after merge pull-request*
```
$ mkdir ~/www/
$ cd ~/www/
$ git clone https://github.com/profezz/openbay.git --branch manual
```
#### LNMP stack (nginx + apache + php)
For using OpenBay you need LNMP stack. The installation of nginx, mysql and PHP-fpm will be described in this section. If you want to use other stack (for example LAMP) refer to official documentation.

##### Nginx
[Nginx](http://nginx.com/) is a high performance scalable web-server.
Install it by typing
```
$ sudo apt-get install nginx
```
Change server run user to **openpirate** in */etc/nginx/nginx.conf*.

Copy nginx config file from working copy to */etc/nginx/sites-available/opb*. Edit paths if necessary.
```
sudo cp ~/www/openbay/environments/dev/conf/nginx.conf /etc/nginx/sites-available/opb.conf
```
Create symlink in */etc/nginx/sites-enabled/*
```
$ sudo ln -s /etc/nginx/sites-available/opb.conf /etc/nginx/sites-enabled/001-opb.conf
```
Make logs dir
```
mkdir ~/www/logs
```
Now restart nginx.
```
$ sudo service nginx restart
```
##### Mysql
You will need both mysql-server and mysql-client to make Openbay work.
```
$ sudo apt-get install mysql-server-5.5 mysql-client
```
Root password will be prompted during installation.
##### PHP
This manual describes how to install php-fpm. If you want to use FastCGI refer to PHP documentation.

Install PHP with necessary modules
```
$ sudo apt-get install php5-fpm php5-memcached php-pear php5-redis php5-dev php5-mysql php5-mcrypt php5-intl
```
Change FPM user and group and FPM socket owner and group from www-data to openpirate in */etc/php5/fpm/pool.d/www.conf*

Also, you'll have to install *igbinary* extension manually.
```
$ sudo pecl install -Z igbinary
```
And create and link necessary files:
- create /etc/php5/mods-available/igbinary.ini with following content:
```
extension=igbinary.so
```
- Create symlinks for CLI and FPM config files
```
$ sudo ln -s /etc/php5/mods-available/igbinary.ini /etc/php5/cli/conf.d/10-igbinary.ini
$ sudo ln -s /etc/php5/mods-available/igbinary.ini /etc/php5/fpm/conf.d/10-igbinary.ini
$ sudo ln -s /etc/php5/mods-available/mcrypt.ini /etc/php5/cli/conf.d/10-mcrypt.ini
$ sudo ln -s /etc/php5/mods-available/mcrypt.ini /etc/php5/fpm/conf.d/10-mcrypt.ini
```

Now, restart FPM
```
$ sudo service php5-fpm restart
```
#### Sphinx
[Sphinx](http://sphinxsearch.com/) is powerful and flexible search engine used in Openbay.

Download sphinxsearch from official site
```
$ wget http://sphinxsearch.com/files/sphinxsearch_2.2.7-release-0ubuntu12~precise_i386.deb
```
Install sphinx
```
$ sudo apt-get install libodbc1 libpq5
$ sudo dpkg -i sphinxsearch_2.2.7-release-0ubuntu12~precise_i386.deb
```
Stop the daemon
```
$ sudo searchd --stop
```
Move sphinx config to */etc/sphinx*
```
$ sudo cp ~/www/openbay/environments/dev/conf/sphinx.conf /etc/sphinxsearch/sphinx.conf
```
#### Redis
The server user for caching.
```
$ sudo apt-get install redis-server
```
#### composer
Now install [composer](http://getcomposer.org/).
```
$ curl -s http://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/composer
```

#### Initializing project
Go to sources folder
```
$ cd ~/www/openbay/
```
You need to install composer bower plugin
```
$ composer global require "fxp/composer-asset-plugin:1.0.0"
```
And get vendor packages
```
$ composer update
```
Due to bower assets it can take long time.

Also, composer can require your github credentials.

Now create database
```
$ mysql -uroot -p
mysql> create database opb default character set utf8;
mysql> grant all on opb.* to opb@'%' identified by 'opb';
```

Initialize project by running
```
$ cd ~/www/openbay
$ php init
```
Fill salts and reCaptcha key in *~/www/openbay/frontend/config/main-local.php*

Apply migrations
```
$ ./yii migrate
$ ./yii migrate --migrationPath=@frontend/modules/comment/migrations
$ ./yii migrate --migrationPath=@frontend/modules/complain/migrations
$ ./yii migrate --migrationPath=@frontend/modules/rating/migrations
```

Now you can rebuild sphinx indices
```
$ sudo indexer --all
```
And run sphinx
```
$ sudo killall searchd
$ sudo searchd
```

Due to sphinx config it seems that only delta index should be rotated on data change
```
$ indexer --rotate npbtorrents_delta
```

And now Openbay is installed. To test it you need some actions on host machine. Append the following line to */etc/hosts* file:
```
192.168.56.101 opb.virt
```
And you can test your developer copy of Openbay by typing *http://opb.virt* in your browser.

LEGACY CODE
----------
Thus, we’re refusing to support an old version. However, those wishing to develop an old version of OpenBay by themselves can still access it in the [master-1.0 branch](https://github.com/isohuntto/openbay/tree/master-1.0).

P.S. Also, all our team wants to bring our sincere apologies to all those who had been waiting so long for our update and to thank all those who was so patient to wait till it was finally released!
