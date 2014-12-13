<?php
App::uses('AppModel', 'Model');
/**
 * ProteccionesLr Model
 *
 */
class ProteccionLr extends AppModel {

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
	public $useTable = 'proteccion_lr';

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
				'fields'=>array('ProteccionLr.codigo', 'ProteccionLr.nombre'),
				'conditions'=>array('ProteccionLr.indActivo'=>1)
			)
		);
		
		return $resultado;
	}

}
