<?php
/**
 * LugareFixture
 *
 */
class LugareFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'Identificador del lugar'),
		'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'comment' => 'Nombre del lugar', 'charset' => 'utf8'),
		'aso_dato_geografico_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'index'),
		'usuario_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'Identificador del usuario que dio de alta el lugar'),
		'indActivo' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'IDX_LUGAR_USUARIO_ID' => array('column' => 'usuario_id', 'unique' => 0),
			'IDX_LUGAR_ASO_GEOGRAFICA_ID' => array('column' => 'aso_dato_geografico_id', 'unique' => 0)
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
			'aso_dato_geografico_id' => 1,
			'usuario_id' => 1,
			'indActivo' => 1
		),
	);

}
