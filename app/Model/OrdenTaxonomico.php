<?php
App::uses('AppModel', 'Model');
/**
 * OrdenesTaxonomico Model
 *
 */
class OrdenTaxonomico extends AppModel {

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
	public $useTable = 'orden_taxonomico';
	
	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'nombre';
	
	public function getAllOrdenesTaxonomicosBasic() {
		
		$ordenesTaxonomicos = $this->find('all', array(
			'fields' => array('OrdenTaxonomico.id', 'OrdenTaxonomico.nombre'),
			'conditions'=>array('OrdenTaxonomico.indActivo'=>1),
			'order'=>array('OrdenTaxonomico.nombre ASC'),
			'recursive'=>-1
		));
		
		return $ordenesTaxonomicos;
	}
}
