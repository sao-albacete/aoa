<?php
App::uses('CriteriosSeleccionCitum', 'Model');

/**
 * CriteriosSeleccionCitum Test Case
 *
 */
class CriteriosSeleccionCitumTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.criterios_seleccion_citum'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CriteriosSeleccionCitum = ClassRegistry::init('CriteriosSeleccionCitum');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CriteriosSeleccionCitum);

		parent::tearDown();
	}

}
