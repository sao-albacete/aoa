<?php
/**
 * AsoCitasClasesEdadSexoFixture
 *
 */
class AsoCitasClasesEdadSexoFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'aso_citas_clases_edad_sexo';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'primary', 'comment' => 'Identificador único de la tabla'),
		'cita_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'Identificador de la cita'),
		'clase_edad_sexo_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Identificador de la clase-edad-sexo'),
		'cantidad' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'Cantidad de individuos por clase de edad-sexo'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'idx_citas_clases_edad_sexo_cita_id' => array('column' => 'cita_id', 'unique' => 0),
			'idx_citas_clases_edad_sexo_clase_edad_sexo_id' => array('column' => 'clase_edad_sexo_id', 'unique' => 0)
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
			'cita_id' => 1,
			'clase_edad_sexo_id' => 1,
			'cantidad' => 1
		),
	);

}
