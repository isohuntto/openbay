openbay
=======
Laget som gav dig [isoHunt] (https://isohunt.to) och [oldpiratebay.org] (http://oldpiratebay.org) ger dig det nyaste i torrentens evolution: källkoden till The Pirate Bay.

Torrentsajter som isoHunt och The Pirate Bay lärde oss saker som skulle vara ett brott att ignorera. Enstaka torrentsiter är enkla mål. Denna kod kommer att göra det möjligt för personer med minimala IT-kunskaper och grundläggande serverutrustning att skapa en Pirate Bay-klon på deras egna domän.

Vi vill ge dig en möjlighet att säga vad du tycker, vara med och bestämma och delta i utvecklingen av oldpiratebay.org. En hel del förfrågningar mottogs för många olika funktioner, men vi vill framhäva utvecklingsprocessen så vi kallar till varje medlem i denna enorma och hängiven samfundet att skapa nya [funktioner] (https://openbay.uservoice.com/forum/279139-ideas) och hjälpa till att utveckla dessa funktioner.

Vi kallar på torrentcommunityn att delta i att utveckla och förbättra denna site för att skapa någonting som varje användare runt om i världen skulle vilja använda.


Installation
=======

** Steg 1. Hämta källkoden. **

Ladda ner den senaste versionen av källkoden på openbay.isohunt.to eller på OpenBays projektsida på GitHub.

** Steg 2. Ladda upp till ditt webbhotell. **

Ladda upp källkoden till din hemsida med hjälp av kontrollpanelen (oftast kan man använda CPanel) eller FTP.

** Steg 3. Öppna upp mappen till din hostingmapp **

Vissa webbhotell gör det här automatiskt, andra kräver att du gör det själv.

** Steg 4. Ställ in din hosting-miljö (tillval) **

* Apache *

Detta alternativ ** är tillgängligt som standard ** i källkodsmappen. Du kan se det i `conf/example.htaccess`

* Nginx *

Konfigurationsfiler för Nginx finns i källkodsmappen: `/ conf / example.nginx.conf`

* Sphinx * (** avancerat**)

[Instruktioner] (https://github.com/isohuntto/openbay/wiki/sphinx)

* MySQL * (** avancerat **)

Innan du kör guiden behöver du skapa en databas, så kommer guiden att
skapa
SQL-schemat. Databasdumpen kan hittas här: `/ src / protected / data / schema.mysql.sql`

** Steg 5. Wizard **

Öppna din hemsida och följ guiden. Du kommer behöva
sätta en titel som kommer att visas på alla hemsidans sidor.

[Detaljerade instruktioner] (https://github.com/isohuntto/openbay/wiki/shared-hosting-guide)

Hur att kan jag bidra till projektet?
==================

Ställ frågor, skicka pull-requests för att åtgärda problem, eller för att lägga till önskade funktioner (helst med kod som implementerar
funktionen).

** Bidra gärna till projektet! **