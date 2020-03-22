<?php
App::uses('AppModel', 'Model');

class CitaEspecieCount extends AppModel
{

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
	public $useTable = 'cita';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array();

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array();

	/**
	 * Validaciones
	 */
	public $validate = array();

	public function countCitasPorEspecie($especieId)
	{
		return $this->find(
			'count',
			array(
				'conditions' => array('CitaEspecieCount.especie_id' => $especieId)
			));
	}
}
