<?php

class ImagenUtil
{
	/**
	 * Constantes
	 */
	const ANCHO_IMAGEN_PREDETERMINADO = 1024;

	const MIME_TYPE_IMAGE_JPEG = "image/jpeg";
	const MIME_TYPE_IMAGE_JPG = "image/jpg";
	const MIME_TYPE_IMAGE_PJPEG = "image/pjpeg";
	const MIME_TYPE_IMAGE_X_PNG = "image/x-png";
	const MIME_TYPE_IMAGE_PNG = "image/png";

	const EXTENSION_JPEG = "jpeg";
	const EXTENSION_JPG = "jpg";
	const EXTENSION_PNG = "png";


	public static function validarImagen($imageType, $imageExtension)
	{
		// Comprobamos si el tipo mime y la extensión están dentro de los permitidos
		if (in_array($imageType, ImagenUtil::obtener_tipos_mime_imagen_permitidos())) {
			if (in_array($imageExtension, ImagenUtil::obtener_extensiones_imagen_permitidas())) {
				return true;
			} else {
				CakeLog::write('error', "La extensión de la imagen " . $imageExtension . " no es válida.");
				return false;
			}
		} else {
			CakeLog::write('error', "El formato de imagen " . $imageType . " no es válido.");
			return false;
		}
	}

	/**
	 * Crea una nueva imagen a partir de una existente
	 *
	 * @param string $imageType Tipo MIME de la imagen
	 * @param string $nombre Path to the image.
	 * @return bool|false|resource an image resource identifier on success, false on errors.
	 */
	public static function crearImagen($imageType, $nombre)
	{
		// JPG
		if ($imageType == self::MIME_TYPE_IMAGE_JPEG || $imageType == self::MIME_TYPE_IMAGE_JPG || $imageType == self::MIME_TYPE_IMAGE_PJPEG) {
			$img_origen = imagecreatefromjpeg($nombre);
		} // PNG
		else if ($imageType == self::MIME_TYPE_IMAGE_X_PNG || $imageType == self::MIME_TYPE_IMAGE_PNG) {
			$img_origen = imagecreatefrompng($nombre);
		} else {
			CakeLog::write('error', "Error creando la imagen con nombre " . $nombre . " y formato " . $imageType);
			return false;
		}

		return $img_origen;
	}

	public static function generarImagen($imagen, $nombre, $imageType)
	{
		// Generamos la nueva imagen redimensionada
		if ($imageType == self::MIME_TYPE_IMAGE_JPEG || $imageType == self::MIME_TYPE_IMAGE_JPG || $imageType == self::MIME_TYPE_IMAGE_PJPEG) {
			imagejpeg($imagen, $nombre);
		} else if ($imageType == self::MIME_TYPE_IMAGE_X_PNG || $imageType == self::MIME_TYPE_IMAGE_PNG) {
			imagepng($imagen, $nombre);
		} else {
			CakeLog::write('error', "Error generando la imagen con nombre " . $nombre . " y formato " . $imageType);
			return false;
		}

		return true;
	}

	public static function redimensionarImagen($imagen, $width = ImagenUtil::ANCHO_IMAGEN_PREDETERMINADO)
	{
		// Obtenemos el ancho y alto de la imagen
		$ancho_origen = imagesx($imagen);
		$alto_origen = imagesy($imagen);

		/*
		 * Seteamos las proporciones
		 */
		// Imagen horizontal
		if ($ancho_origen > $alto_origen && $ancho_origen > $width) {
			$ancho_origen = $width;
			$alto_origen = $width * imagesy($imagen) / imagesx($imagen);
		} // Imagen vertical
		elseif ($alto_origen > $ancho_origen && $alto_origen > $width) {
			$alto_origen = $width;
			$ancho_origen = $width * imagesx($imagen) / imagesy($imagen);
		} // No es necesaria la redimension
		else {
			return $imagen;
		}

		// Creamos el marco donde irá contenida la nueva imagen segun las dimensiones calculadas
		$img_destino = imagecreatetruecolor($ancho_origen, $alto_origen);

		// Redimensionamos la imagen
		imagecopyresized($img_destino, $imagen, 0, 0, 0, 0, $ancho_origen, $alto_origen, imagesx($imagen), imagesy($imagen));

		return $img_destino;
	}

	/**
	 * Devuelve las extensiones permitidas para imágenes
	 */
	public static function obtener_extensiones_imagen_permitidas()
	{
		return array(self::EXTENSION_JPEG, self::EXTENSION_JPG, self::EXTENSION_PNG);
	}

	/**
	 * Devuelve los tipos MIME permitidos para imagenes
	 */
	public static function obtener_tipos_mime_imagen_permitidos()
	{
		return array(self::MIME_TYPE_IMAGE_JPG, self::MIME_TYPE_IMAGE_JPEG, self::MIME_TYPE_IMAGE_PJPEG,
			self::MIME_TYPE_IMAGE_X_PNG, self::MIME_TYPE_IMAGE_PNG);
	}

	/**
	 * Añade una marca de agua a una imagen
	 *
	 * @param resource $imagen
	 * @param string $texto
	 * @return resource Imagen con la marca de agua insertada
	 */
	public static function insertarTexto($imagen, $texto, $xPosicion, $yPosicion)
	{
		$fuente = FONTS . 'arial.ttf';
		$colorNegro = imagecolorallocate($imagen, 0, 0, 0);

		// Dibujamos el texto en la imagen dadas unas coordenadas, una fuente y un color.
		imagefttext($imagen, 11, 0, $xPosicion, $yPosicion, $colorNegro, $fuente, $texto);

		return $imagen;
	}

	public static function insertarImagen($imagen, $stampImageFilename, $stampImageType, $xPosicion, $yPosicion)
	{
		$stampImage = self::crearImagen($stampImageType, $stampImageFilename);

		imagecopy($imagen, $stampImage, $xPosicion, $yPosicion, 0, 0, imagesx($stampImage), imagesy($stampImage));

		return $imagen;
	}

	public static function insertarFondoNeutro($imagen, $xPosicion, $yPosicion)
	{
		$fondo = imagecreate(400, 50);
		imagecolorallocatealpha($fondo, 255, 255, 255, 50);

		imagecopy($imagen, $fondo, $xPosicion, $yPosicion, 0, 0, imagesx($fondo), imagesy($fondo));

		return $imagen;
	}

	public static function obtenerTamanioMaximoImagen() {
		$tamanioMaximo = ini_get('upload_max_filesize');
		if (ini_get('post_max_size') < $tamanioMaximo) {
			$tamanioMaximo = ini_get('post_max_size');
		}
		return $tamanioMaximo;
	}
}
