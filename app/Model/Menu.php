<?php
App::uses('AppModel', 'Model');
/**
 * Menu Model
 *
 * @property Perfil $Perfil
 * @property Menu $Menu
 * @property Menu $Menu
 */
class Menu extends AppModel {

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
	public $useTable = 'menu';
	
	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'titulo';


	/*
	 * Relaciones
	 */

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Perfil' => array(
			'className' => 'Perfil',
			'foreignKey' => 'perfil_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)/*,
		'Menu' => array(
			'className' => 'Menu',
			'foreignKey' => 'menu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)*/
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	/*public $hasMany = array(
		'Menu' => array(
			'className' => 'Menu',
			'foreignKey' => 'menu_id',
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
	);*/
}
