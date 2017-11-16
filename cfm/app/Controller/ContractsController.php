<?php

App::uses('AppController', 'Controller');

/**
 * Contracts Controller
 *
 * @property Contract $Contract
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ContractsController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $action = "/ ";
        $controller = "contracts";
        $options = array();
        $contracttypes = array('Supply' => 'Supply', 'Supply & Installation' => 'Supply & Installation');
        $dates = array(
            'added_date' => 'Contract Added Date',
            'contract_date' => 'Contract Sign/PO Receive Date',
            'delivery_strat_date' => 'Delivery Start Date',
            'contract_deadline' => 'Contract Deadline'
        );
        if ($this->request->is('post')) {
            if ($this->request->data['Contract']['date_from'] && $this->request->data['Contract']['date_to'] && $this->request->data['Contract']['date']) {
                $start_date=$this->request->data['Contract']['date_from'];
                $end_date=$this->request->data['Contract']['date_to'];                
                $options['SUBSTRING(Contract.'.$this->request->data['Contract']['date'].',1,10) BETWEEN ? AND ?'] =array($start_date,$end_date);
            }
            else if($this->request->data['Contract']['date_from'] && $this->request->data['Contract']['date_to'] ){
                 $start_date=$this->request->data['Contract']['date_from'];
                 $end_date=$this->request->data['Contract']['date_to'];   
                $options['SUBSTRING(Contract.added_date,1,10) BETWEEN ? AND ?'] = array($start_date,$end_date);
            }
            if ($this->request->data['Contract']['contracttype']) {
                $options['Contract.contracttype'] =$this->request->data['Contract']['contracttype'];
            }
            if ($this->request->data['Contract']['contract_id']) {
                $options['Contract.id'] = $this->request->data['Contract']['contract_id'];
            }
            /*
            if ($this->request->data['Contract']['currency']) {
                $options['Contract.currency'] =$this->request->data['Contract']['currency'];
            }*/
            if ($this->request->data['Contract']['unit_id']) {
                $options['Contract.unit_id'] =$this->request->data['Contract']['unit_id'];
            }
            if ($this->request->data['Contract']['client_id']) {
                $options['Contract.client_id']=$this->request->data['Contract']['client_id'];
            }
            
            $options=array('conditions'=>$options,'order' => array('Contract.id' => 'DESC'));
            //echo '<pre>';print_r($options);exit;
            $this->Contract->unbindModel(array('hasMany'=>array('Collection','ContractProduct','Lot')));
            $results=$this->Contract->find('all', $options);
        }      
        
        
        #contract list box
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);
        #/contract list box
        #currency list box
        $currencies = array('USD' => 'USD', 'BDT' => 'BDT');
        #/currency list box
        #Client list box
        $clients = $this->Contract->Client->find('list');
        #/Client list box
        #Unit list box
        $units = $this->Contract->Unit->find('list');     
        #/Unit list box
        $this->set(compact('results','contracts','currencies','clients','units','start_date','end_date','controller','action','dates','contracttypes','contract_amounts'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Contract->exists($id)) {
            throw new NotFoundException(__('Invalid contract'));
        }
        $options = array('conditions' => array('Contract.' . $this->Contract->primaryKey => $id));
        #contract products
        $this->loadModel('ContractProduct');
        $this->ContractProduct->recursive = 0;
        $this->ContractProduct->unbindModel(array('belongsTo' => array('Contract')));
        $option = array('conditions' => array('ContractProduct.contract_id' => $id), 'order' => array('ContractProduct.product_category_id' => "ASC"));
        $cproducts = $this->ContractProduct->find('all', $option);
        #/contract products
        #contract collections
        $this->loadModel('Collection');
        $this->Collection->recursive = 0;
        $this->Collection->unbindModel(array('belongsTo' => array('Contract')));
        $option = array('conditions' => array('Collection.contract_id' => $id), 'order' => array('Collection.collection_type' => "ASC"));
        $collections = $this->Collection->find('all', $option);
        $this->set(compact('cproducts', 'collections'));
        #/contract collections 
        #contract lot
        $this->loadModel('LotProduct');
        $this->LotProduct->recursive = 0;
        $this->LotProduct->unbindModel(array('belongsTo' => array('Contract')));
        $option = array('conditions' => array('LotProduct.contract_id' => $id), 'order' => array('LotProduct.lot_id' => "ASC"));
        $lotProducts = $this->LotProduct->find('all', $option);
        $this->set(compact('cproducts', 'collections', 'lotProducts'));
         #/contract lot
        #procurement
        $this->loadModel('Procurement');
        $this->Procurement->recursive = 0;
        $this->Procurement->unbindModel(array('belongsTo' => array('Contract')));
        $option = array('conditions' => array('Procurement.contract_id' => $id), 'order' => array('Procurement.lot_id' => "ASC"));
        $procurements = $this->Procurement->find('all', $option);

        #production
        $this->loadModel('Production');
        $this->Production->recursive = 0;
        $this->Production->unbindModel(array('belongsTo' => array('Contract')));
        $option = array('conditions' => array('Production.contract_id' => $id), 'order' => array('Production.lot_id' => "ASC"));
        $productions = $this->Production->find('all', $option);
        #Inspection
        $this->loadModel('Inspection');
        $this->Inspection->recursive = 0;
        $this->Inspection->unbindModel(array('belongsTo' => array('Contract')));
        $option = array('conditions' => array('Inspection.contract_id' => $id), 'order' => array('Inspection.lot_id' => "ASC"));
        $inspections = $this->Inspection->find('all', $option);

        #Delivery
        $this->loadModel('Delivery');
        $this->Delivery->recursive = 0;
        $this->Delivery->unbindModel(array('belongsTo' => array('Contract')));
        $option = array('conditions' => array('Delivery.contract_id' => $id), 'order' => array('Delivery.lot_id' => "ASC"));
        $deliverys = $this->Delivery->find('all', $option);

        $this->set(compact('cproducts', 'collections', 'lotProducts', 'procurements', 'productions', 'inspections', 'deliverys'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $form_staus=true;
            if(!trim($this->request->data['Contract']['contract_value_usd'])&&!trim($this->request->data['Contract']['contract_value_bdt'])){
                $message[]='PO Value BDT OR USD is requird. Please, try again.';
                $form_staus=false;
            }
            
             if(!trim($this->request->data['Contract']['product_category_id'])){
                $message[]='Please choose a category for adv and retention invoice auto generation. Please, try again.';
                $form_staus=false;
            }
            //date format is y-m-d
            $this->request->data['Contract']['contract_date']=  date('Y-m-d',  strtotime($this->request->data['Contract']['contract_date']));
            $this->request->data['Contract']['delivery_strat_date']=  date('Y-m-d',  strtotime($this->request->data['Contract']['delivery_strat_date']));
            $this->request->data['Contract']['contract_deadline']=  date('Y-m-d',  strtotime($this->request->data['Contract']['contract_deadline']));
            
            $contract_value_usd=trim($this->request->data['Contract']['contract_value_usd']);
            $contract_value_bdt=trim($this->request->data['Contract']['contract_value_bdt']);
            
            $contract_deadline=trim(date('Y-m-d',  strtotime($this->request->data['Contract']['contract_deadline'])));
            
            //pecentange
            $billing_percent_adv=trim($this->request->data['Contract']['billing_percent_adv']);            
            $billing_percent_progressive=trim($this->request->data['Contract']['billing_percent_progressive']);            
            $billing_percent_first_retention=trim($this->request->data['Contract']['billing_percent_first_retention']);            
            $billing_percent_second_retention=trim($this->request->data['Contract']['billing_percent_second_retention']);  
            
            $total_billing_percent=$billing_percent_adv+$billing_percent_progressive+$billing_percent_first_retention+$billing_percent_second_retention;
             #check billing percent greater than 100 or less than or equal 0
            if($total_billing_percent>100||$total_billing_percent<=0){
              $message[]='Please give correct billing percent. Please, try again.';			   
              $form_staus=false;  
            }
            
            #adv dsys assumption
            $invoice_submission_adv=trim($this->request->data['Contract']['invoice_submission_adv']);
            $payment_cheque_collection_adv=trim($this->request->data['Contract']['payment_cheque_collection_adv']);            
            $payment_credited_to_bank_adv=trim($this->request->data['Contract']['payment_credited_to_bank_adv']);
			
             if($billing_percent_adv)
            {
             if(!$invoice_submission_adv||!$payment_cheque_collection_adv||!$payment_credited_to_bank_adv)
             {
               $message[]='Please give adv no of days assumption. Please, try again.';
			   
                $form_staus=false;  
             }
            }            
            
            //1st retention check
            $invoice_submission_retention=trim($this->request->data['Contract']['invoice_submission_retention']);
            $payment_cheque_collection_retention=trim($this->request->data['Contract']['payment_cheque_collection_retention']);
            $payment_credited_to_bank_retention=trim($this->request->data['Contract']['payment_credited_to_bank_retention']);
            
            if($billing_percent_first_retention)
            {
             if(!$invoice_submission_retention||!$payment_cheque_collection_retention||!$payment_credited_to_bank_retention)
             {
               $message[]='Please give 1st retention no of days assumption. Please, try again.';
                $form_staus=false;  
             }
            }
            //2nd retention check
            if($billing_percent_second_retention){
            $invoice_submission_retention_2nd=trim($this->request->data['Contract']['invoice_submission_retention_2nd']);
            $payment_cheque_collection_retention_2nd=trim($this->request->data['Contract']['payment_cheque_collection_retention_2nd']);            
            $payment_credited_to_bank_retention_2nd=trim($this->request->data['Contract']['payment_credited_to_bank_retention_2nd']);
            
            if(!$invoice_submission_retention_2nd||!$payment_cheque_collection_retention_2nd||!$payment_credited_to_bank_retention_2nd)
                {
                $message[]='Please give 2nd retention no of days assumption. Please, try again.';
                $form_staus=false;
               }
            }            
            $user = $this->Session->read('UserAuth');
            $UserID = $this->request->data['Contract']['added_by'] = $user['User']['username'];
            
            $this->Contract->create();
            if ($form_staus&&$this->Contract->save($this->request->data)) {
                $ContractID = $this->Contract->getLastInsertID();                
                $message_success[]='The contract has been saved.';
                
                //initial invoice no is 1
                $invoice=1;
                //if set bdt amount in po                
                if($contract_value_bdt)
                {
		   if($billing_percent_adv)	{
                   #generate adv invoice 1st invoice
                   $invoice_ref = str_pad($this->request->data['Contract']['contract_no'], 6, '0', STR_PAD_LEFT) . '/' . str_pad(++$invoice,2,'0', STR_PAD_LEFT) . '/';  
                   
                    //invoice date calculation (planned invoice submission)
                   $planned_submission_date1=  strtotime($this->request->data['Contract']['contract_date'])+$invoice_submission_adv*86400;
                   $planned_submission_date=date('Y-m-d',$planned_submission_date1);
                    //invoice date calculation (planned certification/cheque collection)
                   $payment_cheque_collection1= $planned_submission_date1+$payment_cheque_collection_adv*86400;
                   $payment_cheque_collection=date('Y-m-d',$payment_cheque_collection1);
                   
                   //invoice date calculation (planned Payment collection)
                   $payment_credited_to_bank1= $payment_cheque_collection1+$payment_credited_to_bank_adv*86400;
                   $payment_credited_to_bank=date('Y-m-d',$payment_credited_to_bank1);
                   
                   //Advance
                    $collection[]=array(
                        'Collection'=>array(                        
                            'contract_id'=>$ContractID,
                            'product_category_id'=>$this->request->data['Contract']['product_category_id'],
                            'quantity'=>0,
                            'collection_type'=>"Advance",
                            'invoice_ref_no'=>$invoice_ref,
                            'billing_percent'=>$billing_percent_adv,
                            'invoice_amount'=>round(($billing_percent_adv*$contract_value_bdt)/100,3),
                            'currency'=>"BDT",
                            'planned_submission_date'=>$planned_submission_date,
                            'actual_submission_date'=>$planned_submission_date,
                            'planned_payment_certificate_or_cheque_collection_date'=>$payment_cheque_collection,
                            'planned_payment_collection_date'=>$payment_credited_to_bank,                             
                            'remarks'=>"Auto Invoice Generate when PO Created.",
                            'added_by'=>$UserID,                        
                            'clientid'=>$this->request->data['Contract']['client_id'],
                            'unitid'=>$this->request->data['Contract']['unit_id']
                            )
                    );
				   }
                    
                    if($billing_percent_first_retention)
                    {
                    #generate 1st retention invoice 2nd invoice
                    $invoice_ref = str_pad($this->request->data['Contract']['contract_no'], 6, '0', STR_PAD_LEFT) . '/' . str_pad(++$invoice,2,'0', STR_PAD_LEFT) . '/';  
                    
                    //invoice date calculation (planned invoice submission)
                   $planned_submission_date1=  strtotime($this->request->data['Contract']['contract_deadline'])+$invoice_submission_retention*86400;
                   $planned_submission_date=date('Y-m-d',$planned_submission_date1);
                    //invoice date calculation (planned certification/cheque collection)
                   $payment_cheque_collection1= $planned_submission_date1+$payment_cheque_collection_retention*86400;
                   $payment_cheque_collection=date('Y-m-d',$payment_cheque_collection1);
                   
                   //invoice date calculation (planned Payment collection)
                   $payment_credited_to_bank1= $payment_cheque_collection1+$payment_credited_to_bank_retention*86400;
                   $payment_credited_to_bank=date('Y-m-d',$payment_credited_to_bank1);
                   
                     //1st retention
                     $collection[]=array(
                         'Collection'=>array(                        
                             'contract_id'=>$ContractID,
                             'product_category_id'=>$this->request->data['Contract']['product_category_id'],
                             'quantity'=>0,
                             'collection_type'=>"Retention(1st)",
                             'invoice_ref_no'=>$invoice_ref,
                             'billing_percent'=>$billing_percent_first_retention,
                             'invoice_amount'=>round(($billing_percent_first_retention*$contract_value_bdt)/100,3),
                             'currency'=>"BDT",
                             'planned_submission_date'=>$planned_submission_date,
                             'actual_submission_date'=>$planned_submission_date,
                             'planned_payment_certificate_or_cheque_collection_date'=>$payment_cheque_collection,
                             'planned_payment_collection_date'=>$payment_credited_to_bank, 
                             'remarks'=>"Auto Invoice Generate when PO Created.",
                             'added_by'=>$UserID,                        
                             'clientid'=>$this->request->data['Contract']['client_id'],
                             'unitid'=>$this->request->data['Contract']['unit_id']
                             )
                     );
                    }
                    //2nd retention
                    
                    if($billing_percent_second_retention)
                    {
                      #generate 1st retention invoice 2nd invoice
                    $invoice_ref = str_pad($this->request->data['Contract']['contract_no'], 6, '0', STR_PAD_LEFT) . '/' . str_pad(++$invoice,2,'0', STR_PAD_LEFT) . '/';  
                    
                    //invoice date calculation (planned invoice submission)
                   $planned_submission_date1=  strtotime($this->request->data['Contract']['contract_deadline'])+$invoice_submission_retention_2nd*86400;
                   $planned_submission_date=date('Y-m-d',$planned_submission_date1);
                    //invoice date calculation (planned certification/cheque collection)
                   $payment_cheque_collection1= $planned_submission_date1+$payment_cheque_collection_retention_2nd*86400;
                   $payment_cheque_collection=date('Y-m-d',$payment_cheque_collection1);
                   
                   //invoice date calculation (planned Payment collection)
                   $payment_credited_to_bank1= $payment_cheque_collection1+$payment_credited_to_bank_retention_2nd*86400;
                   $payment_credited_to_bank=date('Y-m-d',$payment_credited_to_bank1);

                    //2nd Retention
                     $collection[]=array(
                         'Collection'=>array(                        
                             'contract_id'=>$ContractID,
                             'product_category_id'=>$this->request->data['Contract']['product_category_id'],
                             'quantity'=>0,
                             'collection_type'=>"Retention(2nd)",
                             'invoice_ref_no'=>$invoice_ref,
                             'billing_percent'=>$billing_percent_second_retention,
                             'invoice_amount'=>round(($billing_percent_second_retention*$contract_value_bdt)/100,3),
                             'currency'=>"BDT",
                             'planned_submission_date'=>$planned_submission_date,
                             'actual_submission_date'=>$planned_submission_date,
                             'planned_payment_certificate_or_cheque_collection_date'=>$payment_cheque_collection,
                             'planned_payment_collection_date'=>$payment_credited_to_bank, 
                             'remarks'=>"Auto Invoice Generate when PO Created.",
                             'added_by'=>$UserID,                        
                             'clientid'=>$this->request->data['Contract']['client_id'],
                             'unitid'=>$this->request->data['Contract']['unit_id']
                             )
                     );  
                    }
                }//end bdt
                 //if set usd amount in po                
                if($contract_value_usd)
                {
		   if($billing_percent_adv)	{
                   #generate adv invoice 1st invoice
                   $invoice_ref = str_pad($this->request->data['Contract']['contract_no'], 6, '0', STR_PAD_LEFT) . '/' . str_pad(++$invoice,2,'0', STR_PAD_LEFT) . '/';  
                   //invoice date calculation (planned invoice submission)
                   $planned_submission_date1=  strtotime($this->request->data['Contract']['contract_date'])+$invoice_submission_adv*86400;
                   $planned_submission_date=date('Y-m-d',$planned_submission_date1);
                    //invoice date calculation (planned certification/cheque collection)
                   $payment_cheque_collection1= $planned_submission_date1+$payment_cheque_collection_adv*86400;
                   $payment_cheque_collection=date('Y-m-d',$payment_cheque_collection1);
                   
                   //invoice date calculation (planned Payment collection)
                   $payment_credited_to_bank1= $payment_cheque_collection1+$payment_credited_to_bank_adv*86400;
                   $payment_credited_to_bank=date('Y-m-d',$payment_credited_to_bank1); 
                   //Advance
                    $collection[]=array(
                        'Collection'=>array(                        
                            'contract_id'=>$ContractID,
                            'product_category_id'=>$this->request->data['Contract']['product_category_id'],
                            'quantity'=>0,
                            'collection_type'=>"Advance",
                            'invoice_ref_no'=>$invoice_ref,
                            'billing_percent'=>$billing_percent_adv,
                            'invoice_amount'=>round(($billing_percent_adv*$contract_value_usd)/100,3),
                            'currency'=>"USD",
                            'planned_submission_date'=>$planned_submission_date,
                            'actual_submission_date'=>$planned_submission_date,
                            'planned_payment_certificate_or_cheque_collection_date'=>$payment_cheque_collection,
                            'planned_payment_collection_date'=>$payment_credited_to_bank, 
                            'remarks'=>"Auto Invoice Generate when PO Created.",
                            'added_by'=>$UserID,                        
                            'clientid'=>$this->request->data['Contract']['client_id'],
                            'unitid'=>$this->request->data['Contract']['unit_id']
                            )
                    );
				   }
                    
                    if($billing_percent_first_retention)
                    {
                    #generate 1st retention invoice 2nd invoice
                    $invoice_ref = str_pad($this->request->data['Contract']['contract_no'], 6, '0', STR_PAD_LEFT) . '/' . str_pad(++$invoice,2,'0', STR_PAD_LEFT) . '/';  
                    
                     //invoice date calculation (planned invoice submission)
                   $planned_submission_date1=  strtotime($this->request->data['Contract']['contract_deadline'])+$invoice_submission_retention*86400;
                   $planned_submission_date=date('Y-m-d',$planned_submission_date1);
                    //invoice date calculation (planned certification/cheque collection)
                   $payment_cheque_collection1= $planned_submission_date1+$payment_cheque_collection_retention*86400;
                   $payment_cheque_collection=date('Y-m-d',$payment_cheque_collection1);
                   
                   //invoice date calculation (planned Payment collection)
                   $payment_credited_to_bank1= $payment_cheque_collection1+$payment_credited_to_bank_retention*86400;
                   $payment_credited_to_bank=date('Y-m-d',$payment_credited_to_bank1);
                    //1st retention
                     $collection[]=array(
                         'Collection'=>array(                        
                             'contract_id'=>$ContractID,
                             'product_category_id'=>$this->request->data['Contract']['product_category_id'],
                             'quantity'=>0,
                             'collection_type'=>"Retention(1st)",
                             'invoice_ref_no'=>$invoice_ref,
                             'billing_percent'=>$billing_percent_first_retention,
                             'invoice_amount'=>round(($billing_percent_first_retention*$contract_value_usd)/100,3),
                             'currency'=>"USD",
                             'planned_submission_date'=>$planned_submission_date,
                             'actual_submission_date'=>$planned_submission_date,
                             'planned_payment_certificate_or_cheque_collection_date'=>$payment_cheque_collection,
                             'planned_payment_collection_date'=>$payment_credited_to_bank, 
                             'remarks'=>"Auto Invoice Generate when PO Created.",
                             'added_by'=>$UserID,                        
                             'clientid'=>$this->request->data['Contract']['client_id'],
                             'unitid'=>$this->request->data['Contract']['unit_id']
                             )
                     );
                    }
                    //2nd retention
                    
                    if($billing_percent_second_retention)
                    {
                      #generate 1st retention invoice 2nd invoice
                    $invoice_ref = str_pad($this->request->data['Contract']['contract_no'], 6, '0', STR_PAD_LEFT) . '/' . str_pad(++$invoice,2,'0', STR_PAD_LEFT) . '/';  
                    //invoice date calculation (planned invoice submission)
                   $planned_submission_date1=  strtotime($this->request->data['Contract']['contract_deadline'])+$invoice_submission_retention_2nd*86400;
                   $planned_submission_date=date('Y-m-d',$planned_submission_date1);
                    //invoice date calculation (planned certification/cheque collection)
                   $payment_cheque_collection1= $planned_submission_date1+$payment_cheque_collection_retention_2nd*86400;
                   $payment_cheque_collection=date('Y-m-d',$payment_cheque_collection1);
                   
                   //invoice date calculation (planned Payment collection)
                   $payment_credited_to_bank1= $payment_cheque_collection1+$payment_credited_to_bank_retention_2nd*86400;
                   $payment_credited_to_bank=date('Y-m-d',$payment_credited_to_bank1);

                    //2nd Retention
                     $collection[]=array(
                         'Collection'=>array(                        
                             'contract_id'=>$ContractID,
                             'product_category_id'=>$this->request->data['Contract']['product_category_id'],
                             'quantity'=>0,
                             'collection_type'=>"Retention(2nd)",
                             'invoice_ref_no'=>$invoice_ref,
                             'billing_percent'=>$billing_percent_second_retention,
                             'invoice_amount'=>round(($billing_percent_second_retention*$contract_value_usd)/100,3),
                             'currency'=>"USD",
                             'planned_submission_date'=>$planned_submission_date,
                             'actual_submission_date'=>$planned_submission_date,
                             'planned_payment_certificate_or_cheque_collection_date'=>$payment_cheque_collection,
                             'planned_payment_collection_date'=>$payment_credited_to_bank, 
                             'remarks'=>"Auto Invoice Generate when PO Created.",
                             'added_by'=>$UserID,                        
                             'clientid'=>$this->request->data['Contract']['client_id'],
                             'unitid'=>$this->request->data['Contract']['unit_id']
                             )
                     );  
                    }
                }//end usd
                
                //save the Adv+Retention Invoice 
                $this->loadModel('Collection');
                $this->Collection->create();
                if($this->Collection->saveMany($collection)){
                    $message_success[]='Adv & Retention invoice has beeb saved.';
                }
                else{
                    $message_success[]='Adv & Retention invoice has not beeb saved. You have to add Adv+Retention invoice Manually';
                }
                $this->Session->setFlash(__(implode("\n", $message_success)));
                //echo '<pre>';print_r($collection);exit;
                return $this->redirect(array('controller' => 'contract_products', 'action' => 'add/' . $ContractID));
            } else {
                $this->Session->setFlash(__(implode("\n", $message)));
            }
        }        
        #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');        
        #Client List
        $clients = $this->Contract->Client->find('list');
        #Unit List
        $units = $this->Contract->Unit->find('list');
        #Contract type List
        $contracttypes = array('Supply' => 'Supply', 'Supply & Installation' => 'Supply & Installation');
        $this->set(compact('clients', 'units', 'contracttypes', 'data','product_categories'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Contract->exists($id)) {
            throw new NotFoundException(__('Invalid contract'));
        }
        if ($this->request->is(array('post', 'put'))) {
            #client id and unit id and contract id
            $client_id=$this->request->data['Contract']['client_id'];
            $unit_id=$this->request->data['Contract']['unit_id'];
            $id=$this->request->data['Contract']['id'];
             
           #client id and unit id and contract id hidden
            $clientid=$this->request->data['Contract']['clientid'];
            $unitid=$this->request->data['Contract']['unitid'];             
            
            
            $user = $this->Session->read('UserAuth');
            $this->request->data['Contract']['modified_by'] = $user['User']['username'];
            $this->request->data['Contract']['modified_date'] = date('Y-m-d h:i:s');
            
            //validation start
            $form_staus=true;
            if(!trim($this->request->data['Contract']['contract_value_usd'])&&!trim($this->request->data['Contract']['contract_value_bdt'])){
                $message[]='PO Value BDT OR USD is requird. Please, try again.';
                $form_staus=false;
            }
            /*
             if(!trim($this->request->data['Contract']['product_category_id'])){
                $message[]='Please choose a category for adv and retention invoice auto generation. Please, try again.';
                $form_staus=false;
            }*/
            //date format is y-m-d
            $this->request->data['Contract']['contract_date']=  date('Y-m-d',  strtotime($this->request->data['Contract']['contract_date']));
            $this->request->data['Contract']['delivery_strat_date']=  date('Y-m-d',  strtotime($this->request->data['Contract']['delivery_strat_date']));
            $this->request->data['Contract']['contract_deadline']=  date('Y-m-d',  strtotime($this->request->data['Contract']['contract_deadline']));
            
            $contract_value_usd=trim($this->request->data['Contract']['contract_value_usd']);
            $contract_value_bdt=trim($this->request->data['Contract']['contract_value_bdt']);
            
            $contract_deadline=trim(date('Y-m-d',  strtotime($this->request->data['Contract']['contract_deadline'])));
            
            //pecentange
            $billing_percent_adv=trim($this->request->data['Contract']['billing_percent_adv']);            
            $billing_percent_progressive=trim($this->request->data['Contract']['billing_percent_progressive']);            
            $billing_percent_first_retention=trim($this->request->data['Contract']['billing_percent_first_retention']);            
            $billing_percent_second_retention=trim($this->request->data['Contract']['billing_percent_second_retention']);             
            //adv dsys assumption
            $invoice_submission_adv=trim($this->request->data['Contract']['invoice_submission_adv']);
            $payment_cheque_collection_adv=trim($this->request->data['Contract']['payment_cheque_collection_adv']);            
            $payment_credited_to_bank_adv=trim($this->request->data['Contract']['payment_credited_to_bank_adv']);
             /*if($billing_percent_progressive>0)
            {
             if(!$invoice_submission_adv||!$payment_cheque_collection_adv||!$payment_credited_to_bank_adv)
             {
               $message[]='Please give adv no of days assumption. Please, try again.';
                $form_staus=false;  
             }
            }  */          
            
            //1st retention check
            $invoice_submission_retention=trim($this->request->data['Contract']['invoice_submission_retention']);
            $payment_cheque_collection_retention=trim($this->request->data['Contract']['payment_cheque_collection_retention']);
            $payment_credited_to_bank_retention=trim($this->request->data['Contract']['payment_credited_to_bank_retention']);
            
            if($billing_percent_first_retention>0)
            {
             if(!$invoice_submission_retention||!$payment_cheque_collection_retention||!$payment_credited_to_bank_retention)
             {
               $message[]='Please give 1st retention no of days assumption. Please, try again.';
                $form_staus=false;  
             }
            }
            //2nd retention check
            if($billing_percent_second_retention>0){
            $invoice_submission_retention_2nd=trim($this->request->data['Contract']['invoice_submission_retention_2nd']);
            $payment_cheque_collection_retention_2nd=trim($this->request->data['Contract']['payment_cheque_collection_retention_2nd']);            
            $payment_credited_to_bank_retention_2nd=trim($this->request->data['Contract']['payment_credited_to_bank_retention_2nd']);
            
            if(!$invoice_submission_retention_2nd||!$payment_cheque_collection_retention_2nd||!$payment_credited_to_bank_retention_2nd)
                {
                $message[]='Please give 2nd retention no of days assumption. Please, try again.';
                $form_staus=false;
               }
            }
            //validation check

            if ($form_staus&&$this->Contract->save($this->request->data)) {
                
                   if($client_id!=$clientid) 
                   {
                       #delivery client update
                       $sql="UPDATE deliveries SET clientid =$client_id WHERE contract_id=$id";
                       $this->Contract->query($sql);
                       #collection client update
                       $sql="UPDATE collections SET clientid =$client_id WHERE contract_id=$id";
                       $this->Contract->query($sql);
                       #collection client update
                       $sql="UPDATE progressive_payments SET clientid =$client_id WHERE contract_id=$id";
                       $this->Contract->query($sql);
                   }
                   if($unit_id!=$unitid) 
                   {
                      #delivery client update
                       $sql="UPDATE deliveries SET unitid =$unit_id WHERE contract_id=$id";
                       $this->Contract->query($sql);
                       #collection client update
                       $sql="UPDATE collections SET unitid =$unit_id WHERE contract_id=$id";
                       $this->Contract->query($sql);
                       #collection client update
                       $sql="UPDATE progressive_payments SET unitid =$unit_id WHERE contract_id=$id";
                       $this->Contract->query($sql); 
                   }
                
                $this->Session->setFlash(__('The contract has been saved.'));
                
                /***************************************update invoice date in delivaries**********************************************************/                
                    $this->autoRender=false;
                    $this->loadModel('Contract');
                    $this->loadModel('Delivery');
                    $this->Contract->recursive=-1;
                    $contracts=$this->Contract->find('all',array('conditions'=>array('Contract.id'=>$id)));
                     $this->Delivery->recursive=-1;
                    foreach ($contracts as $contract)
                    {
                        $contract_id=$contract['Contract']['id'];

                        $pli_pac_con=($contract['Contract']['pli_pac']>0)?$contract['Contract']['pli_pac']:0;
                        $pli_aproval_con=($contract['Contract']['pli_aproval']>0)?$contract['Contract']['pli_aproval']:0;
                        $rr_collection_progressive_con=($contract['Contract']['rr_collection_progressive']>0)?$contract['Contract']['rr_collection_progressive']:0;

                        $invoice_submission_progressive_con=($contract['Contract']['invoice_submission_progressive']>0)?$contract['Contract']['invoice_submission_progressive']:0;
                        $payment_cheque_collection_progressive_con=($contract['Contract']['payment_cheque_collection_progressive']>0)?$contract['Contract']['payment_cheque_collection_progressive']:0;
                        $payment_credited_to_bank_progressive_con=($contract['Contract']['payment_credited_to_bank_progressive']>0)?$contract['Contract']['payment_credited_to_bank_progressive']:0;

                         $conditions=array(
                            'conditions'=>array(
                                'Delivery.contract_id'=>$contract_id,
                                'Delivery.actual_delivery_date NOT LIKE'=>"0000-00-00",
                                //'Delivery.invoice_submission_progressive LIKE'=>"0000-00-00",//this condition may change
                            ),
                            'group'=>array(
                                'Delivery.contract_id',
                                'Delivery.actual_delivery_date'
                            )
                        );
                        $deliveries=$this->Delivery->find('all',$conditions);
                        $sql="";
                        foreach ($deliveries as $deliverie)
                        {
                            $invoice_submission_progressive_del=$deliverie['Delivery']['invoice_submission_progressive'];
                            $payment_cheque_collection_progressive_del=$deliverie['Delivery']['payment_cheque_collection_progressive'];
                            $payment_credited_to_bank_progressive_del=$deliverie['Delivery']['payment_credited_to_bank_progressive'];
                            //exit;
                            $actual_delivery_date=strtotime($deliverie['Delivery']['actual_delivery_date']);
                            $id=$deliverie['Delivery']['id'];

                            $pli_pac1 = $actual_delivery_date+$pli_pac_con * 86400;
                            $pli_pac = date('Y-m-d',$pli_pac1);

                            $pli_aproval1 = $pli_pac1 + $pli_aproval_con * 86400;
                            $pli_aproval = date('Y-m-d', $pli_aproval1);
                            //planned_rr_collection_date
                            $rr_collection_progressive1=$pli_aproval1+$rr_collection_progressive_con* 86400;
                            $rr_collection_progressive= date('Y-m-d', $rr_collection_progressive1);
                            //invoice_submission_progressive
                            $invoice_submission_progressive1 =$rr_collection_progressive1+ $invoice_submission_progressive_con * 86400;
                            $invoice_submission_progressive = date('Y-m-d', $invoice_submission_progressive1);                 
                            //payment_cheque_collection_progressive
                            $payment_cheque_collection_progressive1=$invoice_submission_progressive1+$payment_cheque_collection_progressive_con * 86400;
                            $payment_cheque_collection_progressive = date('Y-m-d', $payment_cheque_collection_progressive1);
                            //payment_credited_to_bank_progressive
                            $payment_credited_to_bank_progressive1=$payment_cheque_collection_progressive1+$payment_credited_to_bank_progressive_con * 86400;
                            $payment_credited_to_bank_progressive = date('Y-m-d', $payment_credited_to_bank_progressive1);

                            $sql.="UPDATE deliveries SET invoice_submission_progressive = '".$invoice_submission_progressive."',payment_cheque_collection_progressive='".$payment_cheque_collection_progressive."',payment_credited_to_bank_progressive='".$payment_credited_to_bank_progressive."' WHERE contract_id= $contract_id and actual_delivery_date='".$deliverie['Delivery']['actual_delivery_date']."';";
                            $payment_sql.="UPDATE collections SET planned_submission_date = '".$invoice_submission_progressive."', planned_payment_certificate_or_cheque_collection_date = '".$payment_cheque_collection_progressive."', planned_payment_collection_date = '".$payment_credited_to_bank_progressive."' WHERE contract_id=$contract_id AND planned_submission_date='".$invoice_submission_progressive_del."' AND planned_payment_certificate_or_cheque_collection_date='".$payment_cheque_collection_progressive_del."' AND planned_payment_collection_date='".$payment_credited_to_bank_progressive_del."';";
                         }
                        if($sql){

                         $this->Delivery->query($sql);
                         $this->Delivery->query($payment_sql);
                        }
                    } 
                /*********************************************************end of update delivaries*******************************************************************/
                  return $this->redirect(array('action' => '/ '));
            } else {
                $message[]='The contract could not be saved. Please, try again.';
                $this->Session->setFlash(__(implode("\n", $message)));
            }
        } else {
            $options = array('conditions' => array('Contract.' . $this->Contract->primaryKey => $id));
            $this->request->data = $this->Contract->find('first', $options);
        }
        $clients = $this->Contract->Client->find('list');
        $units = $this->Contract->Unit->find('list');
        $contracttypes = array('Supply' => 'Supply', 'Supply & Installation'=>'Supply & Installation');
        $this->set(compact('clients', 'units', 'contracttypes'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    
      public function delete($id = null) {
      $this->Contract->id = $id;
      if (!$this->Contract->exists()) {
      throw new NotFoundException(__('Invalid contract'));
      }
      $this->request->allowMethod('post', 'delete');
      if ($this->Contract->delete()) {
          
      #Delete all contract product    
      $sql="DELETE FROM contract_products WHERE contract_id=$id";
       $this->Contract->query($sql);
      
      #Delete all Lots  
      $sql="DELETE FROM lots WHERE contract_id=$id";
       $this->Contract->query($sql);
      
      #Delete all Lot products
      $sql="DELETE FROM lot_products WHERE contract_id=$id";
       $this->Contract->query($sql);
      
      #Delete all procurements
      $sql="DELETE FROM procurements WHERE contract_id=$id";
      $this->Contract->query($sql);
      
      #Delete all productions
      $sql="DELETE FROM productions WHERE contract_id=$id";
       $this->Contract->query($sql);
      
      #Delete all inspections
      $sql="DELETE FROM inspections WHERE contract_id=$id";
       $this->Contract->query($sql);
      
      #Delete all deliveries
      $sql="DELETE FROM deliveries WHERE contract_id=$id";      
       $this->Contract->query($sql);
      
      #Delete all deliveries
      $sql="DELETE FROM progressive_payments WHERE contract_id=$id";
      $this->Contract->query($sql);
      
      $this->Session->setFlash(__('The contract has been deleted.'));
      } else {
      $this->Session->setFlash(__('The contract could not be deleted. Please, try again.'));
      }
      return $this->redirect(array('action' => 'index'));
      }    
    
    // contract list
    public function __getContractsListBox() {
            $this->autoRender=false;
            $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
            $this->Contract->recursive=-1;
            return $this->Contract->find('list', $options);
            
    }
    
    public function __getAssumptionByContract($contract_id=null)
    {
        $this->Contract->recursive=-1;
        return $this->Contract->findById($contract_id);
    }
}
