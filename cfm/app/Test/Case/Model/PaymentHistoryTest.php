<?php
App::uses('PaymentHistory', 'Model');

/**
 * PaymentHistory Test Case
 */
class PaymentHistoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.payment_history',
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
		$this->PaymentHistory = ClassRegistry::init('PaymentHistory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PaymentHistory);

		parent::tearDown();
	}

}
