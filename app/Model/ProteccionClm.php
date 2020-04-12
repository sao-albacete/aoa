<?php
App::uses('AppModel', 'Model');

/**
 * ProteccionesClm Model
 *
 */
class ProteccionClm extends AppModel {

	const CODIGO_EN_PELIGRO_DE_EXTINCION = "EN";
	const CODIGO_VULNERABLE = "VU";
	const CODIGO_NO_CATALOGADO = "NC";
	const CODIGO_INTERES_ESPECIAL = "IE";

	/**
	 * Use database config
	 *
	 * @var string
	 */
	public $useDbConfig = 'default';

	/**
	 * Use table
	 *
	 * @var mixed False or table name
	 */
	public $useTable = 'proteccion_clm';

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'nombre';


	/*
	 * Funciones
	 */

	/**
	 * Obtiene todos los registros activos
	 */
	public function obtenerActivos() {

		$resultado = $this -> find(
			'all',
			array(
				'fields'=>array('ProteccionClm.codigo', 'ProteccionClm.nombre'),
				'conditions'=>array('ProteccionClm.indActivo'=>1)
			)
		);

		return $resultado;
	}
}
