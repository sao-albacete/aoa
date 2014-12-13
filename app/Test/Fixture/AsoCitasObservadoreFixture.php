<?php
/**
 * AsoCitasObservadoreFixture
 *
 */
class AsoCitasObservadoreFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'cita_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'Identificador de la cita'),
		'observador_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'Identificador del observador'),
		'indexes' => array(
			'PRIMARY' => array('column' => array('cita_id', 'observador_id'), 'unique' => 1),
			'IDX_ASO_CITA_OBS_OBSERVADOR_ID' => array('column' => 'observador_id', 'unique' => 0),
			'IDX_ASO_CITA_OBS_CITA_ID' => array('column' => 'cita_id', 'unique' => 0)
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
			'cita_id' => 1,
			'observador_id' => 1
		),
	);

}
