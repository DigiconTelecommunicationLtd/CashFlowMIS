<?php
App::uses('AppModel', 'Model');
/**
 * Lot Model
 *
 * @property Contract $Contract
 * @property Delivery $Delivery
 * @property Inspection $Inspection
 * @property LotProduct $LotProduct
 * @property Procurement $Procurement
 * @property Production $Production
 * @property ProgressivePaymentDetail $ProgressivePaymentDetail
 */
class Lot extends AppModel {
 public $displayField = 'lot_no';
    public $validate = array(
        'lot_no' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Lot Number is Required!',
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
                'message' => 'This Lot Number is already Exist!'
            ),
        ),
         'contract_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Contract/PO No: is Required!',
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
		'Contract' => array(
			'className' => 'Contract',
			'foreignKey' => 'contract_id',
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
/*	public $hasMany = array(
		'Delivery' => array(
			'className' => 'Delivery',
			'foreignKey' => 'lot_id',
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
		'Inspection' => array(
			'className' => 'Inspection',
			'foreignKey' => 'lot_id',
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
		'LotProduct' => array(
			'className' => 'LotProduct',
			'foreignKey' => 'lot_id',
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
		'Procurement' => array(
			'className' => 'Procurement',
			'foreignKey' => 'lot_id',
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
		'Production' => array(
			'className' => 'Production',
			'foreignKey' => 'lot_id',
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
*/
}
