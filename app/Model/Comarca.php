<?php
App::uses('AppModel', 'Model');
/**
 * Comarca Model
 */
class Comarca extends AppModel {

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
	public $useTable = 'comarca';

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
		'Lugar' => array(
			'className' => 'Lugar',
			'foreignKey' => 'comarca_id',
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

	public function getAllComarcasBasic() {

		$comarcas = $this->find('all', array(
			'fields' => array('Comarca.id', 'Comarca.nombre'),
			'conditions'=>array('Comarca.indActivo'=>1),
			'order'=>array('Comarca.nombre ASC'),
			'recursive'=>-1
		));

		return $comarcas;
	}

	public function obtenerNombrePorId($id) {
		$this->id = $id;
		return $this->field('nombre');
	}
}
