<?php

class ImageUtil
{

    /*
     * Available header images
     */
    private static $HEADER_IMAGES = [
        ['src' => '/img/cabecera/aguila_perdicera1.jpg', 'alt' => 'Águila perdicera'],
        ['src' => '/img/cabecera/aguila_perdicera2.jpg', 'alt' => 'Águila perdicera'],
        ['src' => '/img/cabecera/alcaravаn2.jpg', 'alt' => 'Alcaraván'],
        ['src' => '/img/cabecera/alondra_ricoti.jpg', 'alt' => 'Alondra ricotí'],
        ['src' => '/img/cabecera/alondra_ricoti2.jpg', 'alt' => 'Alondra ricotí'],
        ['src' => '/img/cabecera/alondra_ricoti3.jpg', 'alt' => 'Alondra ricotí'],
        ['src' => '/img/cabecera/alondra_ricoti4.jpg', 'alt' => 'Alondra ricotí'],
        ['src' => '/img/cabecera/buho_chico.jpg', 'alt' => 'Búho chico'],
        ['src' => '/img/cabecera/cabecinegra_vuelo_f.jpg', 'alt' => 'Gaviota cabecinegra'],
        ['src' => '/img/cabecera/cabecinegra_vuelo_l.jpg', 'alt' => 'Gaviota cabecinegra'],
        ['src' => '/img/cabecera/cerceta_pardilla.jpg', 'alt' => 'Cerceta pardilla'],
        ['src' => '/img/cabecera/chorlito_carambolo.jpg', 'alt' => 'Chorlito Carambolo'],
        ['src' => '/img/cabecera/combatiente.jpg', 'alt' => 'Combatiente'],
        ['src' => '/img/cabecera/corredor_sahariano.jpg', 'alt' => 'Corredor sahariano'],
        ['src' => '/img/cabecera/corredor_sahariano_2.jpg', 'alt' => 'Corredor sahariano'],
        ['src' => '/img/cabecera/corredor_sahariano_3.jpg', 'alt' => 'Corredor sahariano'],
        ['src' => '/img/cabecera/curruca_mirlona.jpg', 'alt' => 'Curruca mirlona'],
        ['src' => '/img/cabecera/escribano_palustre.jpg', 'alt' => 'Escribano palustre'],
        ['src' => '/img/cabecera/flamenco1.jpg', 'alt' => 'Flamenco'],
        ['src' => '/img/cabecera/flamenco2.jpg', 'alt' => 'Flamenco'],
        ['src' => '/img/cabecera/flamenco3.jpg', 'alt' => 'Flamenco'],
        ['src' => '/img/cabecera/ganga.jpg', 'alt' => 'Ganga común'],
        ['src' => '/img/cabecera/ganga_2.jpg', 'alt' => 'Ganga común'],
        ['src' => '/img/cabecera/gangas3.jpg', 'alt' => 'Ganga común'],
        ['src' => '/img/cabecera/garza_imperial.jpg', 'alt' => 'Garza imperial'],
        ['src' => '/img/cabecera/gaviota_cabecinegra.jpg', 'alt' => 'Gaviota cabecinegra'],
        ['src' => '/img/cabecera/gaviota_tridactila.jpg', 'alt' => 'Gaviota tridáctila'],
        ['src' => '/img/cabecera/hortelano.jpg', 'alt' => 'Escribano hortelano'],
        ['src' => '/img/cabecera/ortega.jpg', 'alt' => 'Ortega'],
        ['src' => '/img/cabecera/sison.jpg', 'alt' => 'Sisón'],
        ['src' => '/img/cabecera/sison_d.jpg', 'alt' => 'Sisón'],
        ['src' => '/img/cabecera/tarro_blanco2.jpg', 'alt' => 'Tarro blanco'],
        ['src' => '/img/cabecera/tarro_blanco3.jpg', 'alt' => 'Tarro blanco'],
        ['src' => '/img/cabecera/tarro_blanco4.jpg', 'alt' => 'Tarro blanco'],
        ['src' => '/img/cabecera/a_campestris.jpg', 'alt' => 'Bisbita campestre'],
        ['src' => '/img/cabecera/avetorillo.jpg', 'alt' => 'Avetorillo'],
        ['src' => '/img/cabecera/barnacla.jpg', 'alt' => 'Barnacla cariblanca'],
        ['src' => '/img/cabecera/chorlito.jpg', 'alt' => 'Alvaraván'],
        ['src' => '/img/cabecera/chorlito_carambolo2.jpg', 'alt' => 'Chorlito carambolo'],
        ['src' => '/img/cabecera/chorlito_carambolo_d.jpg', 'alt' => 'Chorlito carambolo'],
        ['src' => '/img/cabecera/chorlito_carambolo_j.jpg', 'alt' => 'Chorlito carambolo'],
        ['src' => '/img/cabecera/colipintas.jpg', 'alt' => 'Aguja colipinta'],
        ['src' => '/img/cabecera/corredor_sahariano_4.jpg', 'alt' => 'Corredor sahariano'],
        ['src' => '/img/cabecera/flamenco4.jpg', 'alt' => 'Flamenco'],
        ['src' => '/img/cabecera/gangas.jpg', 'alt' => 'Ganga común'],
        ['src' => '/img/cabecera/inornatus.jpg', 'alt' => 'Mosquitero bilistado'],
        ['src' => '/img/cabecera/limicolas.jpg', 'alt' => 'Limícolas'],
        ['src' => '/img/cabecera/nyroca.jpg', 'alt' => 'Porrón pardo'],
        ['src' => '/img/cabecera/nyroca.jpg', 'alt' => 'Porrón pardo'],
        ['src' => '/img/cabecera/p_collaris.jpg', 'alt' => 'Acentor alpino'],
        ['src' => '/img/cabecera/pescadora.jpg', 'alt' => 'Águila pescadora'],
        ['src' => '/img/cabecera/rabilargo.jpg', 'alt' => 'Rabilargo'],
        ['src' => '/img/cabecera/zarcero_palido.jpg', 'alt' => 'Zarcero pálido'],
    ];

    /**
     * Return random images for header
     *
     * @param int $imagesNumber
     * @return array
     */
    public static function getHeaderImages($imagesNumber = 3)
    {
        $headerImages = [];
        $selectedIndexes = [];
        
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