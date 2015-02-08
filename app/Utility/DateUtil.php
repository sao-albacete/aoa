<?php
class DateUtil {

    /**
     * Transforma una fecha en formato dd/mm/yyyy al foramto yyyy-mm-dd
     *
     * @param String $fecha
     * @return bool|string
     */
    public static function europeanFormatToAmericanFormat($fecha) {

        $fechaArray = explode("/", $fecha);
        $dia = $fechaArray[0];
        $mes = $fechaArray[1];
        $anio = $fechaArray[2];

        if(checkdate($mes, $dia, $anio)) {
            return $anio."-".$mes."-".$dia;
        }
        else {
            return false;
        }
    }

    /**
     * Transforma una fecha en formato yyyy-mm-dd al foramto dd/mm/yyyy
     *
     * @param String $fecha
     * @return bool|string
     */
    public static function americanFormatToEuropeanFormat($fecha) {
        
        $fechaArray = explode("-", $fecha);
        $dia = $fechaArray[2];
        $mes = $fechaArray[1];
        $anio = $fechaArray[0];

        if(checkdate($mes, $dia, $anio)) {
            return $dia."/".$mes."/".$anio;
        }
        else {
            return false;
        }
    }
}