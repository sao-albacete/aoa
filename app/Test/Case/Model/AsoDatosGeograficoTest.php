<?php
App::uses('AsoDatosGeografico', 'Model');

/**
 * AsoDatosGeografico Test Case
 *
 */
class AsoDatosGeograficoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.aso_datos_geografico',
		'app.municipio',
		'app.cuadricula_utm',
		'app.comarca'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AsoDatosGeografico = ClassRegistry::init('AsoDatosGeografico');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AsoDatosGeografico);

		parent::tearDown();
	}

}
