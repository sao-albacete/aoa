<?php

/**
 * Maneja la información a mostrar el la página de inicio
 *
 * @author vcanizares
 */
class FicheroUtility {

    /**
     * Constantes
     */
    const ANCHO_IMAGEN_PREDETERMINADO = 1024;

    /**
     * Valida que la imagen tenga un formato y extension permitidos y redimensaiona la imagen si es necesario
     *
     * @param string $imageName
     * @param string $imageExtension
     * @param string $imageAbsolutePath
     * @return boolean
     */
    public static function validar_imagen($imageName, $imageExtension, $imageAbsolutePath, $imageType, $imageTmpName, $width=FicheroUtility::ANCHO_IMAGEN_PREDETERMINADO) {

        // Comprobamos si el tipo mime y la extensión están dentro de los permitidos
        if (in_array($imageType, FicheroUtility::obtener_tipos_mime_imagen_permitidos())
        && in_array($imageExtension, FicheroUtility::obtener_extensiones_imagen_permitidas()))
        {
            // Movemos la imagen a la ruta indicada por parametro
            if(move_uploaded_file($imageTmpName, $imageAbsolutePath.$imageName)) {

                // Redimensionamos la imagen al tamaño predeterminado
                if(!FicheroUtility::redimensionar_imagen($imageAbsolutePath.$imageName, $imageType, $width)) {
                    return false;
                }
            }
            else {
                CakeLog::write('error', "Error moviendo la imagen.");
                return false;
            }
        }
        else
        {
            CakeLog::write('error', "Formato o extensión de imagen no válido.");
            return false;
        }

        return true;
    }

    /**
     * Redimensiona una imagen según el ancho indicado por parametro
     *
     * @param string $nombre, nombre y ruta completos de la imagen
     */
    public static function redimensionar_imagen($nombre, $imageType, $width=FicheroUtility::ANCHO_IMAGEN_PREDETERMINADO){

        $img_origen;

        // JPG
        if ($imageType == "image/jpeg" || $imageType == "image/jpg" || $imageType == "image/pjpeg") {
            $img_origen = imagecreatefromjpeg( $nombre );
        }
        // PNG
        else if($imageType == "image/x-png" || $imageType == "image/png") {
            $img_origen = imagecreatefrompng( $nombre );
        }

        // Obtenemos el ancho y alto de la imagen
        $ancho_origen = imagesx( $img_origen );
        $alto_origen = imagesy( $img_origen );

        /*
         * Seteamos las proporciones
         */
        {
            // Imagen horizontal
            if($ancho_origen > $alto_origen && $ancho_origen > $width){
                $ancho_origen = $width;
                $alto_origen = $width * imagesy( $img_origen ) / imagesx( $img_origen );
            }
            // Imagen vertical
            elseif($alto_origen > $ancho_origen && $alto_origen > $width) {
                $alto_origen = $width;
                $ancho_origen = $width * imagesx( $img_origen ) / imagesy( $img_origen );
            }
            // No es necesaria la redimension
            else {
                return true;
            }
        }

        // Creamos el marco donde irá contenida la nueva imagen segun las dimensiones calculadas
        $img_destino = imagecreatetruecolor($ancho_origen ,$alto_origen );

        // Redimensionamos la imagen
        imagecopyresized( $img_destino, $img_origen, 0, 0, 0, 0, $ancho_origen, $alto_origen, imagesx( $img_origen ), imagesy( $img_origen ) );

        // Generamos la nueva imagen redimensionada
        if ($imageType == "image/jpeg" || $imageType == "image/jpg" || $imageType == "image/pjpeg") {
            imagejpeg( $img_destino, $nombre );
        }
        else if($imageType == "image/x-png" || $imageType == "image/png") {
            imagepng( $img_destino, $nombre );
        }

        return true;
    }

    /**
     * Devuelve las extensiones permitidas para imágenes
     */
    public static function obtener_extensiones_imagen_permitidas() {
        return array("jpeg", "jpg", "png");
    }

    /**
     * Devuelve los tipos MIME permitidos para imagenes
     */
    public static function obtener_tipos_mime_imagen_permitidos() {
        return array("image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png");
    }
}

?>