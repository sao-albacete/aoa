<?php
App::uses('AppModel', 'Model');
/**
 * Perfile Model
 *
 */
class Perfil extends AppModel {

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
	public $useTable = 'perfil';
	
	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'nombre';

}
