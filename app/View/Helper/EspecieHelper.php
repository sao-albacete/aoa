<?php

App::uses('AppHelper', 'View/Helper');

class EspecieHelper extends AppHelper
{

	public function obtenerColorProteccionClmPorCodigo($codigoCategoriaProteccionClm)
	{
		switch ($codigoCategoriaProteccionClm) {
			case ProteccionClm::CODIGO_EN_PELIGRO_DE_EXTINCION:
				return 'red';
				break;
			case ProteccionClm::CODIGO_VULNERABLE:
				return 'orange';
				break;
			case ProteccionClm::CODIGO_INTERES_ESPECIAL:
				return 'yellow';
				break;
			case ProteccionClm::CODIGO_NO_CATALOGADO:
			default:
				return 'transparent';
				break;
		}
	}

	/**
	 * Retorna un color de label en funcion del nivel de proteccion en Castilla - La Mancha
	 *
	 * @see http://twitter.github.io/bootstrap/components.html#labels-badges
	 *
	 * @param string $codigoProteccionClm
	 * @return string
	 */
	public function obtenerEtiquetaProteccionClmPorCodigo($codigoProteccionClm)
	{
		switch ($codigoProteccionClm) {

			case ProteccionClm::CODIGO_EN_PELIGRO_DE_EXTINCION:
				return "label-important";
				break;
			case ProteccionClm::CODIGO_VULNERABLE:
				return "label-warning";
				break;
			case ProteccionClm::CODIGO_INTERES_ESPECIAL:
				return "label-info";
				break;
			case ProteccionClm::CODIGO_NO_CATALOGADO:
			default:
			return "";
				break;
		}
	}

	/**
	 * Retorna un color de label en funcion del nivel de proteccion en el Libro Rojo de las Aves de España
	 *
	 * @see http://twitter.github.io/bootstrap/components.html#labels-badges
	 *
	 * @param string $codigoProteccionLr
	 * @return string
	 */
	public function obtener_color_proteccion_lr($codigoProteccionLr)
	{

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
