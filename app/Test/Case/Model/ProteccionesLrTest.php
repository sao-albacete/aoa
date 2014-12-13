<?php
App::uses('ProteccionesLr', 'Model');

/**
 * ProteccionesLr Test Case
 *
 */
class ProteccionesLrTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.protecciones_lr'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ProteccionesLr = ClassRegistry::init('ProteccionesLr');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProteccionesLr);

		parent::tearDown();
	}

}
