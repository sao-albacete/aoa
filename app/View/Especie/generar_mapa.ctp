<?php 

	/*
	 * Pintamos el mapa
	 */
	// En la cabecera HTTP indicamos que lo que devolvemos es una imagen 
	// de tipo JPG. Para ello utilizamos el tipo MIME: image/jpg 
	//Header("Content-type: image/png"); 
	// Creamos la imagen a partir de un fichero existente 
	/*$imagenMapa = imagecreatefromjpeg("../webroot/img/mapas/municipiosAB.jpg")
	or die("Error creando la imagen del mapa");
	// Mostramos la imagen 
	imagejpeg($imagenMapa); 
	// Liberamos la memoria que ocupaba la imagen 
	ImageDestroy($imagenMapa);*/
	
	
	/*
	 * Pintamos los circulos
	 */
	$imagenCirculo = imagecreate(50, 50) or die("Error creando la imagen circular"); //Creamos un circulo de 50x50 
	$imagenCirculoFondo = imagecolorallocate($imagenCirculo, 0, 0, 0); // Fondo negro
	$imagenCirculoBorde = imagecolorallocate($imagenCirculo, 0, 0, 0); // Borde negro
	imageellipse($imagenCirculo, 10, 10, 30, 30, $imagenCirculoBorde);
	Header("Content-type: image/png");
	// Mostramos la imagen 
	imagepng($imagenCirculo); 
	// Liberamos la memoria que ocupaba la imagen 
	ImageDestroy($imagenCirculo);
	

?>