<?php
/**
 * Order Fixture
 */
class OrderFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'client_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'unsigned' => false),
		'client_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'invoice_no' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'total_bill' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'discount' => array('type' => 'float', 'null' => false, 'default' => '0', 'unsigned' => false),
		'net_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => false),
		'received_amount' => array('type' => 'float', 'null' => false, 'default' => '0', 'unsigned' => false),
		'ait' => array('type' => 'float', 'null' => false, 'default' => '0', 'unsigned' => false),
		'vat' => array('type' => 'float', 'null' => false, 'default' => '0', 'unsigned' => false),
		'ld' => array('type' => 'float', 'null' => false, 'default' => '0', 'unsigned' => false),
		'other_deduction' => array('type' => 'float', 'null' => false, 'default' => '0', 'unsigned' => false),
		'balance' => array('type' => 'float', 'null' => false, 'default' => '0', 'unsigned' => false),
		'currency' => array('type' => 'string', 'null' => false, 'default' => 'BDT', 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'delivery_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'added_by' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'added_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_by' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'modified_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'status' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 1, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'invoice_no' => array('column' => 'invoice_no', 'unique' => 1)
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
			'client_id' => 1,
			'client_name' => 'Lorem ipsum dolor sit amet',
			'invoice_no' => 'Lorem ipsum dolor sit amet',
			'total_bill' => 1,
			'discount' => 1,
			'net_amount' => 1,
			'received_amount' => 1,
			'ait' => 1,
			'vat' => 1,
			'ld' => 1,
			'other_deduction' => 1,
			'balance' => 1,
			'currency' => 'L',
			'delivery_date' => '2017-06-04',
			'added_by' => 'Lorem ipsum dolor sit amet',
			'added_date' => '2017-06-04 08:16:27',
			'modified_by' => 'Lorem ipsum dolor sit amet',
			'modified_date' => '2017-06-04 08:16:27',
			'status' => 1
		),
	);

}
