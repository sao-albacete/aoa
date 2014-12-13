<?php
App::uses('Especy', 'Model');

/**
 * Especy Test Case
 *
 */
class EspecyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.especy',
		'app.familia',
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
		$this->Especy = ClassRegistry::init('Especy');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Especy);

		parent::tearDown();
	}

}
