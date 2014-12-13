<?php
/**
 * ObservadoreFixture
 *
 */
class ObservadoreFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'Identificador del observador'),
		'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'utf8_general_ci', 'comment' => 'Nombre del observador', 'charset' => 'utf8'),
		'codigo' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 3, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'comment' => 'Código a modo de abreviatura del observador', 'charset' => 'utf8'),
		'usuario_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index', 'comment' => 'Identificador del usuario'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'IDX_UQ_OBSERVADOR_CODIGO' => array('column' => 'codigo', 'unique' => 1),
			'IDX_OBSERVADOR_USUARIO_ID' => array('column' => 'usuario_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
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
			'codigo' => 'L',
			'usuario_id' => 1
		),
	);

}
