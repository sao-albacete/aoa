<?php
/**
 * DistribucionesAbFixture
 *
 */
class DistribucionesAbFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'distribuciones_ab';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'primary', 'comment' => 'Identificador de distribucion'),
		'codigo' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 4, 'collate' => 'utf8_unicode_ci', 'comment' => 'Código de distribución', 'charset' => 'utf8'),
		'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'collate' => 'utf8_unicode_ci', 'comment' => 'Descripción de la abundancia de una espcie', 'charset' => 'utf8'),
		'indActivo' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
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
			'codigo' => 'Lo',
			'nombre' => 'Lorem ipsum dolor sit amet',
			'indActivo' => 1
		),
	);

}
