<?php
/**
 * EstatusCuantitativosAbFixture
 *
 */
class EstatusCuantitativosAbFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'estatus_cuantitativos_ab';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'primary', 'comment' => 'Identificador del estatus'),
		'codigo' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 16, 'collate' => 'utf8_unicode_ci', 'comment' => 'Código del estatus', 'charset' => 'utf8'),
		'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 256, 'collate' => 'utf8_unicode_ci', 'comment' => 'Descripción del estatus', 'charset' => 'utf8'),
		'indActivo' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'codigo' => 'Lorem ipsum do',
			'nombre' => 'Lorem ipsum dolor sit amet',
			'indActivo' => 1
		),
	);

}
