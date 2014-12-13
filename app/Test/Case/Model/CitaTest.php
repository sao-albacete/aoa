<?php
App::uses('Cita', 'Model');

/**
 * Cita Test Case
 *
 */
class CitaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cita',
		'app.lugar',
		'app.usuario',
		'app.clase_reproduccion',
		'app.fuente',
		'app.especie',
		'app.criterio_seleccion_cita',
		'app.cita_historico',
		'app.fichero'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Cita = ClassRegistry::init('Cita');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Cita);

		parent::tearDown();
	}

}
