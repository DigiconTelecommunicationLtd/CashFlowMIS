<?php

App::uses('AppModel', 'Model');

/**
 * Order Model
 *
 * @property Client $Client
 * @property OrderItem $OrderItem
 * @property OrderPayment $OrderPayment
 */
class Order extends AppModel {

    public $validate = array(
        'delivery_date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Delivery Date is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
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
        'net_amount' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Net Amount is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'invoice_no' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Invoice NO is Required!',
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
                'message' => 'This Invoice is already Exist!'
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
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'OrderItem' => array(
            'className' => 'OrderItem',
            'foreignKey' => 'order_id',
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
        'OrderPayment' => array(
            'className' => 'OrderPayment',
            'foreignKey' => 'order_id',
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
