<?php
App::uses('AppModel', 'Model');
/**
 * Familia Model
 *
 * @property OrdenTaxonomico $OrdenTaxonomico
 * @property Especy $Especy
 */
class Familia extends AppModel {

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
	public $useTable = 'familia';
	
	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'nombre';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'OrdenTaxonomico' => array(
			'className' => 'OrdenTaxonomico',
			'foreignKey' => 'orden_taxonomico_id',
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
		'Especies' => array(
			'className' => 'Especies',
			'foreignKey' => 'familia_id',
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

	public function getAllFamiliasBasic() {
		
		$familias = $this->find('all', array(
			'fields' => array('Familia.id', 'Familia.nombre'),
			'conditions'=>array('Familia.indActivo'=>1),
			'order'=>array('Familia.nombre ASC'),
			'recursive'=>-1
		));
		
		return $familias;
	}
}
