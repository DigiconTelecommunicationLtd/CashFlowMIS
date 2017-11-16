<?php
/**
 * OrderItem Fixture
 */
class OrderItemFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'order_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'invoice_no' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'product_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'product_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'unit_price' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'discount_percent' => array('type' => 'float', 'null' => false, 'default' => '0', 'unsigned' => false),
		'discount_amount' => array('type' => 'float', 'null' => false, 'default' => '0', 'unsigned' => false),
		'net_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'currency' => array('type' => 'string', 'null' => false, 'default' => 'BDT', 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'client_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'unsigned' => false),
		'client_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'added_by' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'added_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'order_id' => 1,
			'invoice_no' => 'Lorem ipsum dolor sit amet',
			'product_name' => 'Lorem ipsum dolor sit amet',
			'product_id' => 1,
			'unit_price' => 1,
			'discount_percent' => 1,
			'discount_amount' => 1,
			'net_amount' => 1,
			'currency' => 'L',
			'client_id' => 1,
			'client_name' => 'Lorem ipsum dolor sit amet',
			'added_by' => 'Lorem ipsum dolor sit amet',
			'added_date' => '2017-06-04',
			'status' => 1
		),
	);

}
