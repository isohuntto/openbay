openbay
=======
Nosotros, el equipo que te trajo https://isohunt.to y http://oldpiratebay.org , te traemos el próximo paso en la evolución de torrent. El código fuente de The Pirate Bay.

Sitios torrent como Isohunt y The Pirate Bay nos han dado lecciones las cuales sería un crimen ignorar. Los sitios torrent individuales son objetivos fáciles.
El código abierto de Pirate Bay otorga a cualquier persona con un conocimiento mínimo sobre como funcionan Internet, los sitios web y los servidores web la oportunidad de crear una copia de Pirate Bay en su propio dominio.

Instalación
=======

**Paso 1. Descargar el código fuente.**

Descarga la última versión del motor en openbay.isohunt.to o en la web de proyecto GitHub.

**Paso 2. Sube el código fuente al host de tu elección.**

Sube el código fuente a un hosting web siguiendo las instrucciones proporcionadas por él (normalmente la herramienta CPanel está disponible) o utiliza FTP.

**Paso 3. Descomprime el código fuente a la carpeta del host (opcional)**

Este paso es opcional. Depende de tu hosting web. Algunos host pueden descomprimir automáticamente los ficheros zip y otros te pueden obligar a hacerlo a mano.

**Paso 4. Define el entorno de hosting (opcional)**

*Apache*

Esta opción **está disponible por defecto** en el código fuente original. Puedes verla en `conf/example.htaccess`

*Nginx*

Esta configuración está disponible en el código fuente original en `/conf/example.nginx.conf`

*Sphinx* (**avanzado**)

[Instrucciones aquí](https://github.com/isohuntto/openbay/wiki/sphinx)

*MySQL* (**avanzado**)

Antes de ejecutar el asistente debes de crear una base de datos, y el esquema de la base de datos será creado por el asistente. El fichero de volcado se encuentra en `/src/protected/data/schema.mysql.sql`

**Paso 5. Asistente**

Felicidades! Ahora puedes abrir tu dominio web en cualquier navegador y seguir las instrucciones proporcionadas en la página. Por defecto necesitas decir el título que quieres que aparezca en las páginas de tu web.

[Instrucciones detalladas aquí](https://github.com/isohuntto/openbay/wiki/shared-hosting-guide)

¿Cómo colaborar?
=======

Reporta problemas, envía peticiones pull para arreglar errores, o para crear peticiones resumidas y documentadas solicitando una nueva funcionalidad (preferiblemente con una petición pull the implemente la funcionalidad)

**Siéntete libre de contribuir al proyecto de cualquier manera que te guste!**
