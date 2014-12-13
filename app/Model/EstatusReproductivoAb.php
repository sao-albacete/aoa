<?php
App::uses('AppModel', 'Model');
/**
 * EstatusReproductivoAb Model
 *
 */
class EstatusReproductivoAb extends AppModel {

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
	public $useTable = 'estatus_reproductivo_ab';

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
				'fields'=>array('EstatusReproductivoAb.codigo', 'EstatusReproductivoAb.nombre'),
				'conditions'=>array('EstatusReproductivoAb.indActivo'=>1)
			)
		);
		
		return $resultado;
	}
}
