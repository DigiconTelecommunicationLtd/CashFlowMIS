<?php
App::uses('AppModel', 'Model');
/**
 * Delivery Model
 *
 * @property Lot $Lot
 * @property Product $Product
 */
class Delivery extends AppModel {

public $validate = array(
        'product_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Product Name is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
     'lot_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Lot No. is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    'contract_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Contract/PO No is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
         'quantity' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Product quantity is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    'uom' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Unit of Measurement is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    'unit_weight' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Unit Weight is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),'planned_delivery_date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Panned Arrival Date is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),'actual_delivery_date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Actual Arrival Date is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ), 
    'clientid' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Client Info is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    'unitid' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Unit Info is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    'product_category_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Product Category Info is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		/*'Lot' => array(
			'className' => 'Lot',
			'foreignKey' => 'lot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),*/
                'ProductCategory' => array(
			'className' => 'ProductCategory',
			'foreignKey' => 'product_category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Contract' => array(
			'className' => 'Contract',
			'foreignKey' => 'contract_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
