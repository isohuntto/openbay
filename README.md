openbay
=======
We, the team that brought you https://isohunt.to and http://oldpiratebay.org are bringing you the next step in torrent evolution. The Pirate Bay source code.

Torrent sites like Isohunt and The Pirate Bay gave us lessons that would be a crime to ignore. Individual torrent sites are easy targets. 
Pirate Bay open source code will give absolutely anyone with minimal knowledge of how internet and websites work and some server basic equipment, opportunity to create Pirate Bay copy on his own domain.

Installation
=======

**Step 1. Download source.**

Download the latest engine version at openbay.isohunt.to or at GitHub project web page. 

**Step 2. Upload source to chosen hosting.**

Upload the source code to desirable web hosting following the web hosting guide (in common case there is a CPanel tool) or just use FTP

**Step 3. Unzip source to hosting folder (optional)**

This step is quite optional. It depends on your web hosting. Some hostings can unzip sources automatically some of them allows you to make it manually.

**Step 4. Set hosting environment (optional)**

*Apache*

This option **is available by default** in original source pack. You can see it at `conf/example.htaccess`

*Nginx*

This config is available in original source pack at `/conf/example.nginx.conf`

*Sphinx* (**advanced mode**)

[Instruction here](https://github.com/isohuntto/openbay/wiki/sphinx)

*MySQL* (**advanced mode**)

Before the wizard will run you need to create a data base, the schema of the data base will be created by the wizard. Dump here `/src/protected/data/schema.mysql.sql`

**Step 5. Wizard**

Congrats! Now you can open your domain name with any browser and follow the guide provided there. As default you will need to put page title which will appears on all your webpages.

[Detailed instruction here](https://github.com/isohuntto/openbay/wiki/shared-hosting-guide)

How to contribute?
=======

Report issues , submit pull requests to fix problems, or to create summarized and documented feature requests (preferably with pull requests that implement the feature). 

**Feel free to contribute to the project in any way you like!**
