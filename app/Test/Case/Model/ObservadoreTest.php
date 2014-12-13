<?php
App::uses('Observadore', 'Model');

/**
 * Observadore Test Case
 *
 */
class ObservadoreTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.observadore',
		'app.usuario'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Observadore = ClassRegistry::init('Observadore');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Observadore);

		parent::tearDown();
	}

}
