<?php
class DateUtil {

	/**
	 * Compara dos fechas en formato "dd/mm/yyyy" y devuelve el numero de dias de diferencia. 
	 * 
	 * @param fecha con formato "dd/mm/yyyy" $primera
	 * @param fecha con formato "dd/mm/yyyy" $segunda
	 */
	public static function compararFechas($primera, $segunda)
	{
		try {
			
			$valoresPrimera = explode ("/", $primera);
			$valoresSegunda = explode ("/", $segunda);
	
			$diaPrimera    = $valoresPrimera[0];
			$mesPrimera  = $valoresPrimera[1];
			$anyoPrimera   = $valoresPrimera[2];
	
			$diaSegunda   = $valoresSegunda[0];
			$mesSegunda = $valoresSegunda[1];
			$anyoSegunda  = $valoresSegunda[2];
	
			$diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);
			$diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);
	
			if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
				// "La fecha ".$primera." no es v&aacute;lida";
				return 0;
			}
			elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
				// "La fecha ".$segunda." no es v&aacute;lida";
				return 0;
			}
			else{
				return  $diasPrimeraJuliano - $diasSegundaJuliano;
			}
		}
		catch(Exception $e) {
			CakeLog::error($e->getMessage().$e->getTraceAsString());
		}
	}
	
	/**
	 * Transforma una fecha en formato dd/mm/yyyy al foramto yyyy-mm-dd 
	 * 
	 * @param String $fecha
	 */
	public static function europeanFormatToAmericanFormat($fecha) {
		
		try {
			
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
		catch(Exception $e) {
			CakeLog::error($e->getMessage().$e->getTraceAsString());
		}
	}
	
	/**
	 * Transforma una fecha en formato yyyy-mm-dd al foramto dd/mm/yyyy
	 * 
	 * @param String $fecha
	 */
	public static function americanFormatToEuropeanFormat($fecha) {
		
		try {
			
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
		catch(Exception $e) {
			CakeLog::error($e->getMessage().$e->getTraceAsString());
		}
	}
}