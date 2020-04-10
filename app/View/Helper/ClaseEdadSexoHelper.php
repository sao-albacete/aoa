<?php
/* /app/View/Helper/ClaseEdadSexoHelper.php */

App::uses('AppHelper', 'View/Helper');

class ClaseEdadSexoHelper extends AppHelper
{
	/**
	 * Genera el detalle de la cantiadad de aves desglosado por clases de edad/sexo
	 *
	 * @param array $clases_edad_sexo
	 * @return string lista formada por "#[número de aves] -> [código clase edad/sexo] ([nombre clase edad/sexo])"
	 */
	public function mostrar_detalle_clase_edad_sexo($clases_edad_sexo)
	{
		$out = "";

		if (!empty($clases_edad_sexo)) {

			foreach ($clases_edad_sexo as $clase_edad_sexo) {

				$out .= $clase_edad_sexo['AsoCitaClaseEdadSexo']['cantidad'] . " -> " . $clase_edad_sexo['ClaseEdadSexo']['nombre'] . ", ";
			}
		}
		return substr($out, 0, -2);
	}
}
