<?php

class ImageUtil
{

    /*
     * Available header images
     */
    private static $HEADER_IMAGES = array(
        array('src' => '/img/cabecera/aguila_perdicera1.png', 'alt' => 'Águila perdicera'),
        array('src' => '/img/cabecera/aguila_perdicera2.png', 'alt' => 'Águila perdicera'),
        array('src' => '/img/cabecera/alcaraván2.png', 'alt' => 'Alcaraván'),
        array('src' => '/img/cabecera/alondra_ricoti.png', 'alt' => 'Alondra ricotí'),
        array('src' => '/img/cabecera/alondra_ricoti2.png', 'alt' => 'Alondra ricotí'),
        array('src' => '/img/cabecera/alondra_ricoti3.png', 'alt' => 'Alondra ricotí'),
        array('src' => '/img/cabecera/alondra_ricoti4.png', 'alt' => 'Alondra ricotí'),
        array('src' => '/img/cabecera/buho_chico.png', 'alt' => 'Búho chico'),
        array('src' => '/img/cabecera/cabecinegra_vuelo_f.png', 'alt' => 'Gaviota cabecinegra'),
        array('src' => '/img/cabecera/cabecinegra_vuelo_l.png', 'alt' => 'Gaviota cabecinegra'),
        array('src' => '/img/cabecera/cerceta_pardilla.png', 'alt' => 'Cerceta pardilla'),
        array('src' => '/img/cabecera/chorlito_carambolo.png', 'alt' => 'Chorlito Carambolo'),
        array('src' => '/img/cabecera/combatiente.png', 'alt' => 'Combatiente'),
        array('src' => '/img/cabecera/corredor_sahariano.png', 'alt' => 'Corredor sahariano'),
        array('src' => '/img/cabecera/corredor_sahariano_2.png', 'alt' => 'Corredor sahariano'),
        array('src' => '/img/cabecera/corredor_sahariano_3.png', 'alt' => 'Corredor sahariano'),
        array('src' => '/img/cabecera/curruca_mirlona.png', 'alt' => 'Curruca mirlona'),
        array('src' => '/img/cabecera/escribano_palustre.png', 'alt' => 'Escribano palustre'),
        array('src' => '/img/cabecera/flamenco1.png', 'alt' => 'Flamenco'),
        array('src' => '/img/cabecera/flamenco2.png', 'alt' => 'Flamenco'),
        array('src' => '/img/cabecera/flamenco3.png', 'alt' => 'Flamenco'),
        array('src' => '/img/cabecera/ganga.png', 'alt' => 'Ganga común'),
        array('src' => '/img/cabecera/ganga_2.png', 'alt' => 'Ganga común'),
        array('src' => '/img/cabecera/gangas3.png', 'alt' => 'Ganga común'),
        array('src' => '/img/cabecera/garza_imperial.png', 'alt' => 'Garza imperial'),
        array('src' => '/img/cabecera/gaviota_cabecinegra.png', 'alt' => 'Gaviota cabecinegra'),
        array('src' => '/img/cabecera/gaviota_tridactila.png', 'alt' => 'Gaviota tridáctila'),
        array('src' => '/img/cabecera/hortelano.png', 'alt' => 'Escribano hortelano'),
        array('src' => '/img/cabecera/ortega.png', 'alt' => 'Ortega'),
        array('src' => '/img/cabecera/sison.png', 'alt' => 'Sisón'),
        array('src' => '/img/cabecera/sison_d.png', 'alt' => 'Sisón'),
        array('src' => '/img/cabecera/tarro_blanco2.png', 'alt' => 'Tarro blanco'),
        array('src' => '/img/cabecera/tarro_blanco3.png', 'alt' => 'Tarro blanco'),
        array('src' => '/img/cabecera/tarro_blanco4.png', 'alt' => 'Tarro blanco'),
        array('src' => '/img/cabecera/a_campestris.png', 'alt' => 'Bisbita campestre'),
        array('src' => '/img/cabecera/avetorillo.png', 'alt' => 'Avetorillo'),
        array('src' => '/img/cabecera/barnacla.png', 'alt' => 'Barnacla cariblanca'),
        array('src' => '/img/cabecera/chorlito', 'alt' => 'Alvaraván'),
        array('src' => '/img/cabecera/chorlito_carambolo2.png', 'alt' => 'Chorlito carambolo'),
        array('src' => '/img/cabecera/chorlito_carambolo_d.png', 'alt' => 'Chorlito carambolo'),
        array('src' => '/img/cabecera/chorlito_carambolo_j.png', 'alt' => 'Chorlito carambolo'),
        array('src' => '/img/cabecera/colipintas.png', 'alt' => 'Aguja colipinta'),
        array('src' => '/img/cabecera/corredor_sahariano_4.png', 'alt' => 'Corredor sahariano'),
        array('src' => '/img/cabecera/flamenco4.png', 'alt' => 'Flamenco'),
        array('src' => '/img/cabecera/gangas.png', 'alt' => 'Ganga común'),
        array('src' => '/img/cabecera/inornatus.png', 'alt' => 'Mosquitero bilistado'),
        array('src' => '/img/cabecera/limicolas.png', 'alt' => 'Limícolas'),
        array('src' => '/img/cabecera/nyroca.png', 'alt' => 'Porrón pardo'),
        array('src' => '/img/cabecera/nyroca.png', 'alt' => 'Porrón pardo'),
        array('src' => '/img/cabecera/p_collaris.png', 'alt' => 'Acentor alpino'),
        array('src' => '/img/cabecera/pescadora.png', 'alt' => 'Águila pescadora'),
        array('src' => '/img/cabecera/rabilargo.png', 'alt' => 'Rabilargo'),
        array('src' => '/img/cabecera/zarcero_palido.png', 'alt' => 'Zarcero pálido'),
    );

    /**
     * Return random images for header
     *
     * @param int $imagesNumber
     * @return array
     */
    public static function getHeaderImages($imagesNumber = 3)
    {
        $headerImages = array();
        $selectedIndexes = array();
        
        while(count($headerImages) < $imagesNumber) {
            
            $randomIndex =  rand(0, count(self::$HEADER_IMAGES) - 1);
            
            if(!in_array($randomIndex, $selectedIndexes)) {
                $headerImages[] = self::$HEADER_IMAGES[$randomIndex];
                $selectedIndexes[] = $randomIndex;
            }
        }
        
        return $headerImages;
    }
}