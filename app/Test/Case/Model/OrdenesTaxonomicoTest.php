<?php
App::uses('OrdenesTaxonomico', 'Model');

/**
 * OrdenesTaxonomico Test Case
 *
 */
class OrdenesTaxonomicoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ordenes_taxonomico'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->OrdenesTaxonomico = ClassRegistry::init('OrdenesTaxonomico');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OrdenesTaxonomico);

		parent::tearDown();
	}

}
