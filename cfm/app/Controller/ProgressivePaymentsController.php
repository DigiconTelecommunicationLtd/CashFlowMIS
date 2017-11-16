<?php

App::uses('AppController', 'Controller');

/**
 * ProgressivePayments Controller
 *
 * @property ProgressivePayment $ProgressivePayment
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ProgressivePaymentsController extends AppController {    
    public function add($contract_id = null, $currency = null,$lot_id=null) {
        
        if(!$contract_id||!$currency||!$lot_id){
            $this->Session->setFlash(__('The page is redirected from progressive payment add.'));
            return $this->redirect(array('controller'=>'collections','action'=>'progressive_payment_form/ '));
            exit;
        }
       
        $lot_id=str_replace('|','/',$lot_id);
        $user = $this->Session->read('UserAuth');
        $UserID = $this->request->data['ProgressivePayment']['added_by'] = $user['User']['username'];
        

        $options = array('conditions' => array('ProgressivePayment.added_by' => $UserID, 'ProgressivePayment.contract_id' =>$contract_id, 'ProgressivePayment.lot_id' =>$lot_id,'ProgressivePayment.status' => 0,'ProgressivePayment.sessionid' => 0), 'order' => array('ProgressivePayment.product_id' => 'ASC'));
        $productions=$this->ProgressivePayment->find('all', $options);
        
        #product ids
        $progressive_products=null;
        foreach ($productions as $value)
        {
            $progressive_products[$value['ProgressivePayment']['product_id']]=$value['ProgressivePayment']['product_id'];
        }
        if(!$progressive_products)
        {
            $this->Session->setFlash(__('The is no product for progressive payment.'));
            return $this->redirect(array('controller'=>'collections','action'=>'progressive_payment_form/ '));
            exit;
        }
         #find the category
            $contract_product_option=array(
                'conditions'=>array(
                 'ProgressivePayment.added_by' => $UserID,
                 'ProgressivePayment.contract_id' =>$contract_id,
                 'ProgressivePayment.lot_id' =>$lot_id,
                 'ProgressivePayment.status' => 0,
                 'ProgressivePayment.sessionid' => 0,
                 'ProgressivePayment.currency' => $currency
                ),
                'fields'=>array(
                    'ProductCategory.id',
                    'ProductCategory.name',
                    'SUM(ProgressivePayment.quantity) as quantity',
                    'SUM(ProgressivePayment.quantity*ProgressivePayment.unit_price) as amount'
                    ),
                'order'=>array(
                    'ProductCategory.name'=>"ASC"
                ),
                'group'=>array('ProgressivePayment.currency','ProgressivePayment.product_category_id')
            );  
          $product_category=  $this->ProgressivePayment->find('all',$contract_product_option);
          #echo '<pre>';print_r($product_category);exit;
        //sum
        $options = array('conditions' => array('ProgressivePayment.added_by' => $UserID, 'ProgressivePayment.contract_id' =>$contract_id, 'ProgressivePayment.lot_id' =>$lot_id,'ProgressivePayment.status' => 0),'fields'=>array('sum(ProgressivePayment.quantity*ProgressivePayment.unit_price) as invoice_amount','ProgressivePayment.trackid'), 'order' => array('ProgressivePayment.id' => 'DESC'));
        $ivoice_amount=$this->ProgressivePayment->find('first', $options);
        #trackid count
        $trackid=$ivoice_amount['ProgressivePayment']['trackid'];
        $this->loadModel('Contract');
        $option = array('conditions' => array('Contract.id' => $contract_id));
        $this->Contract->recursive =-1;
        $result = $this->Contract->find('first', $option);
         #find the collection number
            $option=array(
                'conditions'=>array(
                    'Collection.contract_id'=>$contract_id
                ),
                'fields'=>array( 
                    'COUNT(*) as no_collection'
                )
            );
            $this->loadModel('Collection');
            $this->Collection->recursive=-1;
            $collection=$this->Collection->find('first',$option);
            $no_collection=($collection[0]['no_collection'])?$collection[0]['no_collection']+1:1;
            $no_collection=str_pad($no_collection, 2, '0', STR_PAD_LEFT);
            
            #generate invoice number
            $invoice_ref=str_pad($result['Contract']['id'], 6, '0', STR_PAD_LEFT).'/'.$no_collection.'/';
             #invoice_value
            $invoice_value=round(($ivoice_amount[0]['invoice_amount']*$result['Contract']['billing_percent_progressive'])/100);
            $invoice_value=($invoice_value>0)?$invoice_value:0.00;
            #calculate balance
            $balance=$ivoice_amount[0]['invoice_amount']-$invoice_value;
            #find the delivery product with contract id,lot number and product id             
            $option = array('conditions' => array(
                    'Delivery.contract_id' => $contract_id,
                    'Delivery.lot_id' => $lot_id,
                    'Delivery.actual_delivery_date NOT LIKE' => '0000-00-00',
                    'Delivery.planned_pli_date NOT LIKE' => '0000-00-00',
                    'Delivery.planned_date_of_pli_aproval NOT LIKE' => '0000-00-00',
                    'Delivery.actual_date_of_pli_aproval NOT LIKE' => '0000-00-00',
                    'Delivery.product_id' =>$progressive_products
                ),
                'fields' => array(
                    'MAX(Delivery.actual_delivery_date) as actual_delivery_date',
                    'MAX(Delivery.planned_pli_date) as planned_pli_date',                   
                    'MAX(Delivery.planned_date_of_pli_aproval) as planned_date_of_pli_aproval',        
                    'MAX(Delivery.planned_rr_collection_date) as planned_rr_collection_date'
                ),
                'order'=>array(
                    'Delivery.id'=>array('DESC')
                )
            );
            $this->loadModel('Delivery');
            $this->Delivery->recursive=-1;
            $deliveries = $this->Delivery->find('first', $option);
            $actual_delivery_date=$deliveries[0]['actual_delivery_date'];
            $planned_pli_date=$deliveries[0]['planned_pli_date'];
            $planned_date_of_pli_aproval=$deliveries[0]['planned_date_of_pli_aproval'];
            $planned_rr_collection_date=$deliveries[0]['planned_rr_collection_date'];
            
           #/find the delivery product with contract id,lot number and product id 
           #product category list
           $this->loadModel('ProductCategory');
           $product_category_list=  $this->ProductCategory->find('list'); 
           
        
        
        $this->set(compact('trackid','product_category','actual_delivery_date','planned_rr_collection_date','planned_date_of_pli_aproval','planned_pli_date','productions','balance','invoice_value','invoice_ref','contracts', 'productions', 'contract_id', 'currency','lot_id','ivoice_amount','result','product_category_list'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->ProgressivePayment->id =$id; 
        if (!$this->ProgressivePayment->exists()) {
            throw new NotFoundException(__('Invalid progressive payment'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->ProgressivePayment->delete()) {
            $this->Session->setFlash(__('The progressive payment product has been deleted.'));
        } else {
            $this->Session->setFlash(__('The progressive payment product could not be deleted. Please, try again.'));
        }
        $this->redirect($this->referer());
    }

}
