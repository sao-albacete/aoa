<?php
App::uses('AppModel', 'Model');
/**
 * Fuente Model
 *
 * @property CitaHistorico $CitaHistorico
 * @property Cita $Cita
 */
class Fuente extends AppModel {

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
	public $useTable = 'fuente';
	
	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'nombre';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'CitaHistorico' => array(
			'className' => 'CitaHistorico',
			'foreignKey' => 'fuente_id',
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
			'foreignKey' => 'fuente_id',
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

	public function getAllFuentesBasic() {
	
		$fuentes = $this->find('all', array(
				'fields' => array('Fuente.id', 'Fuente.nombre'),
				'conditions'=>array('Fuente.indActivo'=>1),
				'order'=>array('Fuente.nombre ASC'),
				'recursive'=>-1
		));
	
		return $fuentes;
	}
}
