<?php
App::uses('ClasesReproduccion', 'Model');

/**
 * ClasesReproduccion Test Case
 *
 */
class ClasesReproduccionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.clases_reproduccion'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ClasesReproduccion = ClassRegistry::init('ClasesReproduccion');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ClasesReproduccion);

		parent::tearDown();
	}

}
