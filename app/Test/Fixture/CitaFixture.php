<?php
/**
 * CitaFixture
 *
 */
class CitaFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary', 'comment' => 'Identificador de la cita'),
		'fechaAlta' => array('type' => 'date', 'null' => false, 'default' => null, 'comment' => 'Fecha de alta de la cita'),
		'cantidad' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'Número de individuos de la especie citada'),
		'observaciones' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 256, 'collate' => 'utf8_unicode_ci', 'comment' => 'Observaciones sobre la cita', 'charset' => 'utf8'),
		'indSeleccionada' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => 'Indica si la cita es seleccionada para el anuario (1) o no (0)'),
		'lugar_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'Identificador del lugar donde se produjo la cita'),
		'indRarezaHomologada' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => 'Indica si la cita es de una rareza homologada (1) o no (0)'),
		'usuario_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'clase_reproduccion_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'key' => 'index'),
		'fuente_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'index'),
		'id_migracion' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indHabitatRaro' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => 'Indica si la cita fue en un habitat raro para la especie vista (1) o no (0)'),
		'indCriaHabitatRaro' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => 'Indica si la cita es de una especie criando en un habitat raro (1) o no (0)'),
		'indHerido' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => 'Indica si el individuo/s citado/s estaba/n herido/s (1) o no (0)'),
		'indComportamiento' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => 'Descripción del comportamiento de la especie'),
		'especie_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Identificador de la especie'),
		'criterio_seleccion_cita_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Criterio utilizado en la selección de la cita'),
		'indActivo' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'IDX_CITA_ESPECIE_ID' => array('column' => 'especie_id', 'unique' => 0),
			'IDX_CITA_CRI_SELEC_ID' => array('column' => 'criterio_seleccion_cita_id', 'unique' => 0),
			'IDX_CITA_USUARIO_ID' => array('column' => 'usuario_id', 'unique' => 0),
			'IDX_CITA_FUENTE_ID' => array('column' => 'fuente_id', 'unique' => 0),
			'IDX_CITA_LUGAR_ID' => array('column' => 'lugar_id', 'unique' => 0),
			'FK_CITA_CLASE_REPRODUCCION_ID_idx' => array('column' => 'clase_reproduccion_id', 'unique' => 0)
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
			'fechaAlta' => '2013-04-09',
			'cantidad' => 1,
			'observaciones' => 'Lorem ipsum dolor sit amet',
			'indSeleccionada' => 1,
			'lugar_id' => 1,
			'indRarezaHomologada' => 1,
			'usuario_id' => 1,
			'clase_reproduccion_id' => 1,
			'fuente_id' => 1,
			'id_migracion' => 1,
			'indHabitatRaro' => 1,
			'indCriaHabitatRaro' => 1,
			'indHerido' => 1,
			'indComportamiento' => 1,
			'especie_id' => 1,
			'criterio_seleccion_cita_id' => 1,
			'indActivo' => 1
		),
	);

}
