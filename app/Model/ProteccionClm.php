<?php
App::uses('AppModel', 'Model');
/**
 * ProteccionesClm Model
 *
 */
class ProteccionClm extends AppModel {

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
