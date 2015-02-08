<?php
/* /app/View/Helper/CitaHelper.php */

App::uses('AppHelper', 'View/Helper');

class EspecieHelper extends AppHelper {

    /**
     * Retorna un color de label en funcion del nivel de proteccion en Castilla - La Mancha
     *
     * @see http://twitter.github.io/bootstrap/components.html#labels-badges
     *
     * @param string $codigoProteccionClm
     * @return string
     */
    public function obtener_color_proteccion_clm($codigoProteccionClm) {
        
        $out = "";
        
        switch ($codigoProteccionClm) {
            
            // En peligro
            case 'EN':
                $out = "label-important";
                break;
            // Vulnerable
            case 'VU':
                $out = "label-warning";
                break;
            // No catalogado
            case 'NC':
                $out = "";
                break;
            // Interes especial
            case 'IE':
                $out = "label-info";
                break;
            default:
                $out = "";
                break;
        }
        
        return $out;
    }

    /**
     * Retorna un color de label en funcion del nivel de proteccion en el Libro Rojo de las Aves de España
     *
     * @see http://twitter.github.io/bootstrap/components.html#labels-badges
     *
     * @param string $codigoProteccionLr
     * @return string
     */
    public function obtener_color_proteccion_lr($codigoProteccionLr) {
        
        $out = "";
        
        switch ($codigoProteccionLr) {
            
            // Extinto a nivel regional
            case 'RE':
                $out = "label-inverse";
                break;
            // En peligro crítico
            case 'CR':
                $out = "label-important";
                break;
            // En peligro
            case 'EN':
                $out = "label-important";
                break;
            // Vulnerable
            case 'VU':
                $out = "label-warning";
                break;
            // Casi amenazado
            case 'NT':
                $out = "label-warning";
                break;
            // Datos insuficientes
            case 'DD':
                $out = "label-info";
                break;
            // Preocupacion menor
            case 'LC':
                $out = "label-info";
                break;
            // No evaluado
            case 'NE':
                $out = "";
                break;
            // No catalogado
            case 'NC':
                $out = "";
                break;
            default:
                $out = "";
                break;
        }
        
        return $out;
    }
}
