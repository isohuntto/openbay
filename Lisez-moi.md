openbay
=======
Nous, l'équipe qui vous a apporté https://isohunt.to et http://oldpiratebay.org vous apportons la prochaine étape dans l'évolution du torrent. Le code source de "The Pirate Bay".

Les sites de torrent tel qu'Isohunt et The Pirate Bay nous ont donné des leçons qu'il serait criminel d'ignorer. Les sites de torrent individuels sont des cibles faciles.
Le code source libre de Pirate Bay donnera à absolument toutes les personnes avec un minimum de connaissances sur le fonctionnement d'internet et des sites web ainsi que le matériel de base d'un serveur, la possibilité de créer une copie de Pirate Bay sur son propre domaine. 

Installation
=======

**Étape 1. Télécharger les sources.**

Téléchargez la dernière version du projet sur openbay.isohunt.to ou bien sur la page du projet GitHub.

**Étape 2. Envoyer les sources sur l'hébergement choisi.**

Envoyez le code sources sur l'hébergement web souhaité en suivant les indication du guide de l'hébergeur (Il y a en général un outil Panneau de Contrôle) ou bien utilisez directement le FTP.

**Étape 3. Désarchiver les sources sur le dossier hébergé. (facultatif)**
Cette étape peut être optionnelle. Cela dépend de votre hébergeur. Certain peuvent désarchiver les sources automatiquement, d'autres vous permettent seulement de le faire manuellement.

**Étape 4. Paramétrer l'environnement de l'hébergement. (facultatif)**

*Apache*

Cette option **est disponible par défaut** dans l'archive du code source d'origine. Vous la trouverez dans le fichier `conf/example.htaccess`.

*Nginx*

Cette configuration est disponible dans l'archive du code source original dans le fichier `/conf/example.nginx.conf`.

*Sphinx* (**Mode avancé**)

[Vous pouvez trouver les instruction ici (en Anglais)](https://github.com/isohuntto/openbay/wiki/sphinx)

*MySQL* (**Mode avancé**)

Avant de lancer le paramétrage automatique vous devrez créer une base de données. Le schéma de cette base sera créé automatiquement. L'export est dans le fichier `/src/protected/data/schema.mysql.sql`

**Étape 5. Automatisation.**

Félicitations ! Vous pouvez maintenant vous rendre sur la page de votre domaine avec votre navigateur internet et suivre les indications qui s'y trouve. Par défaut vous devrez entrer un nom de page qui sera le même sur toutes les pages du site.

[Instructions détaillées ici (En anglais)](https://github.com/isohuntto/openbay/wiki/shared-hosting-guide)

Comment contribuer ?
=======

Signalez des problèmes, soumettez des requêtes pour corriger des problèmes ou pour créer fonctionnalités résumées et documentées (avec de préférence l'implémentation de cette fonctionnalité). 

**Libre à vous de contribuer au projet de toutes les manières que vous souhaitez ! **
