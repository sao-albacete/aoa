Anuario Ornitológico Online (AOA)
===

# Introducción
El Anuario Ornitológico de Albacete (AOA) online es una herramienta que te permite consultar citas de aves desde que se tienen registros hasta la actualidad así como añadir las tuyas propias.

# Instalación
AOA está desarrollado usando la siguientes tecnologías:

 - PHP
 - CakePHP framework (versión 2.x)
 - 

## Requisitos
Para poder instalar AOA en tu entorno local necesitas tener instalado:
 - Apache 2
 - MySQL 5.x
 - PHP 5.x
## Instalación del entorno LAMP
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
Para instalar la versión 5.3 de PHP en tu equipo puedes ejecutar los siguientes comandos desde tu consola:

> La compatibilidad con PHP 7 no ha sido probada. Dado que la versión que viene por defecto en la versión 18.04 de Ubuntu es la 7, es necesario instalar un nuevo repositorio en tu equipo:

    $ sudo add-apt-repository -y ppa:ondrej/php
    $ sudo apt update
    $ sudo apt install php5.6
También son necesario instalar algunos paquetes adicionales:

    $ sudo apt-get install php5.6-mbstring php5.6-mcrypt php5.6-mysql php5.6-xml php5.6-curl php5.6-zip

Para ver todo el proceso completo de instalación de la pila LAMP más en detalle puedes consultar [este enlace](https://www.digitalocean.com/community/tutorials/como-instalar-en-ubuntu-18-04-la-pila-lamp-linux-apache-mysql-y-php-es).

# Contribuye



