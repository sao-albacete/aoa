<?php
/**
 * FamiliaFixture
 *
 */
class FamiliaFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'primary', 'comment' => 'Identificador de la familia'),
		'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_unicode_ci', 'comment' => 'Nombre de la familia', 'charset' => 'utf8'),
		'orden_taxonomico_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Identificador del orden taxonómico'),
		'indActivo' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'IDX_FAMILIA_ORDEN_TAXONOMICO_ID' => array('column' => 'orden_taxonomico_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'nombre' => 'Lorem ipsum dolor sit amet',
			'orden_taxonomico_id' => 1,
			'indActivo' => 1
		),
	);

}
