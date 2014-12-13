<?php
App::uses('ClasesEdadesSexo', 'Model');

/**
 * ClasesEdadesSexo Test Case
 *
 */
class ClasesEdadesSexoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.clases_edades_sexo'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ClasesEdadesSexo = ClassRegistry::init('ClasesEdadesSexo');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ClasesEdadesSexo);

		parent::tearDown();
	}

}
