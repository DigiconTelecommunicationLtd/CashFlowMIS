<?php

App::uses('AppController', 'Controller');

/**
 * Collections Controller
 *
 * @property Collection $Collection
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CollectionsController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index($contract_id=null) {
        if ($this->request->is('post')||$contract_id) {
            /*
              if ($this->request->data['Collection']['date_from'] && $this->request->data['Collection']['date_to']) {
              $start_date = $this->request->data['Collection']['date_from'];
              $end_date = $this->request->data['Collection']['date_to'];
              $data['start_date']=$start_date;
              $data['end_date']=$end_date;
              $options['SUBSTRING(Collection.added_date,1,10) BETWEEN ? AND ?'] = array($start_date, $end_date);
              }    
              if ($this->request->data['Collection']['collection_type']) {
              $options['Collection.collection_type'] = $this->request->data['Collection']['collection_type'];
              }
             */
            if ($contract_id) {
              $options['Collection.contract_id'] = $contract_id;
              $data['contract_id']=$contract_id;
              }
              
            if ($this->request->data['Collection']['invoice_ref_no']) {
                $data['invoice_ref_no'] = $this->request->data['Collection']['invoice_ref_no'];
                $options['Collection.invoice_ref_no LIKE '] = $this->request->data['Collection']['invoice_ref_no'] . "%";
            }

            if ($this->request->data['Collection']['currency']) {
                $data['currency'] = $this->request->data['Collection']['currency'];
                $options['Collection.currency'] = $this->request->data['Collection']['currency'];
            }
            if ($this->request->data['Collection']['product_category_id']) {
                $data['product_category_id'] = $this->request->data['Collection']['product_category_id'];
                $options['Collection.product_category_id'] = $this->request->data['Collection']['product_category_id'];
            }
            if ($this->request->data['Collection']['client_id']) {
                $data['client_id'] = $this->request->data['Collection']['client_id'];
                $options['Collection.clientid'] = $this->request->data['Collection']['client_id'];
            }
            if ($this->request->data['Collection']['unit_id']) {
                $data['unit_id'] = $this->request->data['Collection']['unit_id'];
                $options['Collection.unitid'] = $this->request->data['Collection']['unit_id'];
            }
            if ($this->request->data['Collection']['contract_id'] || $this->request->data['Collection']['lc_ref']) {
                $data['contract_id'] = ($this->request->data['Collection']['contract_id']) ? $this->request->data['Collection']['contract_id'] : '';
                $data['lc_ref'] = ($this->request->data['Collection']['lc_ref']) ? $this->request->data['Collection']['lc_ref'] : '';
                $options['Collection.contract_id'] = ($this->request->data['Collection']['contract_id']) ? $this->request->data['Collection']['contract_id'] : $this->request->data['Collection']['lc_ref'];
            }
            if ($this->request->data['Collection']['collection_type']) {
                $data['collection_type'] = $this->request->data['Collection']['collection_type'];
                $options['Collection.collection_type'] = $this->request->data['Collection']['collection_type'];
            }
            
            $this->Collection->recursive = 0;
            $options = array('conditions' => $options, 'order' => array('Collection.id' => 'DESC'));
            $collections = $this->Collection->find('all', $options);
            //echo '<pre>';print_r($collections);exit;
        }
        
        #product category list
        $this->loadModel('ProductCategory');
        $product_category = $this->ProductCategory->find('list');
        #contract list box
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);
        #lc refe
        $options = array('conditions' => array('Contract.lc_ref !=' => ''), 'fields' => array('Contract.id', 'Contract.lc_ref'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $lc_refs = $this->Contract->find('list', $options);
        #Client list box
        $this->loadModel('Client');
        $this->Client->recursive = -1;
        $clients = $this->Client->find('list');
        #Unit list box
        $this->loadModel('Unit');
        $this->Unit->recursive = -1;
        $units = $this->Unit->find('list');

        $currencies = array('USD' => 'USD', 'BDT' => 'BDT');
        $collection_types = array(
            'Advance' => 'Advance',
            'Progressive' => 'Progressive',
            'Retention(1st)' => 'Retention(1st)',
            'Retention(2nd)' => 'Retention(2nd)'
        );
        $this->set(compact('lc_refs', 'collection_types', 'contracts', 'clients', 'units', 'currencies', 'collections', 'start_date', 'end_date', 'product_category', 'data'));
    }

    public function advance_payment_add() {
        if ($this->request->is('post')) {
            $contract_id = trim($this->request->data['Collection']['contract_id']);
            $currency = trim($this->request->data['Collection']['currency']);
            #check contract_id and currency if not set redirect to previous page
            if (!$contract_id || !$currency) {
                $this->Session->setFlash(__('PO. NO and Currency is required for Advance Payment. Please try Again.'));
                return $this->redirect(array('controller' => 'collections', 'action' => 'advance_collection_form/ '));
            }
            #check already taken advance payment
            $option = array(
                'conditions' => array(
                    'Collection.contract_id' => $contract_id,
                    'Collection.collection_type' => 'Advance',
                    'Collection.currency' => $currency
                )
            );
            $this->Collection->recursive = -1;
            if ($this->Collection->find('first', $option)) {
                $this->Session->setFlash(__('Already Adv. invoice exist with ' . $currency . ' currency. Please, try again.'));
                #return $this->redirect($this->referer());
            }
            #find the category
            $contract_product_option = array(
                'conditions' => array(
                    'ContractProduct.currency' => $currency,
                    'ContractProduct.contract_id' => $contract_id
                ),
                'fields' => array(
                    'ProductCategory.id',
                    'ProductCategory.name',
                    'SUM(ContractProduct.quantity*ContractProduct.unit_price) as amount'
                ),
                'order' => array(
                    'ProductCategory.name' => "ASC"
                ),
                'group' => array('ContractProduct.currency', 'ContractProduct.product_category_id')
            );
            $this->loadModel('ContractProduct');
            $product_category = $this->ContractProduct->find('all', $contract_product_option);
            if (!$product_category) {
                $this->Session->setFlash(__('There is no PO product or Product Category. Please, try again.'));
                return $this->redirect($this->referer());
            }
            #echo '<pre>';print_r($product_category);exit;
            #find the contract information with request contract id    
            $this->loadModel('Contract');
            $option = array('conditions' => array('Contract.id' => $contract_id));
            $this->Contract->recursive = -1;
            $result = $this->Contract->find('first', $option);
            #find the collection number
            $option = array(
                'conditions' => array(
                    'Collection.contract_id' => $contract_id
                ),
                'fields' => array(
                    'COUNT(*) as no_collection'
                ),
                'group' => array(
                    'Collection.sessionid'
                )
            );
            $collection = $this->Collection->find('first', $option);
            $no_collection = ($collection[0]['no_collection']) ? $collection[0]['no_collection'] + 1 : 1;
            $no_collection = str_pad($no_collection, 2, '0', STR_PAD_LEFT);

            #generate invoice number
            $invoice_ref = str_pad($result['Contract']['id'], 6, '0', STR_PAD_LEFT) . '/' . $no_collection . '/';
            #invoice value
            $contract_value = ($currency == "BDT") ? $result['Contract']['contract_value_bdt'] : $result['Contract']['contract_value_usd'];
            $contract_value = ($contract_value > 0) ? $contract_value : 0.00;
            #invoice_value
            $invoice_value = round(($contract_value * $result['Contract']['billing_percent_adv']) / 100);
            $invoice_value = ($invoice_value > 0) ? $invoice_value : 0.00;
            #calculate balance
            $balance = $contract_value - $invoice_value;
            $this->set(compact('currency', 'result', 'contract_id', 'invoice_ref', 'contract_value', 'invoice_value', 'balance', 'product_category'));
        } else {
            return $this->redirect(array('controller' => 'collections', 'action' => 'advance_collection_form/ '));
        }
    }

    public function retention_payment_add() {
        if ($this->request->is('post')) {
            $contract_id = $this->request->data['Collection']['contract_id'];
            $currency = $this->request->data['Collection']['currency'];
            $collection_type = $this->request->data['Collection']['collection_type'];
            if (!$contract_id || !$currency || !$collection_type) {
                $this->Session->setFlash(__('There is one option is missing. Please, try again.'));
                return $this->redirect(array('action' => 'retention_collection_form/ '));
            }
            #check already taken advance payment
            $option = array(
                'conditions' => array(
                    'Collection.contract_id' => $contract_id,
                    'Collection.collection_type' => $collection_type,
                    'Collection.currency' => $currency
                )
            );
            $this->Collection->recursive = -1;
            if ($this->Collection->find('first', $option)) {
                $this->Session->setFlash(__('Already ' . $collection_type . '. invoice exist with ' . $currency . ' currency. Please, try again.'));
                //return $this->redirect($this->referer());
            }
            #find the category
            $contract_product_option = array(
                'conditions' => array(
                    'ContractProduct.currency' => $currency,
                    'ContractProduct.contract_id' => $contract_id
                ),
                'fields' => array(
                    'ProductCategory.id',
                    'ProductCategory.name',
                    'SUM(ContractProduct.quantity*ContractProduct.unit_price) as amount'
                ),
                'order' => array(
                    'ProductCategory.name' => "ASC"
                ),
                'group' => array('ContractProduct.currency', 'ContractProduct.product_category_id')
            );
            $this->loadModel('ContractProduct');
            $product_category = $this->ContractProduct->find('all', $contract_product_option);
            #find the contract value
            $this->loadModel('Contract');
            $option = array('conditions' => array('Contract.id' => $contract_id));
            $this->Contract->recursive = -1;
            $result = $this->Contract->find('first', $option);
            #find the collection number
            $option = array(
                'conditions' => array(
                    'Collection.contract_id' => $contract_id
                ),
                'fields' => array(
                    'COUNT(*) as no_collection'
                )
            );
            $collection = $this->Collection->find('first', $option);
            $no_collection = ($collection[0]['no_collection']) ? $collection[0]['no_collection'] + 1 : 1;
            $no_collection = str_pad($no_collection, 2, '0', STR_PAD_LEFT);

            #generate invoice number
            $invoice_ref = str_pad($result['Contract']['id'], 6, '0', STR_PAD_LEFT) . '/' . $no_collection . '/';
            #invoice value
            $contract_value = ($currency == "BDT") ? $result['Contract']['contract_value_bdt'] : $result['Contract']['contract_value_usd'];
            $contract_value = ($contract_value > 0) ? $contract_value : 0.00;
            #find the previous payment
            $previous_payment = $this->collectionByContract($contract_id, $currency);
            #invoice_value
            if ($collection_type == "Retention(1st)") {
                $billing_percent = $result['Contract']['billing_percent_first_retention'];
            } else {
                $billing_percent = $result['Contract']['billing_percent_second_retention'];
            }
            $balance_in_contract_value = $contract_value - $previous_payment;

            $invoice_value = round(($contract_value * $billing_percent) / 100);

            $invoice_value = ($invoice_value > 0) ? $invoice_value : 0.00;
            #calculate balance
            $balance = $contract_value - ($invoice_value + $previous_payment);
            $this->set(compact('billing_percent', 'product_category', 'balance_in_contract_value', 'invoice_value', 'billing_percent', 'balance', 'contract_value', 'invoice_ref', 'contract_id', 'currency', 'result', 'previous_payment', 'collection_type'));
        } else {
            $this->Session->setFlash(__('There is one option is missing. Please, try again.'));
            return $this->redirect(array('action' => 'retention_collection_form/ '));
        }
    }

    public function SaveCollection() {
        if ($this->request->is('post')) {
           //echo '<pre>';print_r($this->request->data);exit;
            $user = $this->Session->read('UserAuth');
            $UserID = $this->request->data['Collection']['added_by'] = $user['User']['username'];
            //check collection type
            $collection_type = $this->request->data['Collection']['collection_type'];
            $contract_id = $this->request->data['Collection']['contract_id'];
            $product_category = $this->request->data['Collection']['product_category_id'];
            $category_qty = $this->request->data['Collection']['quantity'];
            $this->request->data['Collection']['actual_submission_date'] = date('Y-m-d', strtotime($this->request->data['Collection']['actual_submission_date']));

            if (!$collection_type || !$contract_id || !$product_category) {
                $this->Session->setFlash(__('1.There is an error while executing your request!. Please try again.'));
                return $this->redirect($this->referer());
            }
            #find the client and unit id
            $opton = array(
                'conditions' => array(
                    'Contract.id' => $contract_id
                ),
                'fields' => array(
                    'Contract.client_id', 'Contract.unit_id'
                )
            );
            $this->loadModel('Contract');
            $this->Contract->recursive = -1;
            $client_unit = $this->Contract->find('first', $opton);
            $this->request->data['Collection']['clientid'] = ($client_unit['Contract']['client_id']) ? $client_unit['Contract']['client_id'] : "NULL";
            $this->request->data['Collection']['unitid'] = ($client_unit['Contract']['unit_id']) ? $client_unit['Contract']['unit_id'] : "NULL";

            #find the collection number
            $option = array(
                'conditions' => array(
                    'Collection.contract_id' => $contract_id
                ),
                'fields' => array(
                    'COUNT(distinct(sessionid)) as no_collection'
                ),
            );
            $collection = $this->Collection->find('first', $option);
            $no_collection = ($collection[0]['no_collection']) ? $collection[0]['no_collection'] + 1 : 1;
            #echo '<pre>';print_r($no_collection);exit;
            $no_collection = str_pad($no_collection, 2, '0', STR_PAD_LEFT);
            $sessionid = $this->request->data['Collection']['sessionid'] = time() . rand(1, 100000);
            $this->request->data['Collection']['invoice_ref_no'] = str_pad($contract_id, 6, '0', STR_PAD_LEFT) . '/' . $no_collection . '/' . $this->request->data['Collection']['invoice_ref'];
            #trackid 
            foreach ($product_category as $key => $category) {
                if (!$category || $category <= 0 || !$key) {
                    continue;
                }

                #generate invoice number         
                $this->request->data['Collection']['product_category_id'] = $key;
                $this->request->data['Collection']['invoice_amount'] = $category;

                #category wise quantity for progressive and retention payment
                if ($category_qty[$key] > 0):
                    $this->request->data['Collection']['quantity'] = $category_qty[$key];
                else:
                    $this->request->data['Collection']['quantity'] = 0;
                endif;

                $this->Collection->create();
                $this->Collection->save($this->request->data);
            }

            if ($collection_type == "Progressive") {

                $this->loadModel('ProgressivePayment');
                $this->ProgressivePayment->updateAll(array('ProgressivePayment.sessionid' => $sessionid, 'ProgressivePayment.status' => 1), array('ProgressivePayment.status' => 0, 'ProgressivePayment.contract_id' => $contract_id, 'ProgressivePayment.added_by' => $UserID));
            }
            //end of check collection type
            $this->Session->setFlash(__('The collection has been saved.'));
            return $this->redirect(array('action' => 'index/' . $contract_id));
        }
        return $this->redirect(array('action' => '/ '));
        /*
          $contracts = $this->Collection->Contract->find('list');
          //$progressivePaymentDetails = $this->Collection->ProgressivePaymentDetail->find('list');
          $currencies = array('USD' => 'USD', 'BDT' => 'BDT');
          $this->set(compact('contracts', 'currencies'));
         * 
         */
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Collection->exists($id)) {
            throw new NotFoundException(__('Invalid collection'));
        }
        if (!empty($this->request->data)) {
            if ($this->Collection->save($this->request->data)) {
                $this->Session->setFlash(__('The collection has been saved.'));
                return $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__('The collection could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Collection.' . $this->Collection->primaryKey => $id));
            $this->request->data = $this->Collection->find('first', $options);
        }

        $this->set(compact('contracts'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Collection->id = $id;
        if (!$this->Collection->exists()) {
            throw new NotFoundException(__('Invalid collection'));
        }
        $this->request->allowMethod('post', 'delete');


        if ($id) {
            $condition = array(
                'conditions' => array(
                    'Collection.id' => $id
                ),
                'fields' => array('Collection.sessionid', 'Collection.contract_id', 'Collection.added_by')
            );

            $contract = $this->Collection->find('first', $condition);                          
            if ($contract) {
                $sessionid = $contract['Collection']['sessionid'];
                $contract_id = $contract['Collection']['contract_id'];
                if ($sessionid) {
                    /*
                    $sql ="DELETE FROM progressive_payments WHERE contract_id=$contract_id and sessionid='" . $sessionid . "';";
                    $sql.="DELETE FROM collections WHERE id=$id and sessionid='" . $sessionid . "';";
                    $sql.="DELETE FROM collection_details WHERE collection_id=$id;";
                    $this->Collection->query($sql);
                     */
                    
                    //start database transaction
                    
                        $datasource = $this->Collection->getDataSource();
                        try {
                            $datasource->begin();
                            
                            #collection delete
                            if(!($this->Collection->deleteAll(array('Collection.id' => $id,'Collection.sessionid'=>$sessionid), false))||!$contract_id||!$sessionid)
                            {                           
                                throw new Exception();
                            }
                            
                            #progessive payment delete
                            $this->loadModel('ProgressivePayment');
                            if(!($this->ProgressivePayment->deleteAll(array('ProgressivePayment.contract_id' => $contract_id,'ProgressivePayment.sessionid'=>$sessionid), false)))
                            {                                 
                                throw new Exception();
                            }
                            
                            #collection details
                            $this->loadModel('CollectionDetail');
                            if(!($this->CollectionDetail->deleteAll(array('CollectionDetail.collection_id' => $id), false)))
                            {                                 
                                throw new Exception();
                            }
                            $datasource->commit();                            
                            //$this->Session->setFlash(__('Payment information has been saved.'));	            
                           
                        } catch(Exception $e) {
                            $datasource->rollback();
                            $this->Session->setFlash(__('The collection could not be deleted. Please, try again'));
                            return $this->redirect(array('action' => 'index'));
                        }
                      //end database transction 
                      
                }
            }


            $this->Session->setFlash(__('The collection has been deleted.'));
        } else {
            $this->Session->setFlash(__('The collection could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function advance_collection_form() {
        $order = array(
            'order' => array(
                'Contract.id' => 'DESC'
        ));
        $contracts = $this->Collection->Contract->find('list', $order);

        $currencies = array('USD' => 'USD', 'BDT' => 'BDT');

        $this->set(compact('contracts', 'currencies'));
    }

    public function retention_collection_form() {
        $order = array(
            'order' => array(
                'Contract.id' => 'DESC'
        ));
        $contracts = $this->Collection->Contract->find('list', $order);

        $currencies = array('USD' => 'USD', 'BDT' => 'BDT');
        $collection_types = array('Retention(1st)' => 'Retention(1st)', 'Retention(2nd)' => 'Retention(2nd)');
        $this->set(compact('contracts', 'currencies', 'collection_types'));
    }

    public function progressive_payment_form() {
        if ($this->request->is('post')) {
            $contract_id = $this->request->data['Collection']['contract_id'];
            $currency = $this->request->data['Collection']['currency'];
            $lot_id = $this->request->data['Collection']['lot_id'];
            if (!$contract_id || !$currency || !$lot_id) {
                $this->Session->setFlash(__('There is no products find with these options. Please, try again.'));
                return $this->redirect($this->referer());
                exit;
            }
            #find the lots by contract id
            $this->loadModel('Lot');
            $option1 = array(
                'conditions' => array(
                    'Lot.contract_id' => $contract_id
                ),
                'fields' => array(
                    'lot_no', 'lot_no'
                )
            );
            #/find the lots by contract id  
            $lots = $this->Lot->find('list', $option1);
            $product_category_id = null;
            if ($this->request->data['Collection']['product_category_id']) {
                $product_category_id = $this->request->data['Collection']['product_category_id'];
            }

            #find the conract products with contract id and currency
            $this->loadModel('ProductCategory');
            $all_product_categories = $this->ProductCategory->find('list', array('fields' => array('id', 'id')));
            $this->loadModel('ContractProduct');
            $option = array('conditions' => array(
                    'ContractProduct.contract_id' => $contract_id,
                    'ContractProduct.currency' => $currency,
                    'ContractProduct.product_category_id' => ($product_category_id) ? $product_category_id : $all_product_categories
                ),
                'fields' => array(
                    'ContractProduct.product_id',
                    'ContractProduct.unit_price'
            ));
            $con_products_result = $this->ContractProduct->find('all', $option);
            $con_unit_price = array();
            $con_products = array();
            #separate the contract product id and unit price
            foreach ($con_products_result as $value) {
                $con_unit_price[$value['ContractProduct']['product_id']] = $value['ContractProduct']['unit_price'];
                $con_products[$value['ContractProduct']['product_id']] = $value['ContractProduct']['product_id'];
            }
            #/find the conract products with contract id and currency
            #check the existing of contract products
            if (!$con_products) {
                $this->Session->setFlash(__('There is no products find with these options. Please, try again.'));
                return $this->redirect($this->referer());
                exit;
            }
            #find the delivery product with contract id,lot number and product id 
            $option = array('conditions' => array(
                    'Delivery.contract_id' => $contract_id,
                    'Delivery.lot_id' => $lot_id,
                    'Delivery.product_category_id' => ($product_category_id) ? $product_category_id : $all_product_categories,
                    'Delivery.actual_delivery_date NOT LIKE' => '0000-00-00',
                    'Delivery.actual_pli_date NOT LIKE' => '0000-00-00',
                    'Delivery.actual_date_of_pli_aproval NOT LIKE' => '0000-00-00',
                    'Delivery.product_id' => $con_products
                ),
                'fields' => array(
                    'SUM(Delivery.quantity) as quantity',
                    'SUM(Delivery.pli_qty) as pli_qty',
                    'Delivery.uom',
                    'Delivery.unit_weight',
                    'Delivery.unit_weight_uom',
                    'Delivery.product_category_id',
                    'Delivery.product_id',
                    'MAX(Delivery.planned_delivery_date) as planned_delivery_date',
                    'MAX(Delivery.actual_delivery_date) as actual_delivery_date',
                    'MAX(Delivery.planned_pli_date) as planned_pli_date',
                    'MAX(Delivery.actual_pli_date) as actual_pli_date',
                    'MAX(Delivery.planned_date_of_pli_aproval) as planned_date_of_pli_aproval',
                    'MAX(Delivery.actual_date_of_pli_aproval) as actual_date_of_pli_aproval',
                    'MAX(Delivery.planned_date_of_installation) as planned_date_of_installation',
                    'MAX(Delivery.actual_date_of_installation) as actual_date_of_installation',
                    'MAX(Delivery.planned_date_of_client_receiving) as planned_date_of_client_receiving',
                    'MAX(Delivery.actual_date_of_client_receiving) as actual_date_of_client_receiving',
                    'MAX(Delivery.planned_rr_collection_date) as planned_rr_collection_date',
                    'Product.name',
                    'ProductCategory.name'
                ),
                'group' => array(
                    'Delivery.product_id'
                ),
                'order' => array('Delivery.product_id' => 'ASC')
            );
            $this->loadModel('Delivery');
            $this->Delivery->unbindModel(array('belongsTo' => array('Contract')));
            $deliveries = $this->Delivery->find('all', $option);
            #/find the delivery product with contract id,lot number and product id 
            #find the progressive payment's product with contract id,lot number and product id 
            $option = array('conditions' => array(
                    'ProgressivePayment.contract_id' => $contract_id,
                    'ProgressivePayment.lot_id' => $lot_id,
                    'ProgressivePayment.status' => 1,
                    'ProgressivePayment.sessionid !=' => 0,
                    'ProgressivePayment.product_id' => $con_products
                ),
                'fields' => array(
                    'ProgressivePayment.product_id',
                    'SUM(ProgressivePayment.quantity) as quantity'
                ),
                'group' => array(
                    'ProgressivePayment.product_id'
                )
            );
            $this->loadModel('ProgressivePayment');
            $alr_pros = $this->ProgressivePayment->find('all', $option);
            $alr_pro_products = array();
            foreach ($alr_pros as $key => $value) {
                $alr_pro_products[$value['ProgressivePayment']['product_id']] = $value[0]['quantity'];
            }
            //echo '<pre>';print_r($alr_pro_products);exit;    
        }
        $order = array(
            'order' => array(
                'Contract.id' => "DESC"
            )
        );
        $contracts = $this->Collection->Contract->find('list', $order);
        $currencies = array('USD' => 'USD', 'BDT' => 'BDT');
        #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');

        $this->set(compact('contracts', 'currencies', 'deliveries', 'alr_pro_products', 'con_products', 'con_unit_price', 'currency', 'contract_id', 'lot_id', 'lots', 'product_categories'));
    }

    public function add_progressive_payment() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            #echo '<pre>';print_r($this->request->data);exit;   
            $contract_id = $this->request->data['contract_id'];
            $currency = $this->request->data['currency'];
            $lot_id = $this->request->data['lot_id'];
            if (!$contract_id || !$currency || !$lot_id) {
                $this->Session->setFlash(__('Required Information is missing. Please try again.'));
                return $this->redirect(array('controller' => 'collections', 'action' => 'progressive_payment_form/ '));
            }
            #find the client and unit id
            $opton = array(
                'conditions' => array(
                    'Contract.id' => $contract_id
                ),
                'fields' => array(
                    'Contract.client_id', 'Contract.unit_id'
                )
            );
            $this->loadModel('Contract');
            $this->Contract->recursive = -1;
            $client_unit = $this->Contract->find('first', $opton);

            $this->loadModel('ProgressivePayment');
            $clientid = ($client_unit['Contract']['client_id']) ? $client_unit['Contract']['client_id'] : "NULL";
            $unitid = ($client_unit['Contract']['unit_id']) ? $client_unit['Contract']['unit_id'] : "NULL";

            $user = $this->Session->read('UserAuth');
            $UserID = $user['User']['username'];

            $this->loadModel('ProgressivePayment');
            $this->ProgressivePayment->recursive = -1;

            $this->loadModel('Delivery');
            $this->Delivery->recursive = -1;

            foreach ($this->request->data['quantity'] as $key => $value) {

                if (!$value || $value <= 0 || !$key || !$lot_id || !$contract_id || !$currency || !$this->request->data['product_category_id'][$key]) {
                    continue;
                }
                $option = array('conditions' => array(
                        'ProgressivePayment.contract_id' => $contract_id,
                        'ProgressivePayment.lot_id' => $lot_id,
                        'ProgressivePayment.product_id' => $key,
                        'ProgressivePayment.status' => 1,
                        'ProgressivePayment.sessionid !=' => 0
                    ),
                    'fields' => array(
                        'SUM(ProgressivePayment.quantity) as quantity'
                    ),
                    'group' => array(
                        'ProgressivePayment.product_id'
                    )
                );

                $prv_prog_qty = $this->ProgressivePayment->find('first', $option);
                $prv_prog_qty = $prv_prog_qty[0]['quantity'];
                $total_prog_qty = $prv_prog_qty + $value;

                #find the delivery product with contract id,lot number and product id 
                $option = array('conditions' => array(
                        'Delivery.contract_id' => $contract_id,
                        'Delivery.lot_id' => $lot_id,
                        'Delivery.actual_delivery_date NOT LIKE' => '0000-00-00',
                        'Delivery.actual_pli_date NOT LIKE' => '0000-00-00',
                        'Delivery.actual_date_of_pli_aproval NOT LIKE' => '0000-00-00',
                        'Delivery.product_id' => $key
                    ),
                    'fields' => array(
                        'SUM(Delivery.quantity) as quantity',
                        'SUM(Delivery.pli_qty) as pli_qty',
                        'Delivery.actual_delivery_date'
                    ),
                    'group' => array(
                        'Delivery.product_id'
                    )
                );


                $deliveries = $this->Delivery->find('first', $option);
                $delivery_qty = $deliveries[0]['pli_qty'];
                $trackid = $deliveries['Delivery']['actual_delivery_date'];

                if ($total_prog_qty > $delivery_qty) {
                    $this->Session->setFlash(__('Product of ID ' . $key . ' ,Actual PLI Qty is ' . $prv_prog_qty . ' and Requested Prog. qty is ' . $value . ' So Actual PLI qty is less than Requestd qty . Please, try again.'));
                    return $this->redirect($this->referer());
                }

                $saveData[] = array(
                    'ProgressivePayment' => array(
                        'contract_id' => $contract_id,
                        'lot_id' => $lot_id,
                        'product_category_id' => $this->request->data['product_category_id'][$key],
                        'product_id' => $key,
                        'quantity' => trim($value),
                        'unit_price' => $this->request->data['unit_price'][$key],
                        'currency' => $currency,
                        'uom' => $this->request->data['uom'][$key],
                        'unit_weight' => $this->request->data['unit_weight'][$key],
                        'unit_weight_uom' => $this->request->data['unit_weight_uom'][$key],
                        'added_by' => $UserID,
                        'clientid' => $clientid,
                        'unitid' => $unitid,
                        'trackid' => $trackid
                    )
                );
            }
            #echo '<pre>';print_r($saveData);exit;
            /*             * *************save Delivery data*************** */
            $count_product = count($saveData);
            if ($saveData > 0) {
                $this->ProgressivePayment->create();
                if ($this->ProgressivePayment->saveMany($saveData)) {
                    $this->Session->setFlash(__($count_product . ' products has been saved successfully.'));
                    return $this->redirect(array('controller' => 'progressive_payments', 'action' => 'add', $contract_id, $currency, str_replace('/', '|', $lot_id)));
                } else {
                    $this->Session->setFlash(__('Product for progressive payment could not saved successfully.Please, try again.'));
                    return $this->redirect($this->referer());
                }
            } else {
                $this->Session->setFlash(__('There is no product for prgressive payment.Please, try again.'));
                return $this->redirect($this->referer());
            }
            /*             * *************end of save Delivery data*************** */
        } else {
            $this->Session->setFlash(__('This page has has redirected. Please try again.'));
            return $this->redirect(array('controller' => 'collections', 'action' => 'progressive_payment_form/ '));
        }
    }

    protected function collectionByContract($contract_id = null, $currency = null) {
        $option = array('conditions' => array('Collection.contract_id' => $contract_id, 'Collection.currency' => $currency), 'fields' => array('SUM(Collection.amount_received+Collection.ait+Collection.vat+Collection.ld+Collection.other_deduction) as collection'));
        $collection = $this->Collection->find('first', $option);
        #echo '<pre>';print_r($currency);exit;        
        return ($collection[0]['collection']) ? $collection[0]['collection'] : 0.00;
    }

    public function cheque_date() {
        $this->layout = 'ajax';
        if ($this->request->is(array('post', 'put'))) {
            $user = $this->Session->read('UserAuth');
            $this->request->data['Collection']['modified_by'] = $user['User']['username'];
            $this->request->data['Collection']['modified_date'] = date('Y-m-d h:i:s');
            $id = $this->request->data['id'];
            $cheque_amount = (trim($this->request->data['cheque_amount'])) ? trim($this->request->data['cheque_amount']) : 0.00;
            $ait = (trim($this->request->data['ait'])) ? trim($this->request->data['ait']) : 0.00;
            $vat = (trim($this->request->data['vat'])) ? trim($this->request->data['vat']) : 0.00;
            $ld = (trim($this->request->data['ld'])) ? trim($this->request->data['ld']) : 0.00;
            $other_deduction = (trim($this->request->data['other_deduction'])) ? trim($this->request->data['other_deduction']) : 0.00;
            $ajust_adv_amount = (trim($this->request->data['ajust_adv_amount'])) ? trim($this->request->data['ajust_adv_amount']) : 0.00;


            if (!$this->Collection->exists($id)) {
                throw new NotFoundException(__('1.Invalid Request'));
                $this->Session->setFlash(__('1.There is a error while processing you requiest . Please, try again.'));
                echo '1.There is a error while processing you requiest . Please, try again.';
                exit;
            }
            $this->Collection->recursive = -1;
            $option = array('conditions' => array(
                    'Collection.id' => $id
                ),
                'fields' => array(
                    'Collection.contract_id', 'sessionid')
            );
            $collection = $this->Collection->find('first', $option);
            $contract_id = $collection['Collection']['contract_id'];
            $sessionid = $collection['Collection']['sessionid'];

            $actual_payment_certificate_or_cheque_collection_date = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['actual_payment_certificate_or_cheque_collection_date']));
            $forecasted_payment_collection_date = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['forecasted_payment_collection_date']));
            $cheque_or_payment_certification_date = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['cheque_or_payment_certification_date']));


            if ($id) {
                $sql = "UPDATE collections SET actual_payment_certificate_or_cheque_collection_date ='" . $actual_payment_certificate_or_cheque_collection_date . "',forecasted_payment_collection_date='" . $forecasted_payment_collection_date . "',cheque_or_payment_certification_date='" . $cheque_or_payment_certification_date . "' WHERE sessionid=$sessionid and contract_id=$contract_id";
                $this->Collection->query($sql);
                $sql = "UPDATE collections SET cheque_amount =$cheque_amount,ait=$ait,vat=$vat,ld=$ld,other_deduction=$other_deduction,ajust_adv_amount=$ajust_adv_amount WHERE id=$id";
                $this->Collection->query($sql);
                /*
                  $this->Collection->id = $id;
                  $app_conl=new AppController();

                  $check=$app_conl->validateDate($actual_payment_certificate_or_cheque_collection_date);
                  if($check){
                  $this->Collection->saveField('actual_payment_certificate_or_cheque_collection_date', $actual_payment_certificate_or_cheque_collection_date, FALSE);
                  }

                  $check=$app_conl->validateDate($forecasted_payment_collection_date);
                  if($check){
                  $this->Collection->saveField('forecasted_payment_collection_date', $forecasted_payment_collection_date, FALSE);
                  }

                  $check=$app_conl->validateDate($cheque_or_payment_certification_date);
                  if($check){
                  $this->Collection->saveField('cheque_or_payment_certification_date', $cheque_or_payment_certification_date, FALSE);
                  } */
                $this->Session->setFlash(__('Request Information Have been saved.'));
                echo 'Request Information Have been saved.';
            } else {
                $this->Session->setFlash(__('There is a error while processing you requiest . Please, try again.'));
                echo '2.There is a error while processing you requiest . Please, try again.';
            }
        }
    }

    public function bank_credit_date() {
        $this->layout = 'ajax';
        if ($this->request->is(array('post', 'put'))) {

            $user = $this->Session->read('UserAuth');
            $this->request->data['Collection']['modified_by'] = $user['User']['username'];
            $this->request->data['Collection']['modified_date'] = date('Y-m-d h:i:s');
            $id = $this->request->data['id'];

            if (!$this->Collection->exists($id)) {
                throw new NotFoundException(__('1.Invalid Request'));
                echo '2.Invalid Request. Please, try again.';
                exit;
            }
            $payment_credited_to_bank_date = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['payment_credited_to_bank_date']));
            $amount_received = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['amount_received']));

            $ajust_adv_amount = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['ajust_adv_amount']));
            $ait = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['ait']));
            $vat = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['vat']));
            $ld = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['ld']));
            $other_deduction = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['other_deduction']));



            $this->Collection->id = $id;

            #$app_conl=new AppController();
            #$check=$app_conl->validateDate($payment_credited_to_bank_date);
            if ($id):
                if ($this->Collection->saveField('payment_credited_to_bank_date', $payment_credited_to_bank_date, FALSE)):
                    $this->Collection->saveField('amount_received', $amount_received, FALSE);

                    $this->Collection->saveField('ajust_adv_amount', $ajust_adv_amount, FALSE);
                    $this->Collection->saveField('ait', $ait, FALSE);
                    $this->Collection->saveField('vat', $vat, FALSE);
                    $this->Collection->saveField('ld', $ld, FALSE);
                    $this->Collection->saveField('other_deduction', $other_deduction, FALSE);



                    $this->Session->setFlash(__('Request Information Have been saved.'));
                    echo 'Request Information Have been saved.';
                else:
                    $this->Session->setFlash(__('4.There is a error while processing you requiest . Please, try again.'));
                    echo'4.There is a error while processing you requiest . Please, try again.';
                endif;
            else:
                $this->Session->setFlash(__('3.There is a error while processing you requiest . Please, try again.'));
                echo'5.There is a error while processing you requiest . Please, try again.';
            endif;
        }
    }

}
