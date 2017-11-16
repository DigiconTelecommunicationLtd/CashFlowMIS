<?php
App::uses('ClientBalance', 'Model');

/**
 * ClientBalance Test Case
 */
class ClientBalanceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.client_balance',
		'app.client',
		'app.contract',
		'app.unit',
		'app.collection',
		'app.contract_product',
		'app.product',
		'app.product_category',
		'app.delivery',
		'app.inspection',
		'app.procurement',
		'app.production',
		'app.progressive_payment',
		'app.lot'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ClientBalance = ClassRegistry::init('ClientBalance');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ClientBalance);

		parent::tearDown();
	}

}
