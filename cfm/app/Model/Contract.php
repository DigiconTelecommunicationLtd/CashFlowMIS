<?php
App::uses('AppModel', 'Model');
/**
 * Contract Model
 *
 * @property Client $Client
 * @property Unit $Unit
 * @property Contracttype $Contracttype
 * @property Collection $Collection
 * @property ContractProduct $ContractProduct
 * @property Lot $Lot
 */
class Contract extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'contract_no';
         public $validate = array(
        'contract_no' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Contract/PO No is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'required' => true,
                'allowEmpty' => false,
                //'on' => 'create', // here
                'last' => false,
                'message' => 'Contract/PO No is already Exist!'
            ),
        ),
         'client_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Client Name is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
         'unit_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Company/Unit Name is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'contracttype' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Contract Type is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
       'contract_date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Date of Contract is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'delivery_strat_date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Date of Delivery Start is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'contract_deadline' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Date of Contract Deadline is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ), 
       'billing_percent_adv' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Billing percent Adv is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
      'billing_percent_progressive' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Billing percent Progressive is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
       'billing_percent_first_retention' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Billing percent 1st Retention is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
       'billing_percent_second_retention' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Billing percent 2nd Retention is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
       'invoice_submission_adv' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Adv Invoice Submission is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'payment_cheque_collection_adv' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'payment_cheque_collection_adv is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
       'payment_credited_to_bank_adv' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'payment_credited_to_bank_adv is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
       'pli_pac' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'pli_pac is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'pli_aproval' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'pli_aproval is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'rr_collection_progressive' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'rr_collection_progressive is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
       'invoice_submission_progressive' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'invoice_submission_progressive is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
       'payment_cheque_collection_progressive' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'payment_cheque_collection_progressive is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),      
        'payment_credited_to_bank_progressive' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'payment_credited_to_bank_progressive is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),      
          'invoice_submission_retention' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'invoice_submission_retention is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),      
          'payment_cheque_collection_retention' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'payment_cheque_collection_retention is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),      
          'payment_credited_to_bank_retention' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'payment_credited_to_bank_retention is Required!',
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
		'Client' => array(
			'className' => 'Client',
			'foreignKey' => 'client_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Unit' => array(
			'className' => 'Unit',
			'foreignKey' => 'unit_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Collection' => array(
			'className' => 'Collection',
			'foreignKey' => 'contract_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ContractProduct' => array(
			'className' => 'ContractProduct',
			'foreignKey' => 'contract_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Lot' => array(
			'className' => 'Lot',
			'foreignKey' => 'contract_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
