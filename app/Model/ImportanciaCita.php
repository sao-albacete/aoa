<?php
App::uses('AppModel', 'Model');
/**
 * Fuente Model
 *
 * @property CitaHistorico $CitaHistorico
 * @property Cita $Cita
 */
class ImportanciaCita extends AppModel {

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
	public $useTable = 'importancia_cita';
	
	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'descripcion';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'CitaHistorico' => array(
			'className' => 'CitaHistorico',
			'foreignKey' => 'importancia_cita_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
			),
		'Cita' => array(
			'className' => 'Cita',
			'foreignKey' => 'importancia_cita_id',
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
}
