<?php
App::uses('Fuente', 'Model');

/**
 * Fuente Test Case
 *
 */
class FuenteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.fuente',
		'app.cita_historico',
		'app.cita',
		'app.lugar',
		'app.usuario',
		'app.clase_reproduccion',
		'app.especie',
		'app.criterio_seleccion_cita',
		'app.fichero'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Fuente = ClassRegistry::init('Fuente');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Fuente);

		parent::tearDown();
	}

}
