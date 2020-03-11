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
	 * Transforma la cadena recibida a un formato de tiempo es correcto (HH:mm:ss).
	 * Si la cadena recibida no tiene el formato esperado, devuelve false.
	 *
	 * @param String $time
	 * @return bool|string
	 */
	public static function formatTime($time) {

		$timeArray = explode(":", $time);
		$hora = $timeArray[0];
		$minuto = $timeArray[1];

		if(((int)$hora) >= 0 && ((int)$hora) < 24 && ((int)$minuto) >= 0 && ((int)$minuto) < 60) {
			return $hora.":".$minuto.":00";
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
