<?php
/**
 * EspecyFixture
 *
 */
class EspecyFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'primary', 'comment' => 'Identificador de la especie'),
		'codigo' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 3, 'collate' => 'utf8_unicode_ci', 'comment' => 'Abreviatura del nombre científico de la especie
', 'charset' => 'utf8'),
		'categoria' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 4, 'collate' => 'utf8_unicode_ci', 'comment' => 'Categoría asignada en la lista de las aves de España', 'charset' => 'utf8'),
		'codigoPresenteCanarias' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4, 'collate' => 'utf8_unicode_ci', 'comment' => 'Indica si está presente en las Islas Canarias', 'charset' => 'utf8'),
		'codigoPresentePiYBaleares' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4, 'collate' => 'utf8_unicode_ci', 'comment' => 'Indica si esta presente en le Península Ibérica o en las Islas Baleares', 'charset' => 'utf8'),
		'nombreComun' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'comment' => 'Nombre común de la especie', 'charset' => 'utf8'),
		'nombreIngles' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'comment' => 'Nombre en inglés de la especie', 'charset' => 'utf8'),
		'codigoEuring' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'Código utilizado por la institución EURING, que dirige el anillamiento científico a nivel europeo. Este código sirve para ordenar sistemáticamente las especies por su orden evolutivo'),
		'codigoAerc' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'comment' => 'Código de orden taxonómico utilizado por la AERC a nivel europeo. El número lo hemos asignado nosotros para ordenar las especies por este orden. Las especies se ordenarán prioritariamente por este orden. Este orden irá cambiado según se vaya actualizando'),
		'familia_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Identificador de la familia'),
		'indRareza' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => 'Indica si es una rareza en España'),
		'comentarioHistorico' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'codigoEstatusEsp' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 4, 'collate' => 'utf8_unicode_ci', 'comment' => 'Código de estatus español', 'charset' => 'utf8'),
		'clasificacion_criterios_esp_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Identificador de la clasificación de criterio nacional'),
		'indCitadaAlbacete' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => 'Indica si ha sido citada en la provincia de Albacete'),
		'genero' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'comment' => 'Género al que pertenece la especie', 'charset' => 'utf8'),
		'especie' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'comment' => 'Especie que identifica a una especie dentro de un género.', 'charset' => 'utf8'),
		'subespecie' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'comment' => 'Subespecie a la que pertenece dentro de la misma especie', 'charset' => 'utf8'),
		'disbtribucion_ab_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Identificador de distribucion en la provincia'),
		'estatus_cuantitativo_ab_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Identificador del estatus cuantitativo provincial'),
		'proteccion_clm_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Identificador del nivel de protección CLM'),
		'proteccion_lr_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4, 'key' => 'index', 'comment' => 'Indentificador del nivel de proteccion LR'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'IDX_ESPECIE_ABUNDANCIA_ID' => array('column' => 'disbtribucion_ab_id', 'unique' => 0),
			'IDX_ESPECIE_ESTATUS_CUANT_AB_ID' => array('column' => 'estatus_cuantitativo_ab_id', 'unique' => 0),
			'IDX_ESPECIE_PROTECCION_CLM_ID' => array('column' => 'proteccion_clm_id', 'unique' => 0),
			'IDX_ESPECIE_PROTECCION_LR_ID' => array('column' => 'proteccion_lr_id', 'unique' => 0),
			'IDX_ESPECIE_FAMILIA_ID' => array('column' => 'familia_id', 'unique' => 0),
			'IDX_ESPECIE_CLASIF_CRIT_ESP_ID' => array('column' => 'clasificacion_criterios_esp_id', 'unique' => 0)
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
			'codigo' => 'L',
			'categoria' => 'Lo',
			'codigoPresenteCanarias' => 'Lo',
			'codigoPresentePiYBaleares' => 'Lo',
			'nombreComun' => 'Lorem ipsum dolor sit amet',
			'nombreIngles' => 'Lorem ipsum dolor sit amet',
			'codigoEuring' => 1,
			'codigoAerc' => 1,
			'familia_id' => 1,
			'indRareza' => 1,
			'comentarioHistorico' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'codigoEstatusEsp' => 'Lo',
			'clasificacion_criterios_esp_id' => 1,
			'indCitadaAlbacete' => 1,
			'genero' => 'Lorem ipsum dolor sit amet',
			'especie' => 'Lorem ipsum dolor sit amet',
			'subespecie' => 'Lorem ipsum dolor sit amet',
			'disbtribucion_ab_id' => 1,
			'estatus_cuantitativo_ab_id' => 1,
			'proteccion_clm_id' => 1,
			'proteccion_lr_id' => 1
		),
	);

}
