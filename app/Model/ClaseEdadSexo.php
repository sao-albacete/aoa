<?php
App::uses('AppModel', 'Model');
/**
 * ClasesEdadesSexo Model
 *
 */
class ClaseEdadSexo extends AppModel {

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
	public $useTable = 'clase_edad_sexo';

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'nombre';
	
	
	public function obtenerActivos() {
		
		$clasesEdadSexo = $this->find('all', array(
      		'conditions' => array('ClaseEdadSexo.indActivo' => 1),
			'recursive'=>-1
		));
		
		return $clasesEdadSexo;
	}
	
}
