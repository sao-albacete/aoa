<?php
App::uses('DistribucionesAb', 'Model');

/**
 * DistribucionesAb Test Case
 *
 */
class DistribucionesAbTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.distribuciones_ab'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DistribucionesAb = ClassRegistry::init('DistribucionesAb');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DistribucionesAb);

		parent::tearDown();
	}

}
