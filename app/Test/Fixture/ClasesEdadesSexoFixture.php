<?php
/**
 * ClasesEdadesSexoFixture
 *
 */
class ClasesEdadesSexoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'primary', 'comment' => 'Identificador de la clase edad-sexo'),
		'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'collate' => 'utf8_unicode_ci', 'comment' => 'Nombre de la clase de edad-sexo', 'charset' => 'utf8'),
		'codigo' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 2, 'key' => 'unique', 'collate' => 'utf8_unicode_ci', 'comment' => 'Código de datado europeo. La primera cifra se refiere a la edad, y la segunda al sexo. Sexo: 0 son aves indeterminadas, 1 son macho y 2 son hembras. Edad: 2 son aves de edad indeteminada, 3 aves jóvenes, 5 aves de segundo año, 9 aves adultas.', 'charset' => 'utf8'),
		'indActivo' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'idx_clases_edades_sexos_codigo' => array('column' => 'codigo', 'unique' => 1)
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
			'codigo' => '',
			'indActivo' => 1
		),
	);

}
