<?php
App::uses('AppController', 'Controller');
/**
 * CollectionDetails Controller
 *
 * @property CollectionDetail $CollectionDetail
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CollectionDetailsController extends AppController {

/**
 * Components
 *
 * @var array
 */
 public $components = array('ExportXls');
/**
 * index method
 *
 * @return void
 */
	public function index() {           
                if ($this->request->is('post')) {
                    if($this->request->data['CollectionDetail']['invoice_ref_no'])
                    {
                        $option['CollectionDetail.invoice_ref_no LIKE']=$this->request->data['CollectionDetail']['invoice_ref_no']."%";
                    }
					if($this->request->data['CollectionDetail']['contract_id'])
                    {
                        $option['CollectionDetail.contract_id']=$this->request->data['CollectionDetail']['contract_id'];
                    }
					if($this->request->data['CollectionDetail']['currency'])
                    {
                        $option['CollectionDetail.currency']=$this->request->data['CollectionDetail']['currency'];
                    }
                    if($this->request->data['CollectionDetail']['date_from']||$this->request->data['CollectionDeatil']['date_to'])
                    {
                        $option['CollectionDetail.payment_credited_to_bank_date BETWEEN ? AND ?']=array(date('Y-m-d',  strtotime($this->request->data['CollectionDetail']['date_from'])),date('Y-m-d',  strtotime($this->request->data['CollectionDetail']['date_to'])));
                    }
                }   
               if($this->request->is('post')&&$this->request->data['CollectionDetail']['showreport']=="download"){
                $this->autoRender=false;
                $this->layout = false;
                $fileName = "received_payment_report_".date("d-m-y:h:s").".xls";
                $conditions=array(
                    'conditions'=>$option
                );
                $collectionDetails=  $this->CollectionDetail->find('all',$conditions);
                 foreach ($collectionDetails as $collectionDetail)
                    {
                        $data[]=array(
                            h($collectionDetail['Contract']['contract_no']),
                            h($collectionDetail['ProductCategory']['name']),
                            h($collectionDetail['CollectionDetail']['collection_type']),
                            h($collectionDetail['CollectionDetail']['invoice_ref_no']),
                            h($collectionDetail['CollectionDetail']['cheque_amount']),
                            h($collectionDetail['CollectionDetail']['amount_received']),
                            h($collectionDetail['CollectionDetail']['ajust_adv_amount']),
                            h($collectionDetail['CollectionDetail']['ait']),
                            h($collectionDetail['CollectionDetail']['vat']),
                            h($collectionDetail['CollectionDetail']['ld']),
                            h($collectionDetail['CollectionDetail']['other_deduction']),
                            h($collectionDetail['CollectionDetail']['currency']),
                            h($collectionDetail['CollectionDetail']['cheque_or_payment_certification_date']),
                            h($collectionDetail['CollectionDetail']['actual_payment_certificate_or_cheque_collection_date']),
                            h($collectionDetail['CollectionDetail']['forecasted_payment_collection_date']),
                            h($collectionDetail['CollectionDetail']['payment_credited_to_bank_date']),
                        );
                    }
                 $headerRow = array("PO/Contract No","Category/Product","Collection Type","Invoice Ref No","Cheque Amount","Received Amount","Adj. Adv. Amount","AIT","VAT","L.D","Other Deduction","Currency","Payment Certification/Cheque Date","Actual Payment Certification/Cheque Collection Date","Forecasted Payment Collection Date","Payment Received Date");
                 //echo '<pre>';print_r($data);exit;
                $this->ExportXls->export($fileName, $headerRow, $data);
               
                } 
                 else { 
                      $this->Paginator->settings = array(
                        'conditions' => $option,
                        'limit'=>10
                            );
                    $this->CollectionDetail->recursive = 0;
                    $this->set('collectionDetails', $this->Paginator->paginate());
                 }
            #contract list box
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);
        #currency list box
        $currencies = array('USD' => 'USD', 'BDT' => 'BDT');
        #Client list box
        $this->loadModel('Client');
        $this->Client->recursive = -1;
        $clients = $this->Client->find('list');
        #Unit list box
        $this->loadModel('Unit');
        $this->Unit->recursive = -1;
        $units = $this->Unit->find('list');
        #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');
        $this->set(compact('currencies', 'contracts', 'clients', 'units', 'product_categories'));		
               
	}

/**
 * add method
 *
 * @return void
 */
	public function add($collection_id=null) {
		if ($this->request->is('post')) {               
			$user = $this->Session->read('UserAuth');
                        $UserID = $this->request->data['Collection']['added_by'] = $user['User']['username'];                      
                        $collection_id=$this->request->data['CollectionDetail']['collection_id'];
                        //date format Y-m-d
                        $this->request->data['CollectionDetail']['cheque_or_payment_certification_date']=($this->request->data['CollectionDetail']['cheque_or_payment_certification_date'])?date('Y-m-d',  strtotime($this->request->data['CollectionDetail']['cheque_or_payment_certification_date'])):'';
                        $this->request->data['CollectionDetail']['actual_payment_certificate_or_cheque_collection_date']=($this->request->data['CollectionDetail']['actual_payment_certificate_or_cheque_collection_date'])?date('Y-m-d',  strtotime($this->request->data['CollectionDetail']['actual_payment_certificate_or_cheque_collection_date'])):'';
                        $this->request->data['CollectionDetail']['forecasted_payment_collection_date']=($this->request->data['CollectionDetail']['forecasted_payment_collection_date'])?date('Y-m-d',  strtotime($this->request->data['CollectionDetail']['forecasted_payment_collection_date'])):'';
                        //$this->request->data['CollectionDetail']['payment_credited_to_bank_date']=date('Y-m-d',  strtotime($this->request->data['CollectionDetail']['payment_credited_to_bank_date']));
                        //find the invoice data
                        $conditions=array(
                            'conditions'=>array(
                                'Collection.id'=>$collection_id
                            ),
                            'fields'=>array(                                
                                'Collection.cheque_amount',
                                'Collection.amount_received',
                                'Collection.ajust_adv_amount',
                                'Collection.ait',
                                'Collection.vat',
                                'Collection.ld',
                                'Collection.other_deduction'
                            )
                        );
                        
                        $this->loadModel('Collection');
                        $this->Collection->recursive=-1;
                        $collection=$this->Collection->find('first',$conditions);
                        
                        if($collection){
                        $this->request->data['Collection']['id']=$collection_id;    
                        $this->request->data['Collection']['cheque_amount']=$collection['Collection']['cheque_amount']+$this->request->data['CollectionDetail']['cheque_amount'];
                        //$this->request->data['Collection']['amount_received']=$collection['Collection']['amount_received']+$this->request->data['CollectionDetail']['amount_received'];
                        $this->request->data['Collection']['ajust_adv_amount']=$collection['Collection']['ajust_adv_amount']+$this->request->data['CollectionDetail']['ajust_adv_amount'];
                        $this->request->data['Collection']['ait']=$collection['Collection']['ait']+$this->request->data['CollectionDetail']['ait'];
                        $this->request->data['Collection']['vat']=$collection['Collection']['vat']+$this->request->data['CollectionDetail']['vat'];
                        $this->request->data['Collection']['ld']=$collection['Collection']['ld']+$this->request->data['CollectionDetail']['ld'];
                        $this->request->data['Collection']['other_deduction']=$collection['Collection']['other_deduction']+$this->request->data['CollectionDetail']['other_deduction'];
                       
                        }
                        $datasource = $this->CollectionDetail->getDataSource();
                        try {
                            $datasource->begin();
                            $this->CollectionDetail->create();  
                            
                            $this->request->data['CollectionDetail']['payment_by']=$UserID;
                            $this->request->data['CollectionDetail']['payment_date']=date('Y-m-d H:m:s');
                            $this->request->data['CollectionDetail']['modified_by']=$UserID;
                            $this->request->data['CollectionDetail']['modified_date']=date('Y-m-d H:m:s');
                           
                            if(!($this->CollectionDetail->save($this->request->data['CollectionDetail']))||!$collection)
                            {                                 
                                throw new Exception();
                            }
                           
                            if(!$this->Collection->save($this->request->data['Collection'],false))
                            {                                 
                                throw new Exception();
                            }
                           
                            $datasource->commit();
                            
                            $this->Session->setFlash(__('Certification/Cheque information has been saved.'));
		            
                           
                        } catch(Exception $e) {
                            $datasource->rollback();
                            $this->Session->setFlash(__('The Certification/Cheque information could not be saved. Please, try again.'));
                        }
                        //redirect to the add action
                        //return $this->redirect(array('action' => 'add/'.$collection_id));
                        return $this->redirect($this->referer());
		}
                
                $this->loadModel('Collection');
		if (!$this->Collection->exists($collection_id)) { //check the existence of the collection information
			throw new NotFoundException(__('Invalid Invoice Information'));
                }else{                    
                    $this->Collection->bindModel(array('hasMany'=>array('CollectionDetail')));
                    $data=$this->Collection->findById($collection_id);
                    //echo '<pre>';print_r($data);exit;
                }
                
		$this->set(compact('data'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CollectionDetail->exists($id)) {
			throw new NotFoundException(__('Invalid collection detail'));
		}
		if ($this->request->is(array('post', 'put'))) {
                    
                     $user = $this->Session->read('UserAuth');
                     $UserID = $this->request->data['Collection']['added_by'] = $user['User']['username'];
                     $collection_id=$this->request->data['CollectionDetail']['collection_id'];
                     $id=$this->request->data['CollectionDetail']['id'];
                     $this->request->data['CollectionDetail']['payment_credited_to_bank_date']=($this->request->data['CollectionDetail']['payment_credited_to_bank_date'])?date('Y-m-d',  strtotime($this->request->data['CollectionDetail']['payment_credited_to_bank_date'])):'';
                      //find the invoice data
                        $conditions=array(
                            'conditions'=>array(
                                'Collection.id'=>$collection_id
                            ),
                            'fields'=>array(
							    'Collection.cheque_amount',
                                'Collection.amount_received',
                                'Collection.ajust_adv_amount',
                                'Collection.ait',
                                'Collection.vat',
                                'Collection.ld',
                                'Collection.other_deduction'
                            )
                        );
                        
                        $this->loadModel('Collection');
                        $this->Collection->recursive=-1;
                        $collection=$this->Collection->find('first',$conditions);
                        //find the collection details record
                        $this->CollectionDetail->recursive=-1;
                        $collectionDetails=$this->CollectionDetail->findById($id);
                        
                        
                        if($collection){
                        $this->request->data['Collection']['id']=$collection_id;
                        $this->request->data['Collection']['cheque_amount']=$collection['Collection']['cheque_amount']-$collectionDetails['CollectionDetail']['cheque_amount']+$this->request->data['CollectionDetail']['cheque_amount'];
                        $this->request->data['Collection']['amount_received']=$collection['Collection']['amount_received']-$collectionDetails['CollectionDetail']['amount_received']+$this->request->data['CollectionDetail']['amount_received'];
                        $this->request->data['Collection']['ajust_adv_amount']=$collection['Collection']['ajust_adv_amount']-$collectionDetails['CollectionDetail']['ajust_adv_amount']+$this->request->data['CollectionDetail']['ajust_adv_amount'];
                        $this->request->data['Collection']['ait']=$collection['Collection']['ait']-$collectionDetails['CollectionDetail']['ait']+$this->request->data['CollectionDetail']['ait'];
                        $this->request->data['Collection']['vat']=$collection['Collection']['vat']-$collectionDetails['CollectionDetail']['vat']+$this->request->data['CollectionDetail']['vat'];
                        $this->request->data['Collection']['ld']=$collection['Collection']['ld']-$collectionDetails['CollectionDetail']['ld']+$this->request->data['CollectionDetail']['ld'];
                        $this->request->data['Collection']['other_deduction']=$collection['Collection']['other_deduction']-$collectionDetails['CollectionDetail']['other_deduction']+$this->request->data['CollectionDetail']['other_deduction'];
                       
                        }
                    
			$datasource = $this->CollectionDetail->getDataSource();
                        try {
                            $datasource->begin();
                            $this->request->data['CollectionDetail']['payment_by']=$UserID;
                            $this->request->data['CollectionDetail']['payment_date']=date('Y-m-d H:m:s');
                            $this->request->data['CollectionDetail']['modified_by']=$UserID;
                            $this->request->data['CollectionDetail']['modified_date']=date('Y-m-d H:m:s');
                            if(!($this->CollectionDetail->save($this->request->data['CollectionDetail']))||!$collection||!$collectionDetails)
                            {                                 
                                throw new Exception();
                            }
                           
                            if(!$this->Collection->save($this->request->data['Collection'],false))
                            {                                 
                                throw new Exception();
                            }
                           
                            $datasource->commit();
                            
                            $this->Session->setFlash(__('Payment information has been saved.'));
		            
                           
                        } catch(Exception $e) {
                            $datasource->rollback();
                            $this->Session->setFlash(__('The Payment information could not be saved. Please, try again.'));
                        }
                        //redirect to the add action
                        //return $this->redirect(array('action' => 'add/'.$collection_id));
                        return $this->redirect($this->referer());
		} else {
			$options = array('conditions' => array('CollectionDetail.' . $this->CollectionDetail->primaryKey => $id));
                        $this->CollectionDetail->recursive=-1;
			$this->request->data = $this->CollectionDetail->find('first', $options);
                        //echo '<pre>';print_r($this->request->data);exit;
		}
		
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CollectionDetail->id = $id;
		if (!$this->CollectionDetail->exists()) {
			throw new NotFoundException(__('Invalid collection detail'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->CollectionDetail->delete()) {
			$this->Session->setFlash(__('The collection detail has been deleted.'));
		} else {
			$this->Session->setFlash(__('The collection detail could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
