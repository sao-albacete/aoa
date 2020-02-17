#!/bin/bash

# Define a timestamp function
timestamp() {
  date +%s
}

# Introduzca la rama a descargar
echo Introduzca la rama desde donde desea desplegar el código: \(master\)

read git_repo_branch

if [[ $git_repo_branch == "" || $git_repo_branch == null ]]; then
	git_repo_branch="master"
fi

# Introduzca el nombre de la carpeta actual donde tiene desplegado el anuario
echo Introduzca el nombre de la carpeta actual donde tiene desplegado el anuario: \(web\)

read deploy_folder

if [[ $deploy_folder == "" || $deploy_folder == null ]]; then
	deploy_folder="web"
fi

# Descargar el código del repositorio de GIT
echo Descargando código del repositorio \"https://github.com/sao-albacete/aoa\"...
git clone https://github.com/sao-albacete/aoa.git --branch $git_repo_branch --single-branch --depth 1

# Copiar contenido de la carpeta app/webroot/img/users al nuevo despliegue
echo Copiando contenido de la carpeta app/webroot/img/users al nuevo despliegue...
cp -r web/app/webroot/img/users/ aoa/app/webroot/img/users/

# Copiar fichero app/Config/core.php al nuevo despliegue
echo Copiando fichero app/Config/core.php al nuevo despliegue...
cp web/app/Config/core.php aoa/app/Config/core.php

# Copiar fichero app/Config/database.php al nuevo despliegue
echo Copiando fichero app/Config/database.php al nuevo despliegue...
cp web/app/Config/database.php aoa/app/Config/database.php

# Copiar fichero app/Config/email.php al nuevo despliegue
echo Copiando fichero app/Config/email.php al nuevo despliegue...
cp web/app/Config/email.php aoa/app/Config/email.php

# Copiar el directorio /tmp
echo Copiando directorio app/tmp...
cp -r web/app/tmp/ aoa/app/tmp/

# Cambiando permisos de la carpeta del nuevo despliegue
echo Cambiando permisos de la carpeta del nuevo despliegue...
chmod -R 775 aoa

# Cambiando propietarios de la carpeta del nuevo despliegue
echo Cambiando propietarios de la carpeta del nuevo despliegue...
chown -R www-data:"$USER" aoa

# Renombrar despliegue actual a modo de backup
echo Renombrando despliegue actual a modo de backup...
mv $deploy_folder "${deploy_folder}_backup_$(timestamp)"

# Renombrar nuevo despliegue a despliegue oficial
echo Renombrando nuevo despliegue a despliegue oficial...
mv aoa $deploy_folder

echo Proceso finalizado con éxito.
