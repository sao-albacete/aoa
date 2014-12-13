<?php
App::uses('Usuario', 'Model');

/**
 * Usuario Test Case
 *
 */
class UsuarioTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.usuario',
		'app.perfil',
		'app.cita_historico',
		'app.cita',
		'app.lugar',
		'app.clase_reproduccion',
		'app.fuente',
		'app.especie',
		'app.criterio_seleccion_cita',
		'app.fichero',
		'app.lugare',
		'app.aso_dato_geografico',
		'app.observadore'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Usuario = ClassRegistry::init('Usuario');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Usuario);

		parent::tearDown();
	}

}
