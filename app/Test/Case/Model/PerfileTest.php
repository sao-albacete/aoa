<?php
App::uses('Perfile', 'Model');

/**
 * Perfile Test Case
 *
 */
class PerfileTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.perfile'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Perfile = ClassRegistry::init('Perfile');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Perfile);

		parent::tearDown();
	}

}
