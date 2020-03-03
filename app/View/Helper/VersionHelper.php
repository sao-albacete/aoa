<?php

App::uses('AppHelper', 'View/Helper');

class VersionHelper extends AppHelper {

    /**
     * Devuelve el contenido del fichero app/View/Elements/version.txt
     */
    public function obtener_version() {
    	// poner el contenido de un fichero en una cadena
		$nombre_fichero = ROOT . DS . "version.txt";
		$gestor = fopen($nombre_fichero, "r");
		$contenido = fread($gestor, filesize($nombre_fichero));
		fclose($gestor);
		return $contenido ? "Versión ".$contenido : "";
    }
}
