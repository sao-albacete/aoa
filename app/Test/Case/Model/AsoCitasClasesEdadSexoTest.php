<?php
App::uses('AsoCitasClasesEdadSexo', 'Model');

/**
 * AsoCitasClasesEdadSexo Test Case
 *
 */
class AsoCitasClasesEdadSexoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.aso_citas_clases_edad_sexo',
		'app.cita',
		'app.especie',
		'app.lugar',
		'app.clase_reproduccion',
		'app.fuente',
		'app.criterio_seleccion_cita',
		'app.cita_historico',
		'app.clase_edad_sexo'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AsoCitasClasesEdadSexo = ClassRegistry::init('AsoCitasClasesEdadSexo');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AsoCitasClasesEdadSexo);

		parent::tearDown();
	}

}
