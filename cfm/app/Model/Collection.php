<?php
App::uses('AppModel', 'Model');
/**
 * Collection Model
 *
 * @property Contract $Contract
 * @property ProgressivePaymentDetail $ProgressivePaymentDetail
 */
class Collection extends AppModel {
public $validate = array(
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
         'collection_type' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Collection Type(Adv/Progressive/Retention) is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
         'invoice_ref_no' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Invoice Ref. is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'invoice_amount' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Invoice Amount is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
       'currency' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Currency is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'planned_submission_date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Planned Invoice Submission Date is Required!',
                'allowEmpty' => false,
                'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'actual_submission_date' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Planned Invoice Submission Date is Required!',
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
		),
	);
        
        public function getCollectionCategoryByContract($contract_id=null,$category_id=null,$collection_type=null)
        {
            if ($contract_id && $category_id) {
            $option = array(
                'conditions' => array(
                    'Collection.contract_id' => $contract_id,
                    'Collection.product_category_id' => $category_id,
                    'Collection.collection_type LIKE' => $collection_type."%"
                )
            );
           if($this->find('first',$option))
           {
               return TRUE;
           }
           else{
               return FALSE;
           }
        }
        return FALSE;
    }
    
    public function getCollectionByTrackID($payment_cheque_collection_progressive=null,$product_category_id=null,$contract_id=null,$unitid=null,$clientid=null,$currency=null,$lot_id=null)
    {
        $this->recursive=-1;
        $conditions=array(
            'conditions'=>array(
                'Collection.contract_id' =>$contract_id,
                'Collection.product_category_id' =>$product_category_id,
                'Collection.contract_id' =>$contract_id,
                'Collection.unitid'=>$unitid,
                'Collection.clientid'=>$clientid,
                'Collection.currency'=>$currency,
                'Collection.lot_id'=>$lot_id,
                'Collection.planned_payment_certificate_or_cheque_collection_date'=>$payment_cheque_collection_progressive,
                'Collection.collection_type LIKE'=>"Progressive",
                
            ),
            'fields'=>array(
                'Collection.invoice_ref_no',
                'Collection.actual_submission_date',
                'Collection.forecasted_payment_collection_date',
                'Collection.cheque_or_payment_certification_date',
                'Collection.actual_payment_certificate_or_cheque_collection_date',
                'Collection.payment_credited_to_bank_date',
                'SUM(Collection.quantity)as quantity',
                'SUM(Collection.invoice_amount)as invoice_amount',
                'SUM(Collection.cheque_amount)as cheque_amount',
                'SUM(Collection.amount_received)as amount_received',
                'SUM(Collection.ajust_adv_amount)as ajust_adv_amount',
                'SUM(Collection.ait)as ait',
                'SUM(Collection.vat)as vat',
                'SUM(Collection.ld)as ld',
                'SUM(Collection.other_deduction)as other_deduction',                
            ),
            'order'=>array(
                'Collection.id'=>"DESC"
            )
        );
        
        $data=$this->find('first',$conditions);
        if($data){
            return $data;
        }
        else{
            return false;
        }
    }

}
