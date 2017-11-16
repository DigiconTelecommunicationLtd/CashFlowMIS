<?php
App::uses('OrdersController', 'Controller');

/**
 * OrdersController Test Case
 */
class OrdersControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
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
		'app.order_item',
		'app.order_payment'
	);

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->markTestIncomplete('testIndex not implemented.');
	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {
		$this->markTestIncomplete('testView not implemented.');
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
		$this->markTestIncomplete('testAdd not implemented.');
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
		$this->markTestIncomplete('testEdit not implemented.');
	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
		$this->markTestIncomplete('testDelete not implemented.');
	}

}
