<?php
App::uses('EstatusCuantitativosAb', 'Model');

/**
 * EstatusCuantitativosAb Test Case
 *
 */
class EstatusCuantitativosAbTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.estatus_cuantitativos_ab'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->EstatusCuantitativosAb = ClassRegistry::init('EstatusCuantitativosAb');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EstatusCuantitativosAb);

		parent::tearDown();
	}

}
