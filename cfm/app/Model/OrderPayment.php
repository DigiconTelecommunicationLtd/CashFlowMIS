<?php

App::uses('AppModel', 'Model');

/**
 * OrderPayment Model
 *
 * @property Order $Order
 * @property Client $Client
 */
class OrderPayment extends AppModel {

    public $validate = array(
        'received_date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Payment Received Date is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'payment_type' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Payment Type is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'received_amount' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Received amount is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'order_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Order ID is Required!',
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
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Order' => array(
            'className' => 'Order',
            'foreignKey' => 'order_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Client' => array(
            'className' => 'Client',
            'foreignKey' => 'client_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
