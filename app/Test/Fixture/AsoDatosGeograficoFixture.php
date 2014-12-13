<?php
/**
 * AsoDatosGeograficoFixture
 *
 */
class AsoDatosGeograficoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'primary', 'comment' => 'Identificador del lugar'),
		'municipio_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Identificador del municipio'),
		'cuadricula_utm_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Identificador de la cuadrícula UTM'),
		'comarca_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Identificador de la comarca'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'IDX_GEOGRAFICA_CUADRICULA_UTM_ID' => array('column' => 'cuadricula_utm_id', 'unique' => 0),
			'IDX_GEOGRAFICA_MUNICIPIO_ID' => array('column' => 'municipio_id', 'unique' => 0),
			'IDX_GEOGRAFICA_LUGAR_ID' => array('column' => 'id', 'unique' => 0),
			'IDX_GEOGRAFICA_COMARCA_ID' => array('column' => 'comarca_id', 'unique' => 0)
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
			'municipio_id' => 1,
			'cuadricula_utm_id' => 1,
			'comarca_id' => 1
		),
	);

}
