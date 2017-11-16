<?php

App::uses('AppController', 'Controller');

/**
 * Deliveries Controller
 *
 * @property Delivery $Delivery
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class DeliveriesController extends AppController {

    public function add() {
        #default set values
        $option = '';
        $option_1 = '';
        $lot_id = null;

        if ($this->request->is('post')) {
            #set the date and date type
            $date = $this->request->data['Delivery']['date'];
            $date_type = $this->request->data['Delivery']['date_type'];
            
            #set the contract/lot id/submission type            
            $contract_id =$this->request->data['Delivery']['contract_id'];
            $lot_id =$this->request->data['Delivery']['lot_id'];
            $FormType =$this->request->data['Delivery']['FormType'];
            $up_to_psi =$this->request->data['Delivery']['psi'];
            
            #check the below valiable value set  
            if (!$contract_id || !$lot_id || !$FormType) {
                $this->Session->setFlash(__('PO & Lot number is required!. Please, try again.'));
                return $this->redirect(array('action' => 'add'));
            }
            #if category is set
            if ($this->request->data['Delivery']['product_category_id']) {
                $option['Inspection.product_category_id'] = $product_category_id = $this->request->data['Delivery']['product_category_id'];
                $option_1['Delivery.product_category_id'] = $this->request->data['Delivery']['product_category_id'];
            }
            #if planned_same_as_actual is set then planned and actual date will be same 
            $planned_same_as_actual = trim($this->request->data['Delivery']['planned_same_as_actual']);
            
            #inspection options
            $option['Inspection.contract_id'] = $contract_id;
            $option['Inspection.lot_id'] = (string) $lot_id;
            $option['Inspection.actual_inspection_date !='] = "0000-00-00";
            
            #delivery options
            $option_1['Delivery.contract_id'] = $contract_id;
            $option_1['Delivery.lot_id'] = (string) $lot_id;
            //set default lot no
            $lots[$lot_id] = $lot_id; 
            
            #if form is submitted then product information will be inserted into delivery table
            if ($FormType == 'submit'):
                #find the client and unit id from contracts
                $opton = array(
                    'conditions' => array(
                        'Contract.id' => $contract_id
                    ),
                    'fields' => array(
                        'Contract.client_id', 'Contract.unit_id'
                    )
                );
                $this->loadModel('Contract');
                $client_unit = $this->Contract->find('first', $opton);
                #set client and unit id to deliveries
                $clientid = ($client_unit['Contract']['client_id']) ? $client_unit['Contract']['client_id'] : "NULL";
                $unitid = ($client_unit['Contract']['unit_id']) ? $client_unit['Contract']['unit_id'] : "NULL";

                #find the currency of delivery products from contract products
                $con_prod_option = array(
                    'conditions' => array(
                        'ContractProduct.contract_id' => $contract_id
                    )
                );
                $this->loadModel('ContractProduct');
                $this->ContractProduct->recursive = -1;

                $con_porducts = $this->ContractProduct->find('all', $con_prod_option);

                #if planned and actual date is same then contract wise assumption is needed for  installation,receivetion etc.
                if ($planned_same_as_actual) {
                    #access the assumption by contract id from contract
                    App::uses('ContractsController', 'Controller');
                    $contract = new ContractsController();
                    $contract_assumption = $contract->__getAssumptionByContract($contract_id);
                }
                #/contract wise assumption
                foreach ($con_porducts as $value) {
                    #product category
                    $category[$value['ContractProduct']['product_id']] = $value['ContractProduct']['product_category_id'];
                    #Currency
                    $currency[$value['ContractProduct']['product_id']] = $value['ContractProduct']['currency'];
                    #Unit Price
                    $unit_price[$value['ContractProduct']['product_id']] = $value['ContractProduct']['unit_price'];
                    #UOM
                    $uom[$value['ContractProduct']['product_id']] = $value['ContractProduct']['uom'];
                    #Unit weight
                    $unit_weight[$value['ContractProduct']['product_id']] = $value['ContractProduct']['unit_weight'];
                    #Unit weight uom
                    $unit_weight_uom[$value['ContractProduct']['product_id']] = $value['ContractProduct']['unit_weight_uom'];
                }

                #Receive the submit form value
                #$this->Delivery->recursive=-1;
                $pquantitys = $this->request->data['Delivery']['quantity'];
                $planned = $this->request->data['Delivery']['planned'];
                #$actual=$this->request->data['Delivery']['actual'];
                $user = $this->Session->read('UserAuth');
                $UserID = $user['User']['username'];
                
                foreach ($pquantitys as $key => $quantity) {

                    /*****************of check lot qty and production qty ******************* */
                    #if qty and date not set properly
                    if (!$quantity || $quantity <= 0 || !trim($planned[$key])) {
                        continue;
                    }
                    /*********************************************skip rm/production/psi for below category**************************************** */
                    /* #check production qty with product id lot number
                      $ins_option1=array(
                      'conditions'=>array(
                      'Inspection.lot_id'=>$lot_id,
                      'Inspection.product_id'=>$key
                      ),
                      'fields'=>array(
                      'SUM(Inspection.quantity) as quantity'
                      )
                      );
                      $this->loadModel('Inspection');
                      //$this->Inspection->recursive=-1;
                      $lot_qty=$this->Inspection->find('first',$ins_option1);
                      $lot_qty=($lot_qty[0]['quantity']>0)?$lot_qty[0]['quantity']:0;

                      #check inspection qty with product id lot number
                      $delivery_option1=array(
                      'conditions'=>array(
                      'Delivery.lot_id'=>$lot_id,
                      'Delivery.product_id'=>$key
                      ),
                      'fields'=>array(
                      'SUM(Delivery.quantity) as quantity'
                      )
                      );
                      //$this->Delivery->recursive=-1;
                      $pro_qty=$this->Delivery->find('first',$delivery_option1);
                      $pro_qty=($pro_qty[0]['quantity']>0)?$pro_qty[0]['quantity']:0;
                      $pro_qty+=$quantity;
                      #compare lot size with production size
                      if($pro_qty>$lot_qty):
                      continue;
                      endif; */
                    /*                     * *******************************************skip rm/production/psi for below category**************************************** */
                    /*                     * ***************end of check lot qty and production qty ******************* */

                  

                    $quantity = trim($quantity);
                    if (isset($planned[$key])) {
                        $planned_delivery_date = str_replace(array("\r", "\n", "\t"), '', date('Y-m-d', strtotime($planned[$key])));
                        if ($planned_delivery_date == "1970-01-01") {
                            continue;
                        }
                    }

                    #set the planned pli and aproval date

                    if ($planned_same_as_actual) {
                        $planned_date_of_pli = $contract_assumption['Contract']['pli_pac'] * 86400 + strtotime($planned_delivery_date);
                        $planned_date_of_pli = date('Y-m-d', $planned_date_of_pli);

                        $planned_date_of_pli_approval = strtotime($planned_date_of_pli) + $contract_assumption['Contract']['pli_aproval'] * 86400;
                        $planned_date_of_pli_approval = date('Y-m-d', $planned_date_of_pli_approval);
                        //planned_rr_collection_date
                        $rr_collection_progressive=strtotime($planned_date_of_pli_approval)+$contract_assumption['Contract']['rr_collection_progressive']* 86400;
                        $rr_collection_progressive= date('Y-m-d', $rr_collection_progressive);
                        //invoice_submission_progressive
                        $planned_submission_date = strtotime($rr_collection_progressive)+ $contract_assumption['Contract']['invoice_submission_progressive'] * 86400;
                        $planned_submission_date = date('Y-m-d', $planned_submission_date);                        
                        //payment_cheque_collection_progressive
                        $planned_payment_certificate_or_cheque_collection_date=strtotime($planned_submission_date)+$contract_assumption['Contract']['payment_cheque_collection_progressive'] * 86400;
                        $planned_payment_certificate_or_cheque_collection_date = date('Y-m-d', $planned_payment_certificate_or_cheque_collection_date);
                        //payment_credited_to_bank_progressive
                        $payment_credited_to_bank_progressive=strtotime($planned_payment_certificate_or_cheque_collection_date)+$contract_assumption['Contract']['payment_credited_to_bank_progressive'] * 86400;
                        $payment_credited_to_bank_progressive = date('Y-m-d', $payment_credited_to_bank_progressive);
                    }
                    #/set the planned pli and aproval date 
                    $data_invoice['categoy'][$category[$key]]=$category[$key];
                    $data_invoice['delivery_amount'][$category[$key]].=$unit_price[$key]*$quantity;

                    $saveData[] = array(
                        'Delivery' => array(
                            'contract_id' => $contract_id,
                            'lot_id' => $lot_id,
                            'product_category_id' => $category[$key],
                            'product_id' => $key,
                            'quantity' => trim($quantity),
                            'unit_price' => $unit_price[$key],
                            'currency' => $currency[$key],
                            'uom' => $uom[$key],
                            'planned_delivery_date' => $planned_delivery_date,
                            'actual_delivery_date' => ($planned_same_as_actual) ? $planned_delivery_date : '0000-00-00',
                            'planned_pli_date' => ($planned_same_as_actual) ? $planned_date_of_pli : '0000-00-00',
                            'planned_date_of_pli_aproval' => ($planned_same_as_actual) ? $planned_date_of_pli_approval : '0000-00-00',
                            'planned_date_of_installation' => ($planned_same_as_actual) ? $planned_date_of_pli : '0000-00-00',
                            'planned_date_of_client_receiving' => ($planned_same_as_actual) ? $planned_date_of_pli_approval : '0000-00-00',
                            
                            'planned_rr_collection_date' => ($rr_collection_progressive) ? $rr_collection_progressive : '0000-00-00',
                            'invoice_submission_progressive' => ($planned_submission_date) ? $planned_submission_date : '0000-00-00',
                            'payment_cheque_collection_progressive' => ($planned_payment_certificate_or_cheque_collection_date) ? $planned_payment_certificate_or_cheque_collection_date : '0000-00-00',
                            'payment_credited_to_bank_progressive' => ($payment_credited_to_bank_progressive) ? $payment_credited_to_bank_progressive: '0000-00-00',
                            
                            'unit_weight' => $unit_weight[$key],
                            'unit_weight_uom' => $unit_weight_uom[$key],
                            'added_by' => $UserID,
                            'clientid' => $clientid,
                            'unitid' => $unitid
                        )
                    );
                }
                /*                 * *************save Delivery data*************** */
				
                $count_product = count($saveData);
                if ($saveData > 0) {
                    $this->Delivery->create();
                    if ($this->Delivery->saveMany($saveData)) {
                        $this->Session->setFlash(__($count_product . ' products has been saved successfully.'));
                    } else {
                        $this->Session->setFlash(__('Product could not saved successfully.Please, try again.'));
                    }
                } else {
                    $this->Session->setFlash(__('There is no product for saved.Please, try again.'));
                }
            /*             * *************end of save Delivery data*************** */
            endif;

            /*             * ************************* skip rm/production/psi for below category********************* */
            $category = array(1);
            $category2 = array(3, 5, 6, 7, 8,9);
            if (in_array($this->request->data['Delivery']['product_category_id'], $category)&& $up_to_psi) {
                #lot product option
                $option_lot['LotProduct.product_category_id'] =$this->request->data['Delivery']['product_category_id'];
                $option_lot['LotProduct.contract_id'] = $contract_id;
                $option_lot['LotProduct.lot_id'] = $lot_id;
               
                #find the lot products 
                App::uses('LotProductsController', 'Controller');
                $lots = new LotProductsController();
                $inspection_results = $lots->__getLotProducts($option_lot);
                #set the model
                $model = "LotProduct";
                $label="A.Com.Date";   
            }/** ************************* skip rm/production/psi for above category********************* */ 
           
           else if (in_array($this->request->data['Delivery']['product_category_id'], $category2)|| $up_to_psi) {
                #lot product option
                $option_product['Production.product_category_id'] = ($this->request->data['Delivery']['product_category_id'])?$this->request->data['Delivery']['product_category_id']:$category2;
                $option_product['Production.contract_id'] = $contract_id;
                $option_product['Production.lot_id'] = $lot_id;
                
                #find the production products with filter options
                App::uses('ProductionsController', 'Controller');  
                $production=new ProductionsController();
                $inspection_results =$production->__getProductionProductsforInspection($option_product);
                #set the model
                $model = "Production";
                
                /*Actual date for product arrival from procurement option*/  
                $actaul_date_options=null;
                $actaul_date_result=null;
                $actual_column="actual_completion_date";
                $label="A.Com.Date"; 
                if($contract_id)
                {
                    $actaul_date_options[$model.'.contract_id']=$contract_id;
                }
                if($lot_id)
                {
                    $actaul_date_options[$model.'.lot_id']=$lot_id;
                }
                if($product_category_id)
                {
                    $actaul_date_options[$model.'.product_category_id']=$product_category_id;
                }
                $this->loadModel($model);
                
                if($actaul_date_options){
                    $actaul_date_options=array('conditions'=>array($actaul_date_options),'fields'=>array($model.'.product_id',$model.'.'.$actual_column),'order'=>array($model.'.id'=>'DESC'));
                    $actaul_date_info=  $this->$model->find('list',$actaul_date_options);
                    $this->set(compact('actaul_date_info','label')); 
                }
            /* End Actual date for product arrival from procurement option*/
                
                
            }/** ************************* skip rm/psi for above category********************* */ 
            else {
                #get the inspection products
                App::uses('InspectionsController', 'Controller');
                $inspection = new InspectionsController();
                //echo '<pre>';print_r($option);exit;
                $inspection_results = $inspection->__getInspectionProductForDelivery($option);
                #echo '<pre>';print_r($inspection_results);exit;
                #set the model
                $model = "Inspection";
                
                /*Actual date for product arrival from procurement option*/  
                $actaul_date_options=null;
                $actaul_date_result=null;
                $actual_column="actual_inspection_date";
                $label="A.Ins.Date"; 
                if($contract_id)
                {
                    $actaul_date_options[$model.'.contract_id']=$contract_id;
                }
                if($lot_id)
                {
                    $actaul_date_options[$model.'.lot_id']=$lot_id;
                }
                if($product_category_id)
                {
                    $actaul_date_options[$model.'.product_category_id']=$product_category_id;
                }
                $this->loadModel($model);
                
                if($actaul_date_options){
                    $actaul_date_options=array('conditions'=>array($actaul_date_options),'fields'=>array($model.'.product_id',$model.'.'.$actual_column),'order'=>array($model.'.id'=>'DESC'));
                    $actaul_date_info=  $this->$model->find('list',$actaul_date_options);
                    $this->set(compact('actaul_date_info')); 
                }
            /* End Actual date for product arrival from procurement option*/
            }
            #get the lot products by contract
            App::uses('LotsController', 'Controller');
            $lots = new LotsController();
            $lots = $lots->__getLotNumberListBoxByContract($contract_id);

            #previously delivery product by contract and lot wise
            $result = $this->__getDeliveryProducts($option_1);
            $this->Delivery->unbindModel(array('belongsTo' => array('Contract')));
            $actual_date_results = $this->Delivery->find('all', array('conditions' => $option_1, 'order' => array('Delivery.product_id' => 'ASC')));
            //echo '<pre>';print_r($actual_date_results);exit;
        }
        #get the contract products
        App::uses('ContractsController', 'Controller');
        $contracts = new ContractsController();
        $contracts = $contracts->__getContractsListBox();

        #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');
        #set the result
        $this->set(compact('label','up_to_psi','product_category_id', 'model', 'lots_products', 'date', 'date_type', 'contracts', 'lots', 'contract_id', 'lot_id', 'inspection_results', 'result', 'actual_date_results', 'product_categories'));
    }

    public function __getDeliveryProducts(&$option) {
        if (empty($option)) {
            return '';
        }
        $condition = array('conditions' => array($option), 'fields' => array('Delivery.product_id', 'SUM(Delivery.quantity) as quantity', /* 'MAX(Delivery.planned_completion_date) planned_completion_date', 'MAX(Delivery.actual_completion_date) actual_completion_date', */ 'Delivery.lot_id'), 'group' => array('Delivery.contract_id', 'Delivery.lot_id', 'Delivery.product_id'), 'order' => array('Delivery.product_id' => 'ASC'));
        $pmt_products = $this->Delivery->find('all', $condition);
        $data = array();
        foreach ($pmt_products as $key => $value) {
            $data[$value['Delivery']['product_id']] = $value[0]['quantity'];
            /*  $data['pd_' . $value['Delivery']['product_id']] = $value[0]['planned_completion_date'];
              $data['ad_' . $value['Delivery']['product_id']] = $value[0]['actual_completion_date']; */
        }
        return $data;
    }

    public function actual_delivery_date_editing() {
        $this->autoRender = FALSE;
        if ($this->request->data) {
            $user = $this->Session->read('UserAuth');
            $UserID = $user['User']['username'];
            $this->layout = 'ajax';
            $id = $this->request->data['id'];
            if (isset($this->request->data['actual_date_update'])) {
                $actual_date_update = str_replace(array("\r", "\n", "\t"), '', date('Y-m-d', strtotime($this->request->data['actual_date_update'])));
            }
            $app_conl = new AppController();
            $check = $app_conl->validateDate($actual_date_update);
            $message = "Wrong:Date Format!";
            //check already exist
            if (!$this->Delivery->exists($id)) {
                throw new NotFoundException(__('Invalid Delivery'));
            } else {
                $contractID = $this->request->data['contractID'];
                App::uses('ContractsController', 'Controller');

                $contract = new ContractsController();
                $contract_assumption = $contract->__getAssumptionByContract($contractID);

                $planned_date_of_pli = $contract_assumption['Contract']['pli_pac'] * 86400 + strtotime($actual_date_update);
                $planned_date_of_pli = date('Y-m-d', $planned_date_of_pli);

                $planned_date_of_pli_approval = strtotime($planned_date_of_pli) + $contract_assumption['Contract']['pli_aproval'] * 86400;
                $planned_date_of_pli_approval = date('Y-m-d', $planned_date_of_pli_approval);
            }


            if ($check && $id):
                // $actual_date_update=$this->request->data['actual_date_update'];
                $this->Delivery->id = $id;
                $this->beforeRender();
                if ($this->Delivery->saveField('actual_delivery_date', $actual_date_update, false)) {

                    $this->Delivery->saveField('planned_pli_date', $planned_date_of_pli, false);
                    $this->Delivery->saveField('planned_date_of_pli_aproval', $planned_date_of_pli_approval, false);

                    /* client receiveing */
                    $this->Delivery->saveField('planned_date_of_installation', $planned_date_of_pli, false);
                    $this->Delivery->saveField('planned_date_of_client_receiving', $planned_date_of_pli_approval, false);

                    $this->Delivery->saveField('modified_by', $UserID, false);
                    $this->Delivery->saveField('modified_date', date('Y-m-d h:m:i'), false);
                    $message = "Record updated successfully.";
                } else {
                    $message = "Error:There is an error while record updating!";
                }
            endif;
            echo $message;

            // $this->set(compact('actual_date_update','message'));
        }
    }

    public function actual_delivery_date_editing_all() {
        $this->layout = 'ajax';
        $this->request->accepts('application/json');
        $data = $this->request->input('json_decode', true);
        $user = $this->Session->read('UserAuth');
        $UserID = $user['User']['username'];
        $sql = '';
        if ($data) {

            $contractID = $data[0]['contract_id'];

            App::uses('ContractsController', 'Controller');

            $contract = new ContractsController();
            $contract_assumption = $contract->__getAssumptionByContract($contractID);



            foreach ($data as $value) {
                $id = $value['id'];
                $actual_date = $value['actual_date'];
                if ($id && $actual_date && $contractID) {

                    $actual_date = str_replace(array("\r", "\n", "\t"), '', date('Y-m-d', strtotime($actual_date)));

                    $planned_date_of_pli = $contract_assumption['Contract']['pli_pac'] * 86400 + strtotime($actual_date);
                    $planned_date_of_pli = date('Y-m-d', $planned_date_of_pli);

                    $planned_date_of_pli_approval = strtotime($planned_date_of_pli) + $contract_assumption['Contract']['pli_aproval'] * 86400;
                    $planned_date_of_pli_approval = date('Y-m-d', $planned_date_of_pli_approval);
                    
                    
                     //planned_rr_collection_date
                    $rr_collection_progressive=strtotime($planned_date_of_pli_approval)+$contract_assumption['Contract']['rr_collection_progressive']* 86400;
                    $rr_collection_progressive= date('Y-m-d', $rr_collection_progressive);
                    //invoice_submission_progressive
                    $planned_submission_date = strtotime($rr_collection_progressive)+ $contract_assumption['Contract']['invoice_submission_progressive'] * 86400;
                    $planned_submission_date = date('Y-m-d', $planned_submission_date);                        
                    //payment_cheque_collection_progressive
                    $planned_payment_certificate_or_cheque_collection_date=strtotime($planned_submission_date)+$contract_assumption['Contract']['payment_cheque_collection_progressive'] * 86400;
                    $planned_payment_certificate_or_cheque_collection_date = date('Y-m-d', $planned_payment_certificate_or_cheque_collection_date);
                    //payment_credited_to_bank_progressive
                    $payment_credited_to_bank_progressive=strtotime($planned_payment_certificate_or_cheque_collection_date)+$contract_assumption['Contract']['payment_cheque_collection_progressive'] * 86400;
                    $payment_credited_to_bank_progressive = date('Y-m-d', $payment_credited_to_bank_progressive);
                        
                        $sql.="UPDATE deliveries SET "
                            . "actual_delivery_date='" . $actual_date . "',"
                            . "planned_pli_date='" . $planned_date_of_pli . "',"
                            . "planned_date_of_pli_aproval='" . $planned_date_of_pli_approval . "',"
                            . "planned_date_of_installation='" . $planned_date_of_pli . "',"
                            . "planned_date_of_client_receiving='" . $planned_date_of_pli_approval . "',"
                            . "planned_rr_collection_date='" . $rr_collection_progressive . "',"
                            . "invoice_submission_progressive='" . $planned_submission_date . "',"
                            . "payment_cheque_collection_progressive='" . $planned_payment_certificate_or_cheque_collection_date . "',"
                            . "payment_credited_to_bank_progressive='" . $payment_credited_to_bank_progressive . "',"
                            . "modified_by= '" . $UserID . "',"
                            . " modified_date= '" . date('Y-m-d H:m:s') . "'"
                            . " WHERE id =$id;";
                }
            }

            if ($this->Delivery->query($sql)) {
                echo'1';
            } else {
                echo'2';
            }
        }
        $this->autoRender = FALSE;
    }

    public function post_landing_inspection() {

        if ($this->request->is('post')) {
            // $this->layout="ajax";
            $date = $this->request->data['Delivery']['date'];
            $date1 = $this->request->data['Delivery']['date1'];
            $contract_id = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['Delivery']['contract_id']));
            $lot_id = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['Delivery']['lot_id']));
            $product_id = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['Delivery']['product_id']));
            #check contract and lot no
            if ($contract_id && $lot_id) {
                $option['Delivery.contract_id'] = $contract_id;
                $option['Delivery.lot_id'] = (string) $lot_id;
                $option['Delivery.actual_delivery_date !='] = "0000-00-00";
                $lots[$lot_id] = $lot_id;
            } #if check contract and lot on of missing redirect to previous page
            else {
                return $this->redirect($this->referer());
            }
            if ($this->request->data['Delivery']['product_category_id']) {
                $option['Delivery.product_category_id'] = $this->request->data['Delivery']['product_category_id'];
            }

            #create list box with products name
            $results = $this->Delivery->find('all', array('conditions' => $option, 'order' => array('Delivery.id' => 'DESC')));
            foreach ($results as $value):
                $products[$value['Product']['id']] = $value['Product']['name'];
            endforeach;

            if ($product_id) {
                $option['Delivery.product_id'] = $product_id;
            }
            #contract assumption       
            App::uses('ContractsController', 'Controller');
            $contract = new ContractsController();
            $contract_assumption = $contract->__getAssumptionByContract($contract_id);
            //echo '<pre>';print_r($contract_assumption);exit;
            #find the delivery products according to options
            $this->Delivery->unbindModel(array('belongsTo' => array('Contract')));
            $actual_date_results = $this->Delivery->find('all', array('conditions' => $option, 'order' => array('Delivery.product_id' => 'ASC')));
        }

        App::uses('ContractsController', 'Controller');
        $contracts = new ContractsController();
        $contracts = $contracts->__getContractsListBox();

        //lots by contract
        App::uses('LotsController', 'Controller');
        $lots = new LotsController();
        $lots = $lots->__getLotNumberListBoxByContract($contract_id);

        #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');

        $this->set(compact('date', 'date1', 'contracts', 'lots', 'contract_id', 'lot_id', 'actual_date_results', 'contract_assumption', 'products', 'product_id', 'product_categories'));
    }

    public function actual_pli_date_editing() {
        $this->autoRender = FALSE;
        if ($this->request->data) {

            #initialize user name
            $user = $this->Session->read('UserAuth');
            $UserID = $user['User']['username'];
            $this->layout = 'ajax';

            #get the form submitted value            
            $id = $this->request->data['id'];
            $pli_qty = trim($this->request->data['pli_qty']);
            $rr_collection = $this->request->data['rr_collection'];
            #check the actual date in form 
            if (isset($this->request->data['actual_date_update'])) {
                $actual_date_update = str_replace(array("\r", "\n", "\t"), '', date('Y-m-d', strtotime($this->request->data['actual_date_update'])));
            } else {
                return "1.Wrong:Date Format!";
                exit;
            }

            #check the actual date aproval in form
            if (isset($this->request->data['actual_date_update_1'])) {
                $actual_date_update_1 = str_replace(array("\r", "\n", "\t"), '', date('Y-m-d', strtotime($this->request->data['actual_date_update_1'])));
            } else {
                return "2.Wrong:Date Format!";
                exit;
            }
            #check qty in form
            if ($pli_qty <= 0) {
                return "3.Invalid Qty!";
                exit;
            }
            $app_conl = new AppController();
            $check = $app_conl->validateDate($actual_date_update);
            if (!$check) {
                return "4.Wrong:Date Format!";
                exit;
            }
            $check_1 = $app_conl->validateDate($actual_date_update_1);
            if (!$check_1) {
                return "5.Wrong:Date Format!";
                exit;
            }

            //check already exist
            if (!$this->Delivery->exists($id)) {
                //throw new NotFoundException(__('Invalid Delivery'));
                return "6.Invalid Request!";
                exit;
            }
            $message = "7.Error:There is an error while record updating!";

            if ($check && $id && $check_1):
                // $actual_date_update=$this->request->data['actual_date_update'];
                $this->Delivery->id = $id;
                $this->beforeRender();
                if ($id) {
                    $this->Delivery->saveField('actual_pli_date', $actual_date_update, false);
                    $this->Delivery->saveField('actual_date_of_pli_aproval', $actual_date_update_1, false);
                    $rr_collection = strtotime($actual_date_update_1) + $rr_collection * 86400;
                    $rr_collection = date('Y-m-d', $rr_collection);
                    $this->Delivery->saveField('planned_rr_collection_date', $rr_collection, false);

                    $this->Delivery->saveField('actual_date_of_installation', $actual_date_update, false);
                    $this->Delivery->saveField('actual_date_of_client_receiving', $actual_date_update_1, false);
                    $this->Delivery->saveField('modified_by', $UserID, false);
                    $this->Delivery->saveField('modified_date', date('Y-m-d h:m:i'), false);

                    if ($this->Delivery->saveField('pli_qty', $pli_qty, false)):
                        $message = "Record updated successfully.";
                    endif;
                } else {
                    $message = "8.Error:There is an error while record updating!";
                }
            endif;
            echo $message;

            // $this->set(compact('actual_date_update','message'));
        }
    }

    public function actual_pli_date_editing_all() {
        $this->layout = 'ajax';
        $this->request->accepts('application/json');
        $data = $this->request->input('json_decode', true);
        $user = $this->Session->read('UserAuth');
        $UserID = $user['User']['username'];
        $sql = '';
        if ($data) {
            foreach ($data as $value) {
                $id = $value['id'];
                $actual_date = $value['actual_date'];
                $actual_date1 = $value['actual_date_1'];
                $pli_qty = $value['pli_qty'];
                $pli_qty_already = $value['pli_qty_already'];
                $pli_qty+=$pli_qty_already;
                $rr_collection = $value['rr_collection'];
                if ($id && $actual_date && $actual_date1 && $pli_qty>0) {

                    $rr_collection = strtotime($actual_date1) + $rr_collection * 86400;
                    $rr_collection = date('Y-m-d', $rr_collection);

                    $sql.="UPDATE deliveries SET pli_qty='" . $pli_qty . "',"
                            . "actual_pli_date='" . $actual_date . "',"
                            . "actual_date_of_pli_aproval='" . $actual_date1 . "',"
                            . "planned_rr_collection_date='" . $rr_collection . "',"
                            . "actual_date_of_installation='" . $actual_date . "',"
                            . "actual_date_of_client_receiving='" . $actual_date1 . "',"
                            . "modified_by= '" . $UserID . "', "
                            . " modified_date= '" . date('Y-m-d H:m:i') . "'"
                            . " WHERE id =$id;";
                }
            }
            $this->beforeRender();
            if ($this->Delivery->query($sql)) {
                echo'1';
            } else {
                echo'2';
            }
        }
        $this->autoRender = FALSE;
    }

    public function delete() {
        $this->layout = 'ajax';
        $this->autoRender = false;
        #find the Delivery option
        $this->Delivery->id = $id = $this->request->data['id'];
        if (!$this->Delivery->exists()) {
            //throw new NotFoundException(__('Invalid production product'));
            echo "0";
            exit();
        } else {# valid id is found
            $this->Delivery->recursive = -1;
            $product = $this->Delivery->findById($id);

            $product_id = $product['Delivery']['product_id'];
            $lot_id = $product['Delivery']['lot_id'];
            $actual_delivery_date = $product['Delivery']['actual_delivery_date'];
            if ($actual_delivery_date == "0000-00-00") {
                $this->request->allowMethod('post', 'delete');
                if ($this->Delivery->delete()) {
                    echo "1";
                } else {
                    echo "0";
                }
            } else {
                $option1 = array(
                    'conditions' => array(
                        'Delivery.product_id' => $product_id,
                        'Delivery.lot_id' => $lot_id,
                        'Delivery.actual_delivery_date NOT LIKE' => "0000-00-00",
                        'Delivery.actual_pli_date NOT LIKE' => "0000-00-00"
                    )
                );
                $this->Delivery->recursive = -1;
                if (!$this->Delivery->find('first', $option1)):#check the product of that lot is in delivery        
                    $this->request->allowMethod('post', 'delete');
                    if ($this->Delivery->delete()) {
                        echo "1";
                    } else {
                        echo "0";
                    }
                else:
                    echo '0';
                endif;  #/check the product of that lot is in inspection 
            }
        }#/valid id is found
    }

}
