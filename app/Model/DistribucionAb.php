<?php
App::uses('AppModel', 'Model');
/**
 * DistribucionesAb Model
 *
 */
class DistribucionAb extends AppModel {

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
	public $useTable = 'distribucion_ab';

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
				'fields'=>array('DistribucionAb.codigo', 'DistribucionAb.nombre'),
				'conditions'=>array('DistribucionAb.indActivo'=>1)
			)
		);
		
		return $resultado;
	}
}
