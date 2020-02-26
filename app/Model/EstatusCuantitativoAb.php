<?php
App::uses('AppModel', 'Model');
/**
 * EstatusCuantitativosAb Model
 *
 */
class EstatusCuantitativoAb extends AppModel {

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
	public $useTable = 'estatus_cuantitativo_ab';

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
				'fields'=>array('EstatusCuantitativoAb.codigo', 'EstatusCuantitativoAb.nombre'),
				'conditions'=>array('EstatusCuantitativoAb.indActivo'=>1)
			)
		);
		
		return $resultado;
	}
}
