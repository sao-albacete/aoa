<?php
/**
 * UsuarioFixture
 *
 */
class UsuarioFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'Identificador del usuario'),
		'alias' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 16, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'comment' => 'Alias del usuario', 'charset' => 'utf8'),
		'mail' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 128, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'comment' => 'Correo electrónico del usuario', 'charset' => 'utf8'),
		'clave' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 16, 'collate' => 'utf8_general_ci', 'comment' => 'Clave de acceso del usuario a la aplicacion', 'charset' => 'utf8'),
		'perfil_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Identificador del perfil'),
		'indActivo' => array('type' => 'boolean', 'null' => false, 'default' => null, 'comment' => 'Indica si el usuario está o no activo en la aplicación'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'IDX_UQ_USUARIO_MAIL' => array('column' => 'mail', 'unique' => 1),
			'IDX_UQ_USUARIO_ALIAS' => array('column' => 'alias', 'unique' => 1),
			'IDX_USUARIO_PERFIL_ID' => array('column' => 'perfil_id', 'unique' => 0)
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
			'alias' => 'Lorem ipsum do',
			'mail' => 'Lorem ipsum dolor sit amet',
			'clave' => 'Lorem ipsum do',
			'perfil_id' => 1,
			'indActivo' => 1
		),
	);

}
