<?php
App::uses('Fichero', 'Model');

/**
 * Fichero Test Case
 *
 */
class FicheroTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.fichero',
		'app.cita',
		'app.lugar',
		'app.usuario',
		'app.clase_reproduccion',
		'app.fuente',
		'app.especie',
		'app.criterio_seleccion_cita',
		'app.cita_historico'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Fichero = ClassRegistry::init('Fichero');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Fichero);

		parent::tearDown();
	}

}
