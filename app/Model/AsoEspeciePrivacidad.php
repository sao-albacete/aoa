<?php
App::uses('AppModel', 'Model');

class AsoEspeciePrivacidad extends AppModel {

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
	public $useTable = 'aso_especie_privacidad';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Especie' => array(
			'className' => 'Especie',
			'foreignKey' => 'id_especie_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Privacidad' => array(
			'className' => 'Privacidad',
			'foreignKey' => 'id_privacidad_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
	/*
	 * Funciones
	 */
	
	public function obtenerCriteriosPrivacidadPorIdEspecie($especieId) {
	
		$clasesEdadSexo = $this->find('all', array(
				'fields' => array('AsoEspeciePrivacidad.id_privacidad_id'),
				'conditions' => array('AsoEspeciePrivacidad.id_especie_id' => $especieId),
				'orderBy' => array('AsoEspeciePrivacidad.orden DESC'),
				'recursive'=>-1
		));
	
		return $clasesEdadSexo;
	}
	
}
