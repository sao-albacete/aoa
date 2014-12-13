<?php
App::uses('CuadriculasUtm', 'Model');

/**
 * CuadriculasUtm Test Case
 *
 */
class CuadriculasUtmTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cuadriculas_utm'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CuadriculasUtm = ClassRegistry::init('CuadriculasUtm');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CuadriculasUtm);

		parent::tearDown();
	}

}
