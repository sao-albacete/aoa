<?php
App::uses('ClasificacionesCriteriosEsp', 'Model');

/**
 * ClasificacionesCriteriosEsp Test Case
 *
 */
class ClasificacionesCriteriosEspTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.clasificaciones_criterios_esp'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ClasificacionesCriteriosEsp = ClassRegistry::init('ClasificacionesCriteriosEsp');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ClasificacionesCriteriosEsp);

		parent::tearDown();
	}

}
