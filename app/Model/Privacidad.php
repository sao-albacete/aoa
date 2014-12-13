<?php
App::uses('AppModel', 'Model');
/**
 * ProteccionesLr Model
 *
 */
class Privacidad extends AppModel {

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
	public $useTable = 'privacidad';

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'descripcion';

}
