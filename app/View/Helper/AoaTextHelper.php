<?php
/* /app/View/Helper/AoaTextHelper.php */

App::uses('AppHelper', 'View/Helper');

class AoaTextHelper extends AppHelper {
	
	/**
	 * Retorna la palabra recibida con la primera letra mayúscula
	 * 
	 * @param string $palabra
	 */
	public function primera_letra_mayuscula($palabra) {
		
		$out = ucfirst($palabra);
		
		switch (substr ($out, 0, 1)) {
			case 'á':
				$out = "Á".substr ($out, 1);
				break;
			case 'é':
				$out = "É".substr ($out, 1);
				break;
			case 'í':
				$out = "Í".substr ($out, 1);
				break;
			case 'ó':
				$out = "Ó".substr ($out, 1);
				break;
			case 'ú':
				$out = "Ú".substr ($out, 1);
				break;
			default:
				break;
		}
		
		return $out;
	}
}
?>