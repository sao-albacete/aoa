<?php
App::uses('CitaHistorico', 'Model');

/**
 * CitaHistorico Test Case
 *
 */
class CitaHistoricoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cita_historico',
		'app.cita',
		'app.especie',
		'app.lugar',
		'app.clase_reproduccion',
		'app.fuente',
		'app.criterio_seleccion_cita',
		'app.usuario'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CitaHistorico = ClassRegistry::init('CitaHistorico');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CitaHistorico);

		parent::tearDown();
	}

}
