<?php
App::uses('AsoCitasObservadore', 'Model');

/**
 * AsoCitasObservadore Test Case
 *
 */
class AsoCitasObservadoreTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.aso_citas_observadore',
		'app.cita',
		'app.especie',
		'app.lugar',
		'app.clase_reproduccion',
		'app.fuente',
		'app.criterio_seleccion_cita',
		'app.cita_historico',
		'app.observador'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AsoCitasObservadore = ClassRegistry::init('AsoCitasObservadore');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AsoCitasObservadore);

		parent::tearDown();
	}

}
