<?php
App::uses('AppModel', 'Model');
/**
 * ClasesReproduccion Model
 *
 */
class ClaseReproduccion extends AppModel {

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
	public $useTable = 'clase_reproduccion';

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'descripcion';
	
	public function getAllClasesReproduccionBasic() {
		
		$clasesReproduccion = $this->find('all', array(
			'fields' => array('ClaseReproduccion.id', 'ClaseReproduccion.descripcion', 'ClaseReproduccion.codigo', 'ClaseReproduccion.tipoCria', 'ClaseReproduccion.idTipoCria'),
			'conditions'=>array('ClaseReproduccion.indActivo'=>1),
			'order'=>array('ClaseReproduccion.idTipoCria'),
			'recursive'=>-1
		));
		
		return $clasesReproduccion;
	}

}
