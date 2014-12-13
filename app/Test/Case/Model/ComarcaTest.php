<?php
App::uses('Comarca', 'Model');

/**
 * Comarca Test Case
 *
 */
class ComarcaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.comarca',
		'app.aso_datos_geografico',
		'app.municipio',
		'app.cuadricula_utm'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Comarca = ClassRegistry::init('Comarca');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Comarca);

		parent::tearDown();
	}

}
