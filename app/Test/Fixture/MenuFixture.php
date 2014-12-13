<?php
/**
 * MenuFixture
 *
 */
class MenuFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'primary', 'comment' => 'Identificador de la opción de menú principal'),
		'titulo' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_unicode_ci', 'comment' => 'Título de la opción de menú principal', 'charset' => 'utf8'),
		'orden' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'Orden de aparición de la opción de menú principal'),
		'url' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'comment' => 'Dirección URL de la opción de menú', 'charset' => 'utf8'),
		'perfil_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Identificador de perfil que tiene acceso al menú principal'),
		'menu_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Identificador de la opción de menu padre de la que hereda la opción de menú'),
		'indActivo' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'IDX_MENU_PERFIL_ID' => array('column' => 'perfil_id', 'unique' => 0),
			'IDX_MENU_MENU_ID' => array('column' => 'menu_id', 'unique' => 0)
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
			'titulo' => 'Lorem ipsum dolor sit amet',
			'orden' => 1,
			'url' => 'Lorem ipsum dolor sit amet',
			'perfil_id' => 1,
			'menu_id' => 1,
			'indActivo' => 1
		),
	);

}
