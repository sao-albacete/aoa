<?php
App::uses('AppModel', 'Model');
/**
 * Municipio Model
 *
 * @property AsoDatosGeografico $AsoDatosGeografico
 */
class Municipio extends AppModel {

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
	public $useTable = 'municipio';
	
	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'nombre';


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	public $belongsTo = array(
		'Comarca' => array(
			'className' => 'Comarca',
			'foreignKey' => 'comarca_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Lugar' => array(
			'className' => 'Lugar',
			'foreignKey' => 'municipio_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	
	/*
	 * Funciones
	 */
	
	/**
	 * Obtiene todos los municipios activos ordenados por nombre 
	 */
	public function obtenerMunicipiosActivosOrdenadosPorNombre() {
		
		$municipios = $this -> find(
			'all', 
			array(
				'fields'=>array('Municipio.id', 'Municipio.nombre'),
				'conditions'=>array('Municipio.indActivo'=>1),
				'order'=>array('Municipio.nombre ASC'),
				'recursive'=>-1
			)
		);
		
		return $municipios;
	}

}
