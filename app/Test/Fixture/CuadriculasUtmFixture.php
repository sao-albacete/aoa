<?php
/**
 * CuadriculasUtmFixture
 *
 */
class CuadriculasUtmFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'cuadriculas_utm';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'primary', 'comment' => 'Identificador de la cuadrícula UTM'),
		'codigo' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 12, 'collate' => 'utf8_unicode_ci', 'comment' => 'Código de la cuadrículas UTM', 'charset' => 'utf8'),
		'coordenada_x' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'Coordenada X de la cuadricula'),
		'coordenada_y' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'Coordenada Y de la cuadrícula'),
		'area' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 2, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
			'codigo' => 'Lorem ipsu',
			'coordenada_x' => 1,
			'coordenada_y' => 1,
			'area' => '',
			'indActivo' => 1
		),
	);

}
