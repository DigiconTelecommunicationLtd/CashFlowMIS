<?php
App::uses('OrderItem', 'Model');

/**
 * OrderItem Test Case
 */
class OrderItemTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.order_item',
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
		'app.order_payment'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->OrderItem = ClassRegistry::init('OrderItem');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OrderItem);

		parent::tearDown();
	}

}
