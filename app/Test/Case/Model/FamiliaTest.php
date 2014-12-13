<?php
App::uses('Familia', 'Model');

/**
 * Familia Test Case
 *
 */
class FamiliaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.familia',
		'app.orden_taxonomico',
		'app.especy',
		'app.clasificacion_criterios_esp',
		'app.disbtribucion_ab',
		'app.estatus_cuantitativo_ab',
		'app.proteccion_clm',
		'app.proteccion_lr'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Familia = ClassRegistry::init('Familia');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Familia);

		parent::tearDown();
	}

}
