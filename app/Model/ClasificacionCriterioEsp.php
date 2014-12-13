<?php
App::uses('AppModel', 'Model');
/**
 * ClasificacionesCriteriosEsp Model
 *
 */
class ClasificacionCriterioEsp extends AppModel {

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
	public $useTable = 'clasificacion_criterio_esp';

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'nombre';

}
