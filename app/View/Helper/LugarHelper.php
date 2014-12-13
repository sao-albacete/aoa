<?php

App::uses('AppHelper', 'View/Helper');

class LugarHelper extends AppHelper
{
    
    /**
	 * Concatena los observadores generando links con el nombre y el codigo del observador.
	 * 
	 * @param array $observadores
	 * @return string cadena de links con el nombre y el codigo del observador
	 */
    public function mostrarDetalleLugar($cita)
    {

        $out = "";
        
        if (! empty($cita)) {
            $out .= 'COMARCA: ' . $cita['Comarca']['nombre'] . ", MUNICIPIO: " . $cita['Municipio']['nombre'] . " y CUADRICULA UTM: " . $cita['CuadriculaUtm']['codigo'];
        }
        
        return $out;
    }
}
