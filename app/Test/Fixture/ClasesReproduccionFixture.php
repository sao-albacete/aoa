<?php
/**
 * ClasesReproduccionFixture
 *
 */
class ClasesReproduccionFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'clases_reproduccion';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'primary', 'comment' => 'Identificador del tipo de clase de reproducción'),
		'codigo' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 2, 'collate' => 'utf8_unicode_ci', 'comment' => 'Código del tipo de clase de reproducción', 'charset' => 'utf8'),
		'tipoCria' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'comment' => 'Descripción del tipo de cria', 'charset' => 'utf8'),
		'descripcion' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 500, 'collate' => 'utf8_unicode_ci', 'comment' => 'Descripción de la clase de reproducción', 'charset' => 'utf8'),
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
			'codigo' => '',
			'tipoCria' => 'Lorem ipsum dolor sit amet',
			'descripcion' => 'Lorem ipsum dolor sit amet',
			'indActivo' => 1
		),
	);

}
