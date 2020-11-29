# Introducción
El Anuario Ornitológico de Albacete (AOA) online es una herramienta que te permite consultar citas de aves desde que se tienen registros hasta la actualidad así como añadir las tuyas propias.

# Herramientas usadas
AOA está desarrollado usando la siguientes tecnologías:
 - PHP (versión 5.x)
 - CakePHP framework (versión 2.x) Más información sobre el framework [aquí](https://book.cakephp.org/2/es/index.html).
 - MySQL (versión 5.x)
 - Apache (versión 2)
 - Booststrap (versión 2) Más información sobre el framework [aquí](https://getbootstrap.com/2.3.2/).
 - jQuery
 - Google Maps API
 - Datatables
 - Geoxml
 - Bootbox
 - jqplot
 - SummerNote (versión 0.8.16 https://summernote.org/)
 - HtmlPurifier (versión 4.12.0 http://htmlpurifier.org)

# Requisitos mínimos
Para poder instalar AOA en tu entorno local necesitas tener instalado:
 - Apache 2
 - MySQL 5.x
 - PHP 5.x
# Instalación del entorno LAMP
A continuación te damos ejemplos de cómo instalar un entorno LAMP en una máquina GNU/Linux basada en Debian.

### Instalar Apache 2
Ejecuta los siguientes comandos desde tu consola:

    $ sudo apt update
    $ sudo apt install apache2

Para obtener una información más detallada puedes consultar [este enlace](https://www.digitalocean.com/community/tutorials/como-instalar-el-servidor-web-apache-en-ubuntu-18-04-es).
### Instalar MySQL
Ejecuta los siguientes comandos desde tu consola:

    $ sudo apt update
    $ sudo apt install mysql-server
    $ sudo mysql_secure_installation
Para obtener una información más detallada puedes consultar [este enlace](https://www.digitalocean.com/community/tutorials/como-instalar-mysql-en-ubuntu-18-04-es).
### Instalar PHP
Para instalar la versión 5.6 de PHP en tu equipo puedes ejecutar los siguientes comandos desde tu consola:

    $ sudo add-apt-repository -y ppa:ondrej/php
    $ sudo apt update
    $ sudo apt install php5.6
También es necesario instalar algunos paquetes adicionales:

    $ sudo apt-get install php5.6-mbstring php5.6-mcrypt php5.6-mysql php5.6-xml php5.6-curl php5.6-zip php5.6-gd

Para ver todo el proceso completo de instalación de la pila LAMP más en detalle puedes consultar [este enlace](https://www.digitalocean.com/community/tutorials/como-instalar-en-ubuntu-18-04-la-pila-lamp-linux-apache-mysql-y-php-es).

En la actualidad, esta aplicación **no es compatible con PHP 7**. Dado que la versión que viene por defecto en la versión 18.04 de Ubuntu es la 7, puede que tengas que cambiar a la versión 5.6, para ello, puedes ejecutar estos comandos:

    $ sudo a2dismod php7.0
    $ sudo a2enmod php5.6
    $ sudo service apache2 restart
    $ sudo ln -sfn /usr/bin/php5.6 /etc/alternatives/php

# Descarga el código
Descarga el código desde este repositorio ejecutando el siguiente comando:

    $ git clone https://github.com/sao-albacete/aoa.git

Este comando te descargará todo el código de la aplicación en una carpeta llamada "aoa". Cámbiate a la carpeta *aoa* y revisa que las siguientes carpetas:

 - aoa/app/tmp/cache
 - aoa/app/tmp/logs
 - aoa/app/tmp/sessions
 - aoa/app/tmp/tests
 - aoa/app/webroot/img/tmp
 - aoa/app/webroot/img/users

Tengan permisos de escritura para el usuario que ejecuta tu servidor web (*www-data*), para asegurate de ello, puedes ejecutar este comando:

    $ sudo chown -R www-data /var/www/html/aoa

# Base de datos
La base de datos del anuario es la pieza clave dónde se almacena toda la información relevante que después es mostrada dinámicamente a través de la web.
## Diseño
![Diagrama de entidad relación de la base de datos del anuario](https://raw.githubusercontent.com/sao-albacete/aoa/master/docs/bd/model.png)
## Inicialización
La aplicación web AOA necesita ejecutarse sobre una base de datos MySQL, por lo que una vez instalado MySQL en tu equipo, deberás crear una base de datos, para ello puedes ejecutar el siguiente comando:

    CREATE DATABASE database_name CHARACTER SET utf8 COLLATE utf8_general_ci;

> "database_name" deberá ser sustituido por el nombre que desees dar a tu base de datos
Después, crea un usuario con el que te conectarás a la base de datos desde la aplicación del anuario. Puedes usar los siguientes comandos:

    mysql> CREATE USER 'user'@'localhost' IDENTIFIED BY 'password';

> Sustituye "username" por el nombre de usuario que quieras y "password" por una contraseña robusta.

    mysql> GRANT ALL PRIVILEGES ON database_name.* TO 'username'@'localhost';
> Sustituye "database-name" por el nombre de tu base de datos y "username" por el nombre de tu usuario

Para aplicar todos los cambios deberás ejecutar:

    mysql> FLUSH PRIVILEGES;

Una vez creada la base de datos, deberás inicializarla:

 - Para inicializar la estructura de la base de datos es necesario ejecutar [este script de SQL](https://github.com/sao-albacete/aoa/blob/master/scripts/db/estructura.sql).
- Para inicializar la información mínima necesaria para arrancar la aplicación web ejecuta [este script de SQL](https://github.com/sao-albacete/aoa/blob/master/scripts/db/datos.sql).

> Una vez tengas las tablas creadas, es recomendable crear un usuario sólo con permisos SELECT e INSERT (en lugar de ALL) por cuestiones de seguridad.

## Configurar la conexión a base de datos
Una vez tengas tu base de datos inicializada y lista, tendrás que configurar la aplicación para que se pueda comunicar con tu base de datos. Para ello tendrás que renombrar el fichero *app/Config/database.php.default* a *app/Config/database.php*.
Después tendrás que editar su contenido, especialmente esta sección:

    public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'user',
		'password' => 'password',
		'database' => 'database_name',
		'prefix' => '',
		//'encoding' => 'utf8',
	);

> Tendrás que sustituir los valores de los campos "login", "password" y "database" por los de tu base de datos.
# Configurar el servidor de correo
Es necesario coenfigurar un sevidor de correo para acciones como: darte de alta en la aplicación o recuperar contraseña.
Para poder configurarlo tendrás que renombrar el fichero *app/Config/email.php.default* a *app/Config/email.php*. Después tendrás que añadir este bloque al final del fichero:

    public $gmail = array(
        'host' => 'ssl://smtp.gmail.com',
        'port' => 465,
        'username' => 'username@domain.com',
        'password' => 'password',
        'transport' => 'Smtp'
    );

> Si tienes cuenta de Gmail, puedes utilizar el propio servidor de correo SMTP de Gmail  como aparece en el ejemplo sustituyendo "username" y "password" por tus credenciales.
# Configuración del servidor web
## Activar reescritura de URL
Un requerimiento para poder ejecutar la aplicación es activar la reescritura de URLs ([URL Rewriting](https://book.cakephp.org/2/en/installation/url-rewriting.html)). Para ello, puedes ejecutar el siguiente comando:

    $ sudo a2enmod rewrite
Y después reiniciar Apache

    $ sudo systemctl restart apache2

## Configurar virtual host
Crear el siguiente fichero (lo puedes llamar *aoa.conf* por ejemplo) en el directorio */etc/apache2/sites-available*

    <VirtualHost *:80>

    	ServerName local.anuario.albacete.org

    	ErrorLog path/to/folder/aoa/app/tmp/logs/server-error.log

    	ServerAdmin user@email.com
        DocumentRoot path/to/folder/aoa/app/webroot

        <Directory path/to/folder/aoa/app/webroot>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Order Allow,Deny
                allow from all
                Require all granted
        </Directory>

    </VirtualHost>

Tras esto, deberás activar el virtual host ejecutando:

    $ a2ensite aoa

Después tendrás que modificar tu fichero */etc/hosts* para añaidr la siguiente línea:

    127.0.0.1 local.anuario.albacete.org

Por último deberán reinicial el servidor Apache de nuevo.

Una vez hecho podrás acceder a la dirección http://local.anuario.albacete.org/ y ¡voilá! ya tendrás instalado el anuario ornitológico de Albacete online en tu máquina local.

# Posibles problemas durante la instalación
## Errores de configuración en la base de datos
Según la versión de MySQL que uses, puedes tener algunos problemas:

- Relacionados con la configuración del charset:
`SQLSTATE[HY000] [2054] Server sent charset unknown to the client`

- Relacionados con el algoritmo de encriptación de la contraseña del usuario de base de datos
`SQLSTATE[HY000] [2054] The server requested authentication method unknown to the client`

Para solucionarlos, prueba a modificar tu fichero de configuración de BD `my.cnf`, ubicado en `/etc/mysql` añadiendo lo siguiente al final del fichero:

```
 [client]
 default-character-set=utf8

 [mysql]
 default-character-set=utf8


 [mysqld]
 collation-server = utf8_unicode_ci
 init-connect='SET NAMES utf8'
 character-set-server = utf8
 default_authentication_plugin= mysql_native_password
```

## Errores inesperados al cargar la página
Si al intentar cargar la página obtienes un mensaje de error indicando que ocurrió un error insperado, puedes consultar estos ficheros de log para averiguar la causa del error:
- aoa/app/tmp/logs/debug.log
- aoa/app/tmp/logs/warning.log
- aoa/app/tmp/logs/error.log

# Licencia
[GNU General Public License v2.0](https://github.com/sao-albacete/aoa/blob/master/LICENSE)

