<?php
App::uses('AppModel', 'Model');
/**
 * ProteccionesLr Model
 *
 */
class Estudio extends AppModel {

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
	public $useTable = 'estudio';

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'descripcion';
	
	/**
	 * Obtiene toda la información de la cita por id
	 */
	public function obtenerEstudios($conditions=null, $fields=null, $order=null) {
	
		$estudios = $this -> find(
			'all',
			array(
				'conditions'=>$conditions,
				'fields'=>$fields,
				'order'=>$order
			)
		);
	
		return $estudios;
	}
}
