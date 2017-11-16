<?php
App::uses('OrderPayment', 'Model');

/**
 * OrderPayment Test Case
 */
class OrderPaymentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.order_payment',
		'app.order',
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
		'app.lot',
		'app.order_item'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->OrderPayment = ClassRegistry::init('OrderPayment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OrderPayment);

		parent::tearDown();
	}

}
