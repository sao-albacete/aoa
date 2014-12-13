<?php

App::uses('AppHelper', 'View/Helper');
App::uses('Constants', 'Utility');

class ImportanciaHelper extends AppHelper
{

    /**
     * Concatena los observadores generando links con el nombre y el codigo del observador.
     *
     * @param array $observadores            
     * @return string cadena de links con el nombre y el codigo del observador
     */
    public function getIconoImportancia($importanciaId, $importanciaDescripcion)
    {
        $out = "";
        $icono = "";
        
        switch ($importanciaId) {
            case Constants::IMPORTANCIA_RAREZA_NACIONAL_ID:
                $icono = "rareza_nacional.png";
                break;
            case Constants::IMPORTANCIA_RAREZA_LOCAL_ID:
                $icono = "rareza_local.png";
                break;
            case Constants::IMPORTANCIA_ESP_PROTEGIDA_ID:
                $icono = "especie_protegida.png";
                break;
            case Constants::IMPORTANCIA_ESP_MUY_ESCASA_ID:
                $icono = "especie_escasa.png";
                break;
            case Constants::IMPORTANCIA_RAREZA_NAC_CRIA_PROBABLE_ID:
                $icono = "rareza_cria_probable.png";
                break;
            case Constants::IMPORTANCIA_RAREZA_LOCAL_CRIA_PROBABLE_ID:
                $icono = "rareza_local_cria_probable.png";
                break;
            case Constants::IMPORTANCIA_ESP_PROTEGIDA_CRIA_PROBABLE_ID:
                $icono = "protegida_cria_probable.png";
                break;
            case Constants::IMPORTANCIA_ESP_ESCASA_CRIA_PROBABLE_ID:
                $icono = "escasa_cria_probable.png";
                break;
            case Constants::IMPORTANCIA_RAREZA_NAC_CRIA_SEGURA_ID:
                $icono = "rareza_cria.png";
                break;
            case Constants::IMPORTANCIA_RAREZA_LOCAL_CRIA_SEGURA_ID:
                $icono = "rareza_local_cria.png";
                break;
            case Constants::IMPORTANCIA_ESP_PROTEGIDA_CRIA_SEGURA_ID:
                $icono = "protegida_cria.png";
                break;
            case Constants::IMPORTANCIA_ESP_ESCASA_CRIA_SEGURA_ID:
                $icono = "escasa_cria.png";
                break;
            case Constants::IMPORTANCIA_NO_DESTACADO_ID:
                $icono = "";
                break;
            default:
                $icono = "";
                break;
        }
        
        if (! empty($icono)) {
            $out = "<img src='/img/icons/importancia/$icono' title='$importanciaDescripcion' alt='$importanciaDescripcion'/>";
        }
        
        return $out;
    }
}
