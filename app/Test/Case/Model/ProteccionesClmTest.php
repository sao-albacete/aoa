<?php
App::uses('ProteccionesClm', 'Model');

/**
 * ProteccionesClm Test Case
 *
 */
class ProteccionesClmTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.protecciones_clm'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ProteccionesClm = ClassRegistry::init('ProteccionesClm');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ProteccionesClm);

		parent::tearDown();
	}

}
