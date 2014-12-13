<?php
/**
 * FicheroFixture
 *
 */
class FicheroFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'Identificador del fichero'),
		'ruta' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'comment' => 'Ruta donde está alojado el fichero', 'charset' => 'utf8'),
		'tipoMime' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'comment' => 'Tipo MIME del fichero', 'charset' => 'utf8'),
		'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'comment' => 'Nombre del fichero', 'charset' => 'utf8'),
		'descripcion' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_unicode_ci', 'comment' => 'Descripción del fichero', 'charset' => 'utf8'),
		'fechaAlta' => array('type' => 'date', 'null' => false, 'default' => null, 'comment' => 'Fecha en la que se dio de alta el fichero'),
		'cita_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'usuario_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'Identificador del usuario que dio de alta el fichero'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'idx_ficheros_cita_id' => array('column' => 'cita_id', 'unique' => 0),
			'idx_ficheros_usuario_id' => array('column' => 'usuario_id', 'unique' => 0)
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
			'ruta' => 'Lorem ipsum dolor sit amet',
			'tipoMime' => 'Lorem ipsum dolor sit amet',
			'nombre' => 'Lorem ipsum dolor sit amet',
			'descripcion' => 'Lorem ipsum dolor sit amet',
			'fechaAlta' => '2013-04-09',
			'cita_id' => 1,
			'usuario_id' => 1
		),
	);

}
