openbay
=======
We, the team that brought you [isoHunt](https://isohunt.to) and [oldpiratebay.org](http://oldpiratebay.org) bring you the next step in torrent evolution. The Pirate Bay source code.

Torrent sites like isoHunt and The Pirate Bay gave us lessons that would be a crime to ignore. Individual torrent sites are easy targets. This code will enable individuals with minimal IT skills, and basic server equipment to create a Pirate Bay clone on their own domain.

We want to give you an opportunity to speak your mind, determine needs and be active participants in the evolution of the oldpiratebay.org. A lot of requests were received for a wide range of features but we want to emphasize the development process so we call to the colors of this enormous and devoted community to create new [features requests](https://openbay.uservoice.com/forums/279139-ideas) and code those features.

We call out torrent community to join in to develop and enhance this engine to create a modern and advanced website that every user all around the world would want to use. 


Installation
=======

**Step 1. Download source.**

Download the latest version at openbay.isohunt.to or at the GitHub project page.

**Step 2. Upload to your web host.**

Upload the source code to your host using the hosting guide
(in common case there is a CPanel tool) or just use FTP

**Step 3. Unzip source to hosting folder (optional)**

Some hosts can unzip sources automatically, others require you to do it
manually.

**Step 4. Set hosting environment (optional)**

*Apache*

This option **is available by default** in original source pack. You can see it
at `conf/example.htaccess`

*Nginx*

This config is available in original source pack at `/conf/example.nginx.conf`

*Sphinx* (**advanced mode**)

[Instruction here](https://github.com/isohuntto/openbay/wiki/sphinx)

*MySQL* (**advanced mode**)

Before the wizard will run you need to create a database, the wizard will create
the schema. The dump is at `/src/protected/data/schema.mysql.sql`

**Step 5. Wizard**

Open your website and follow the guide provided there. By default, you will need
to put a title which will appear on all the site's pages.

[Detailed instruction here](https://github.com/isohuntto/openbay/wiki/shared-hosting-guide)


Run using Vagrant
=================

This section shows you how to run openbay in an automatically configured VM.
It will use MySQL and SphinxSearch from the remote server provided by IsoHunt.

The scripts in the `vagrant/` directory can also serve as a
concrete working example for setting up your own server.

* Install [Vagrant](https://www.vagrantup.com/) and
[VirtualBox](https://www.virtualbox.org/).
* ```vagrant up```
  * This may take a long time (≈15 min) on the first run because it builds
the Sphinx search index.
* Go to [http://localhost:8008/](http://localhost:8008/)
* Under **General** choose a **Name**
* Use local Sphinx search:
  * At the time of this writing (Jan 2015) the Sphinx server provided by
[http://isohunt.to/openbay/config.json](http://isohunt.to/openbay/config.json)
is down.
To work around this, the vagrant configuration installs Sphinx,
initializes its index from IsoHunt's remote MySQL server
and increases the VM's RAM size to 2.5GB.
  * Under **Sphinx** set **our sphinx configuration** to **OFF** and enter:
    * *host*: **127.0.0.1** (don't use *localhost*, it won't work)
    * *port*: **3306**
* Click **Deploy**

Your new server is running at [http://localhost:8008/](http://localhost:8008/).


How to contribute?
==================

Report issues, submit pull requests to fix problems, or to create summarized and
documented feature requests (preferably with code that implements the
feature).

**Feel free to contribute to the project in any way you like!**
