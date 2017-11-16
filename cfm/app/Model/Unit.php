<?php
App::uses('AppModel', 'Model');
/**
 * Unit Model
 *
 * @property Contract $Contract
 */
class Unit extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
        public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Company/Unit Name is Required!',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique'=>array(
			    'rule' => 'isUnique',
                'required' => true,
                'allowEmpty' => false,
                 //'on' => 'create', // here
                'last' => false,
                'message' => 'This Company/Unit Name is already Exist!'
			),
		),
	);


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Contract' => array(
			'className' => 'Contract',
			'foreignKey' => 'unit_id',
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
