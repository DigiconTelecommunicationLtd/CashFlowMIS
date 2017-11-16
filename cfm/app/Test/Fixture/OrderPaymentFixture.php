<?php
/**
 * OrderPayment Fixture
 */
class OrderPaymentFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'order_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'invoice_no' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'client_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'unsigned' => false),
		'client_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 22, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'bank_name' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 255, 'unsigned' => false),
		'payment_type' => array('type' => 'string', 'null' => false, 'default' => 'Advance', 'length' => 7, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'Branch_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'received_amount' => array('type' => 'float', 'null' => false, 'default' => '0', 'unsigned' => false),
		'ait' => array('type' => 'float', 'null' => false, 'default' => '0', 'unsigned' => false),
		'vat' => array('type' => 'float', 'null' => false, 'default' => '0', 'unsigned' => false),
		'ld' => array('type' => 'float', 'null' => false, 'default' => '0', 'unsigned' => false),
		'other_deduction' => array('type' => 'float', 'null' => false, 'default' => '0', 'unsigned' => false),
		'currency' => array('type' => 'string', 'null' => false, 'default' => 'BDT', 'length' => 3, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'received_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'added_by' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'remarks' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'added_date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified_by' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'modified_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
			'client_id' => 1,
			'client_name' => 'Lorem ipsum dolor si',
			'bank_name' => 1,
			'payment_type' => 'Lorem',
			'Branch_name' => 'Lorem ipsum dolor sit amet',
			'received_amount' => 1,
			'ait' => 1,
			'vat' => 1,
			'ld' => 1,
			'other_deduction' => 1,
			'currency' => 'L',
			'received_date' => '2017-06-04',
			'added_by' => 'Lorem ipsum dolor sit amet',
			'remarks' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'added_date' => '2017-06-04 08:18:42',
			'modified_by' => 'Lorem ipsum dolor sit amet',
			'modified_date' => '2017-06-04 08:18:42'
		),
	);

}
