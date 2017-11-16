<?php

App::uses('AppController', 'Controller');

/**
 * Report Controller
 *
 * @property Report $Report
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ReportsController extends AppController {
public $components = array('ExportXls');
    public function collection_report_details() {
        $options = array();
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-t');
        $action = "collection_report_details/ ";
        $controller = "reports";
        $results = array(); //blank result
        $reports = array(
            'Advance' => 'Advance',
            'Progressive' => 'Progressive',
            'Retention(1st)' => 'Retention(1st)',
            'Retention(2nd)' => 'Retention(2nd)'
        );
        $dates = array(
            'planned_submission_date' => 'Planned Invoice Submission Date',
            'actual_submission_date' => 'Actual Invoice Submission Date',
            'planned_payment_certificate_or_cheque_collection_date' => 'Planned Payment Certificate/Cheque Collection Date',
            'planned_payment_collection_date' => 'Planned Payment Collection Date',
            'forecasted_payment_collection_date' => 'Forecasted Payment Collection Date',
            'cheque_or_payment_certification_date' => 'Cheque/Payment Certificate Date',
            'actual_payment_certificate_or_cheque_collection_date' => 'Actual Payment Certificate/Cheque Collection Date',
            'payment_credited_to_bank_date' => 'Payment (Credited To Bank) Date'
        );
        if ($this->request->is('post')) {
            if ($this->request->data['Report']['date_from'] || $this->request->data['Report']['date_to'] || $this->request->data['Report']['date']) {
                if ($this->request->data['Report']['date_from'] && $this->request->data['Report']['date_to'] && $this->request->data['Report']['date']) {
                    $options[] = "Collection." . $this->request->data['Report']['date'] . ' BETWEEN ' . "'" . $this->request->data['Report']['date_from'] . "'" . ' AND ' . "'" . $this->request->data['Report']['date_to'] . "'";
                } else {
                    $this->Session->setFlash(__('Date From,Date To and Date Type is Required!,Please Try Again'));
                    $this->redirect($this->referer());
                }
            }
            if ($this->request->data['Report']['report']) {
                $options[] = "Collection.Collection_type='" . $this->request->data['Report']['report'] . "'";
            }
            if ($this->request->data['Report']['contract_id']) {
                $options[] = "Collection.contract_id=" . $this->request->data['Report']['contract_id'];
            }
            if ($this->request->data['Report']['currency']) {
                $options[] = "Collection.currency='" . $this->request->data['Report']['currency'] . "'";
            }
            if ($this->request->data['Report']['unit_id']) {
                $options[] = "contract.unit_id=" . $this->request->data['Report']['unit_id'];
            }
            if ($this->request->data['Report']['client_id']) {
                $options[] = "contract.client_id=" . $this->request->data['Report']['client_id'];
            }
            if ($this->request->data['Report']['client_id']) {
                $options[] = "contract.client_id=" . $this->request->data['Report']['client_id'];
            }
            if ($this->request->data['Report']['product_category_id']) {
                $options[] = "Collection.product_category_id=" . $this->request->data['Report']['product_category_id'];
            }

            // $sql_query="SELECT (select name from clients where clients.id=c.client_id)as client,(select name from units where units.id=c.unit_id) as unit,(select contract_no from contracts c where c.id=co.contract_id) contract_no,co.Collection_type Collection_type  from contracts c,collections as co where co.contract_id=c.id and co.contract_id=2 and c.unit_id ";
            // echo $sql_query="SELECT client.name as client_name,unit.name as unit_name,contract.contract_no as contract_no,Collection.Collection_type Collection_type FROM contracts as contract, clients as client,units as unit,collections as Collection where Collection.contract_id=contract.id ".  implode(' AND ', $options)."";

            if (count($options) > 0) {
                $sql_query = "SELECT (select name from clients where clients.id=contract.client_id)as client_name,(select name from product_categories where product_categories.id=Collection.product_category_id) as product_category,(select name from units where units.id=contract.unit_id) as unit_name,(select contract_no from contracts contract where contract.id=Collection.contract_id) contract_no,Collection.*,cd.payment_credited_to_bank_date,cd.* from contracts contract,collections as Collection,collection_details as cd where Collection.id=cd.collection_id and Collection.contract_id=contract.id and " . implode(' AND ', $options) . "";
                $results = $this->Report->query($sql_query);
            }
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

        $this->set(compact('data', 'dates', 'currencies', 'contracts', 'reports', 'controller', 'action', 'end_date', 'start_date', 'clients', 'units', 'results', 'product_categories'));
    }

    public function collection_report_summary() {

        if ($this->request->is('post')) {
            if ($this->request->data['Report']['contract_id']) {
                $options[] = "Collection.contract_id=" . $this->request->data['Report']['contract_id'];
            }
            if ($this->request->data['Report']['currency']) {
                $options[] = "Collection.currency='" . $this->request->data['Report']['currency'] . "'";
            }
            if ($this->request->data['Report']['unit_id']) {
                $options[] = "Collection.unitid=" . $this->request->data['Report']['unit_id'];
            }
            if ($this->request->data['Report']['client_id']) {
                $options[] = "Collection.clientid=" . $this->request->data['Report']['client_id'];
            }
            if ($this->request->data['Report']['product_category_id']) {
                $options[] = "Collection.product_category_id=" . $this->request->data['Report']['product_category_id'];
            }
            if (count($options) > 0) {
                $sql_query = "SELECT (select name from clients where clients.id=Collection.clientid)as client_name,(select name from product_categories where product_categories.id=Collection.product_category_id) as product_category,(select name from units where units.id=Collection.unitid) as unit_name,(select contract_no from contracts contract where contract.id=Collection.contract_id) contract_no,SUM(invoice_amount) as invoice_amount,SUM(amount_received+ait+vat+ld+other_deduction) as total_collection,currency from collections as Collection where " . implode(' AND ', $options) . " group by Collection.contract_id,Collection.product_category_id,Collection.currency";
                $results = $this->Report->query($sql_query);
            }
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
        #Unit list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');

        $this->set(compact('data', 'dates', 'currencies', 'contracts', 'reports', 'controller', 'action', 'end_date', 'start_date', 'clients', 'units', 'results', 'product_categories'));
    }

    /*  public function collection_report_summary() {
      if ($this->request->is('post')) {
      if ($this->request->data['Report']['contract_id']) {
      $options['Contract.id']=$this->request->data['Report']['contract_id'];
      }
      if ($this->request->data['Report']['currency']) {
      $currency=$this->request->data['Report']['currency'];
      }
      else{
      $this->Session->setFlash(__('Currency is Required!,Please Try Again'));
      $this->redirect($this->referer());
      }
      if ($this->request->data['Report']['unit_id']) {
      $options['Contract.unit_id']=$this->request->data['Report']['unit_id'];
      }
      if ($this->request->data['Report']['client_id']) {
      $options['Contract.client_id']=$this->request->data['Report']['client_id'];
      }
      if(!$options)
      {
      $this->Session->setFlash(__('Please select atleast another option with currency!,Please Try Again'));
      $this->redirect($this->referer());
      }
      $options=array(
      'conditions'=>$options,
      'fields'=>array(
      'Contract.id',
      'Contract.contract_no',
      'Client.name',
      'Unit.name',
      'SUM(Contract.contract_value_bdt) as contract_value_bdt',
      'SUM(Contract.contract_value_usd) as contract_value_usd'
      ),
      'group'=>array(
      'Contract.id'
      )
      );
      $this->loadModel('Contract');
      $this->Contract->recursive = 0;
      $results=  $this->Contract->find('all',$options);
      #find the contract id
      if($results){
      $contract_ids=null;
      foreach ($results as $value)
      {
      $contract_ids[$value['Contract']['id']]=$value['Contract']['id'];
      }
      #check any contact id to find the collection
      if($contract_ids)
      {
      $options=array(
      'conditions'=>array(
      'Collection.contract_id'=>$contract_ids,
      'Collection.currency'=>$currency
      ),
      'fields'=>array(
      'Collection.contract_id',
      'SUM(Collection.invoice_amount) as invoice_amount',
      'SUM(Collection.amount_received) as amount_received',
      'SUM(Collection.ait) as ait',
      'SUM(Collection.vat) as vat',
      'SUM(Collection.ld) as ld',
      'SUM(Collection.other_deduction) as other_deduction',
      'SUM(Collection.amount_received+Collection.ait+Collection.vat+Collection.ld+Collection.other_deduction) as total_collection',
      ),
      'group'=>array(
      'Collection.contract_id'
      )
      );
      #find the collection
      $this->loadModel('Collection');
      $collections=  $this->Collection->find('all',$options);

      foreach ($collections as $value)
      {
      $collection['Total_collection'][$value['Collection']['contract_id']]=$value[0];
      $collection['Invoice_amount'][$value['Collection']['contract_id']]=$value[0]['invoice_amount'];
      }
      echo '<pre>';print_r($collections);exit;
      }#/check any contact id to find the collection
      }#/find the contract id


      }

      //contract
      $this->loadModel('Contract');
      $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
      $this->Contract->recursive = -1;
      $contracts = $this->Contract->find('list', $options);
      //currency
      $currencies = array('USD' => 'USD', 'BDT' => 'BDT');
      #Client
      $this->loadModel('Client');
      $this->Client->recursive = -1;
      $clients = $this->Client->find('list');
      #Unit
      $this->loadModel('Unit');
      $this->Unit->recursive = -1;
      $units = $this->Unit->find('list');


      $this->set(compact( 'currencies', 'contracts','units','results','collection','currency','clients'));
      } */

    public function progressive_payment_product_report() {
        if ($this->request->is('post')) {

            if ($this->request->data['Report']['contract_id']) {
                $options[] = "ProgressivePayment.contract_id=" . $this->request->data['Report']['contract_id'];
            }
            if ($this->request->data['Report']['unit_id']) {
                $options[] = 'ProgressivePayment.unitid=' . $this->request->data['Report']['unit_id'];
            }
            if ($this->request->data['Report']['client_id']) {
                $options[] = 'ProgressivePayment.clientid=' . $this->request->data['Report']['client_id'];
            }
            if ($this->request->data['Report']['currency']) {
                $options[] = 'ProgressivePayment.currency=' . $this->request->data['Report']['currency'];
            }
            if ($this->request->data['Report']['product_category_id']) {
                $options[] = 'ProgressivePayment.product_category_id=' . trim($this->request->data['Report']['product_category_id']) . "%";
            }
            if (count($options) > 0) {
                $sql_query = "SELECT (select name from clients where clients.id=ProgressivePayment.clientid)as client_name,(select name from product_categories where product_categories.id=ProgressivePayment.product_category_id) as product_category,(select name from units where units.id=ProgressivePayment.unitid) as unit_name,(select contract_no from contracts contract where contract.id=ProgressivePayment.contract_id) contract_no,ProgressivePayment.currency,ProgressivePayment.quantity,ProgressivePayment.uom,(select name from products where products.id=ProgressivePayment.product_id) product_name from progressive_payments as ProgressivePayment where " . implode(' AND ', $options) . "";
                $results = $this->Report->query($sql_query);
            }
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
        #Unit list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');

        $this->set(compact('currencies', 'contracts', 'units', 'results', 'product_categories', 'currency', 'clients'));
    }

    public function credit_report() {
        if ($this->request->is('post')) {
            #if no input then redirect to the search page
            if (!$this->request->data['Report']['product_category_id'] && !$this->request->data['Report']['contract_id'] && !$this->request->data['Report']['unit_id'] && !$this->request->data['Report']['client_id'] && !$this->request->data['Report']['date_from'] && !$this->request->data['Report']['date_to'] && !$this->request->data['Report']['currency']) {
                $this->Session->setFlash(__('1.At Least one filter option is needed!,Please Try Again'));
                $this->redirect($this->referer());
            }
            #if no currency then redirect to the search page      
            if ($this->request->data['Report']['currency']) {
                #dilivery option
                $option_dilivery['Delivery.currency'] = $this->request->data['Report']['currency'];
                #collection option
                $option_collection['Collection.currency'] = $this->request->data['Report']['currency'];
            }

            #product category option
            if ($this->request->data['Report']['product_category_id']) {
                #dilivery option
                $option_dilivery['Delivery.product_category_id'] = $this->request->data['Report']['product_category_id'];
                #collection option
                $option_collection['Collection.product_category_id'] = $this->request->data['Report']['product_category_id'];
            }

            #if contract_id or client or unit id then find the contract ids 

            if ($this->request->data['Report']['contract_id']) {
                $option_dilivery['Delivery.contract_id'] = $this->request->data['Report']['contract_id'];
                $option_collection['Collection.contract_id'] = $this->request->data['Report']['contract_id'];
            }
            if ($this->request->data['Report']['client_id']) {
                $option_dilivery['Delivery.clientid'] = $this->request->data['Report']['client_id'];
                $option_collection['Collection.clientid'] = $this->request->data['Report']['client_id'];
            }
            if ($this->request->data['Report']['unit_id']) {
                $option_dilivery['Delivery.unitid'] = $this->request->data['Report']['unit_id'];
                $option_collection['Collection.unitid'] = $this->request->data['Report']['unit_id'];
            }
            if ($this->request->data['Report']['date_from'] && $this->request->data['Report']['date_to']) {
                $start_date = $this->request->data['Report']['date_from'];
                $end_date = $this->request->data['Report']['date_to'];
                if (strtotime($start_date) > strtotime($end_date)) {
                    $this->Session->setFlash(__('2.Date from must be less than Date To!,Please Try Again'));
                    $this->redirect($this->referer());
                }
                #dilivery option
                $option_dilivery['Delivery.actual_delivery_date BETWEEN ? AND ?'] = array($start_date, $end_date);
                $option_dilivery['Delivery.actual_delivery_date NOT LIKE'] = "0000-00-00 %";
                #collection option
                $option_collection['Collection.payment_credited_to_bank_date BETWEEN ? AND ?'] = array($start_date, $end_date);
                $option_collection['Collection.payment_credited_to_bank_date NOT LIKE'] = "0000-00-00 %";
            } else if ($this->request->data['Report']['date_from']) {
                $start_date = $this->request->data['Report']['date_from'];
                #dilivery option
                $option_dilivery['Delivery.actual_delivery_date <='] = $start_date;
                $option_dilivery['Delivery.actual_delivery_date NOT LIKE'] = "0000-00-00 %";
                #collection option
                $option_collection['Collection.payment_credited_to_bank_date <='] = $start_date;
                $option_collection['Collection.payment_credited_to_bank_date NOT LIKE'] = "0000-00-00 %";
                #if date is set then conract id is needed other wise it redirect to current page
            } else if ($this->request->data['Report']['date_to']) {
                $date_to = $this->request->data['Report']['date_to'];
                #dilivery option
                $option_dilivery['Delivery.actual_delivery_date <='] = $date_to;
                $option_dilivery['Delivery.actual_delivery_date NOT LIKE'] = "0000-00-00 %";
                #collection option
                $option_collection['Collection.payment_credited_to_bank_date <='] = $date_to;
                $option_collection['Collection.payment_credited_to_bank_date NOT LIKE'] = "0000-00-00 %";
            }
            #dilevery conditions

            $cond_dilevery = array(
                'conditions' => array($option_dilivery),
                'fields' => array(
                    'Delivery.product_category_id', 'Delivery.contract_id', 'currency', 'SUM(Delivery.quantity*Delivery.unit_price) as dilevery_value'
                ),
                'group' => array(
                    'Delivery.contract_id', 'Delivery.product_category_id', 'Delivery.currency'
                )
            );
            $this->loadModel('Delivery');
            $this->Delivery->recursive = -1;
            $deliveries = $this->Delivery->find('all', $cond_dilevery);
            $con_category = array();
            foreach ($deliveries as $value) {
                #contractid.product_category_id
                $contract_ids[$value['Delivery']['contract_id']] = $value['Delivery']['contract_id'];
                $category[$value['Delivery']['contract_id'] . $value['Delivery']['product_category_id']] = $value['Delivery']['product_category_id'];
                $con_category[$value['Delivery']['contract_id'] . $value['Delivery']['product_category_id'] . '-' . $value['Delivery']['currency']] = $value['Delivery']['contract_id'];
                $data['Delivery'][$value['Delivery']['contract_id'] . $value['Delivery']['product_category_id'] . '-' . $value['Delivery']['currency']] = $value[0]['dilevery_value'];
            }
            #echo '<pre>';print_r($data);exit;
            #dilevery conditions               
            $cond_collection = array(
                'conditions' => array($option_collection),
                'fields' => array(
                    'Collection.contract_id',
                    'Collection.collection_type',
                    'Collection.product_category_id',
                    'Collection.currency',
                    'SUM(Collection.amount_received) as amount_received',
                    'SUM(Collection.ait) as ait',
                    'SUM(Collection.vat) as vat',
                    'SUM(Collection.ld) as ld',
                    'SUM(Collection.other_deduction) as other_deduction',
                    'SUM(Collection.ajust_adv_amount) as ajust_adv_amount'
                ),
                'group' => array(
                    'Collection.contract_id', 'Collection.collection_type', 'Collection.product_category_id', 'Collection.currency',
                )
            );
            $this->loadModel('Collection');
            $this->Collection->recursive = -1;
            $collections = $this->Collection->find('all', $cond_collection);
            foreach ($collections as $value) {
                $contract_ids[$value['Collection']['contract_id']] = $value['Collection']['contract_id'];
                #product category
                $category[$value['Collection']['contract_id'] . $value['Collection']['product_category_id']] = $value['Collection']['product_category_id'];
                #product category and contract
                $con_category[$value['Collection']['contract_id'] . $value['Collection']['product_category_id'] . '-' . $value['Collection']['currency']] = $value['Collection']['contract_id'];

                $data[$value['Collection']['collection_type']]['Collection']['amount_received'][$value['Collection']['contract_id'] . $value['Collection']['product_category_id'] . '-' . $value['Collection']['currency']]+=$value[0]['amount_received'];

                $data['ait']['Collection']['ait'][$value['Collection']['contract_id'] . $value['Collection']['product_category_id'] . '-' . $value['Collection']['currency']]+=$value[0]['ait'];

                $data['vat']['Collection']['vat'][$value['Collection']['contract_id'] . $value['Collection']['product_category_id'] . '-' . $value['Collection']['currency']]+=$value[0]['vat'];

                $data['ld']['Collection']['ld'][$value['Collection']['contract_id'] . $value['Collection']['product_category_id'] . '-' . $value['Collection']['currency']]+=$value[0]['ld'];

                $data['other_deduction']['Collection']['other_deduction'][$value['Collection']['contract_id'] . $value['Collection']['product_category_id'] . '-' . $value['Collection']['currency']]+=$value[0]['other_deduction'];

                $data['ajust_adv_amount']['Collection']['ajust_adv_amount'][$value['Collection']['contract_id'] . $value['Collection']['product_category_id'] . '-' . $value['Collection']['currency']]+=$value[0]['ajust_adv_amount'];
                // if($value['Collection']['collection_type']!="Advance"){
                $data['total_collection_for_credit'][$value['Collection']['contract_id'] . $value['Collection']['product_category_id'] . '-' . $value['Collection']['currency']]+=$value[0]['amount_received'] + $value[0]['ait'] + $value[0]['vat'] + $value[0]['ld'] + $value[0]['other_deduction'];
                //  }

                $data['total_collection'][$value['Collection']['contract_id'] . $value['Collection']['product_category_id'] . '-' . $value['Collection']['currency']]+=$value[0]['amount_received'] + $value[0]['ait'] + $value[0]['vat'] + $value[0]['ld'] + $value[0]['other_deduction'];
            }
            if (!$contract_ids) {
                $this->Session->setFlash(__('3.There is no data with these filter options,Please Try Again'));
                $this->redirect($this->referer());
            }
            #echo '<pre>';print_r($data);exit;
            #contract conditions
            $cond_contract = array(
                'conditions' => array(
                    'Contract.id' => $contract_ids
                ),
                'fields' => array(
                    'Contract.id',
                    'Client.name',
                    'Unit.name',
                    'Contract.contract_no',
                    'Contract.contract_value_bdt',
                    'Contract.contract_value_usd',
                    'Contract.billing_percent_adv',
                    'Contract.billing_percent_progressive',
                    'Contract.billing_percent_first_retention',
                    'Contract.billing_percent_second_retention')
            );
            $this->loadModel('Contract');
            $this->Contract->recursive = 0;
            $pos = $this->Contract->find('all', $cond_contract);
            foreach ($pos as $value) {
                $po['id'][$value['Contract']['id']] = $value['Contract']['id'];
                $po['Client'][$value['Contract']['id']] = $value['Client']['name'];
                $po['Unit'][$value['Contract']['id']] = $value['Unit']['name'];
                $po['contract_no'][$value['Contract']['id']] = $value['Contract']['contract_no'];
                $po['contract_value_bdt'][$value['Contract']['id']] = $value['Contract']['contract_value_bdt'];
                $po['contract_value_usd'][$value['Contract']['id']] = $value['Contract']['contract_value_usd'];
                $po['billing_percent_progressive'][$value['Contract']['id']] = $value['Contract']['billing_percent_progressive'];
                $po['billing_percent_first_retention'][$value['Contract']['id']] = $value['Contract']['billing_percent_first_retention'];
                $po['billing_percent_second_retention'][$value['Contract']['id']] = $value['Contract']['billing_percent_second_retention'];
            }
            #contract product category wise value
            $option = array(
                'conditions' => array(
                    'ContractProduct.contract_id' => $contract_ids
                ),
                'fields' => array(
                    'ContractProduct.contract_id', 'ContractProduct.product_category_id', 'ContractProduct.currency', 'SUM(ContractProduct.quantity*ContractProduct.unit_price) as con_value'
                ),
                'group' => array(
                    'ContractProduct.contract_id', 'ContractProduct.product_category_id', 'ContractProduct.currency'
                )
            );
            $this->loadModel('ContractProduct');
            $this->ContractProduct->recursive = -1;
            $con_products = $this->ContractProduct->find('all', $option);
            foreach ($con_products as $value) {
                $data['contract_product_value'][$value['ContractProduct']['contract_id'] . $value['ContractProduct']['product_category_id'] . '-' . $value['ContractProduct']['currency']] = $value[0]['con_value'];
            }
        }
        #echo '<pre>';print_r($data);exit;
        #contract list box

        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);

        #Client

        $this->loadModel('Client');
        $this->Client->recursive = -1;
        $clients = $this->Client->find('list');

        #Unit
        $this->loadModel('Unit');
        $this->Unit->recursive = -1;
        $units = $this->Unit->find('list');
        #Product category

        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');

        $currencies = array('USD' => 'USD', 'BDT' => 'BDT');
        $this->set(compact('data', 'con_category', 'contracts', 'clients', 'units', 'product_categories', 'dates', 'results', 'currencies', 'category', 'po'));
    }

    /* public function credit_report_old()
      {
      if ($this->request->is('post')) {
      if ($this->request->data['Report']['date_from'] && $this->request->data['Report']['date_to']) {
      $start_date=$this->request->data['Report']['date_from'];
      $end_date=$this->request->data['Report']['date_to'];
      #dilivery option
      $option_dilivery['Delivery.actual_delivery_date BETWEEN ? AND ?']=array($start_date,$end_date);
      $option_dilivery['Delivery.actual_delivery_date NOT LIKE']="0000-00-00 %";
      #collection option
      $option_collection['Collection.payment_credited_to_bank_date BETWEEN ? AND ?']=array($start_date,$end_date);
      #if date is set then conract id is needed other wise it redirect to current page
      if(!$this->request->data['Report']['contract_id']){
      $this->Session->setFlash(__('When date is choose then Contract is needed.Please try again.'));
      return $this->redirect($this->referer());
      }

      }
      if ($this->request->data['Report']['currency']) {
      #dilivery option
      $currency=$option_dilivery['Delivery.currency']=$this->request->data['Report']['currency'];
      #collection option
      $option_collection['Collection.currency']=$this->request->data['Report']['currency'];

      }
      if ($this->request->data['Report']['contract_id']) {
      #dilivery option
      $option_dilivery['Delivery.contract_id']=$this->request->data['Report']['contract_id'];
      #collection option
      $option_collection['Collection.contract_id']=$this->request->data['Report']['contract_id'];
      }

      #dilevery conditions
      $cond_dilevery=array(
      'conditions'=>array($option_dilivery),
      'fields'=>array(
      'Delivery.contract_id','SUM(Delivery.quantity*Delivery.unit_price) as dilevery_value'
      ),
      'group'=>array(
      'Delivery.contract_id'
      )
      );
      $this->loadModel('Delivery');
      $this->Delivery->recursive=-1;
      $deliveries=  $this->Delivery->find('all',$cond_dilevery);
      foreach ($deliveries as $value)
      {
      $data['Delivery'][$value['Delivery']['contract_id']]=$value[0]['dilevery_value'];
      }
      #echo '<pre>';print_r($data);exit;

      #dilevery conditions
      $cond_collection=array(
      'conditions'=>array($option_collection),
      'fields'=>array(
      'Collection.contract_id',
      'Collection.collection_type',
      'SUM(Collection.amount_received) as amount_received',
      'SUM(Collection.ait) as ait',
      'SUM(Collection.vat) as vat',
      'SUM(Collection.ld) as ld',
      'SUM(Collection.other_deduction) as other_deduction',
      'SUM(Collection.ajust_adv_amount) as ajust_adv_amount'
      ),
      'group'=>array(
      'Collection.contract_id',
      'Collection.collection_type'
      )
      );
      $this->loadModel('Collection');
      $this->Collection->recursive=-1;
      $collections=  $this->Collection->find('all',$cond_collection);
      foreach ($collections as $value)
      {
      $data[$value['Collection']['collection_type']]['Collection']['amount_received'][$value['Collection']['contract_id']]=$value[0]['amount_received'];
      $data['ait']['Collection']['ait'][$value['Collection']['contract_id']]+=$value[0]['ait'];
      $data['vat']['Collection']['vat'][$value['Collection']['contract_id']]+=$value[0]['vat'];
      $data['ld']['Collection']['ld'][$value['Collection']['contract_id']]+=$value[0]['ld'];
      $data['other_deduction']['Collection']['other_deduction'][$value['Collection']['contract_id']]+=$value[0]['other_deduction'];
      $data['ajust_adv_amount']['Collection']['ajust_adv_amount'][$value['Collection']['contract_id']]+=$value[0]['ajust_adv_amount'];
      if($value['Collection']['collection_type']!="Advance"){
      $data['total_collection_for_credit'][$value['Collection']['contract_id']]+=$value[0]['amount_received']+$value[0]['ait']+$value[0]['vat']+$value[0]['ld']+$value[0]['other_deduction'];
      }

      $data['total_collection'][$value['Collection']['contract_id']]+=$value[0]['amount_received']+$value[0]['ait']+$value[0]['vat']+$value[0]['ld']+$value[0]['other_deduction'];

      }
      #echo '<pre>';print_r($data);exit;
      #contract conditions
      $cond_contract=array(
      'conditions'=>array(
      'Contract.id'=>$this->request->data['Report']['contract_id']
      ),
      'fields'=>array(
      'Client.name',
      'Contract.contract_no',
      'Contract.contract_value_bdt',
      'Contract.contract_value_usd',
      'Contract.billing_percent_adv',
      'Contract.billing_percent_progressive',
      'Contract.billing_percent_first_retention',
      'Contract.billing_percent_second_retention'                   )
      );
      $this->loadModel('Contract');
      $this->Contract->recursive=0;
      $po=  $this->Contract->find('all',$cond_contract);

      }


      #contract list box
      $this->loadModel('Contract');
      $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
      $this->Contract->recursive = -1;
      $contracts = $this->Contract->find('list', $options);
      #currency list box
      $currencies = array('USD' => 'USD', 'BDT' => 'BDT');
      #set the values
      $this->set(compact( 'currencies', 'contracts','start_date','end_date','po','data','currency'));

      } */

    public function delivery_report() {
        if ($this->request->is('post')) {
            if (!$this->request->data['Report']['product_category_id'] && !$this->request->data['Report']['contract_id'] && !$this->request->data['Report']['unit_id'] && !$this->request->data['Report']['client_id'] && !$this->request->data['Report']['date_from'] && !$this->request->data['Report']['date_to'] && !$this->request->data['Report']['date']) {
                $this->Session->setFlash(__('At Least one filter option is needed!,Please Try Again'));
                $this->redirect($this->referer());
            }
            $sql = "SELECT 
                Unit.name,
                Client.name,
                Contract.contract_no,
                ProductCategory.name,
                Product.name,
                Delivery.lot_id,
                Delivery.quantity,
                Delivery.uom,
                Delivery.unit_weight,
                Delivery.unit_weight_uom,
                Delivery.planned_delivery_date,
                Delivery.actual_delivery_date,
				Delivery.added_date,
				Delivery.added_by
                
                FROM deliveries AS Delivery
                LEFT JOIN contracts AS Contract
                ON Contract.id=Delivery.contract_id
                LEFT JOIN units AS Unit
                ON Unit.id=Contract.unit_id
                LEFT JOIN clients AS Client
                ON Client.id=Contract.client_id
                LEFT JOIN product_categories AS ProductCategory
                ON ProductCategory.id=Delivery.product_category_id
                LEFT JOIN products AS Product 
                ON Product.id=Delivery.product_id WHERE 1=1 ";
            if ($this->request->data['Report']['product_category_id']) {
                $sql.=" AND Delivery.product_category_id=" . $this->request->data['Report']['product_category_id'] . "";
            }
            if ($this->request->data['Report']['contract_id']) {
                $contract_id = $this->request->data['Report']['contract_id'];
                $sql.=" AND Delivery.contract_id=" . $this->request->data['Report']['contract_id'] . "";
            }
            if ($this->request->data['Report']['lot_id']) {
                $lot_id = $this->request->data['Report']['lot_id'];
                $sql.=" AND Delivery.lot_id='" . $this->request->data['Report']['lot_id'] . "'";
            }

            if ($this->request->data['Report']['unit_id']) {
                $sql.=" AND Contract.unit_id=" . $this->request->data['Report']['unit_id'] . "";
            }

            if ($this->request->data['Report']['client_id']) {
                $sql.=" AND Contract.client_id=" . $this->request->data['Report']['client_id'] . "";
            }

            if ($this->request->data['Report']['date_from'] || $this->request->data['Report']['date_to'] || $this->request->data['Report']['date']) {
                if ($this->request->data['Report']['date_from'] && $this->request->data['Report']['date_to'] && $this->request->data['Report']['date']) {
                    $sql.=" AND Delivery." . $this->request->data['Report']['date'] . " BETWEEN '" . $this->request->data['Report']['date_from'] . "' AND '" . $this->request->data['Report']['date_to'] . "'" . "";
                    $sql.=" AND Delivery." . $this->request->data['Report']['date'] . " NOT LIKE '0000-00-00'";
                } else {
                    $this->Session->setFlash(__('Date From,Date To and Date Type is Required!,Please Try Again'));
                    $this->redirect($this->referer());
                }
            }
            #execution of sql query
            #echo $sql;exit;        
            $results = $this->Report->query($sql);
            #echo '<pre>';print_r($results);exit;
        }

        #delivry date type
        $dates = array(
            'planned_delivery_date' => 'Planned Delivery Date',
            'actual_delivery_date' => 'Actual Delivery Date'
        );
        #contract list box

        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);

        #Client

        $this->loadModel('Client');
        $this->Client->recursive = -1;
        $clients = $this->Client->find('list');

        #Unit
        $this->loadModel('Unit');
        $this->Unit->recursive = -1;
        $units = $this->Unit->find('list');
        #Product category

        $this->loadModel('Delivery');
        $product_categories = $this->Delivery->ProductCategory->find('list');

        #lot model
        if ($contract_id):
            $this->loadModel('Lot');
            $option = array('conditions' => array(
                    'Lot.contract_id' => $contract_id
                ),
                'fields' => array('Lot.lot_no', 'Lot.lot_no')
            );
            $lots = $this->Lot->find('list', $option);
        endif;


        $this->set(compact('lots', 'lot_id', 'contracts', 'clients', 'units', 'product_categories', 'dates', 'results'));
    }

    public function production_report() {
        $results = null;
        if ($this->request->is('post')) {
            if (!$this->request->data['Report']['product_category_id'] && !$this->request->data['Report']['contract_id'] && !$this->request->data['Report']['unit_id'] && !$this->request->data['Report']['client_id'] && !$this->request->data['Report']['date_from'] && !$this->request->data['Report']['date_to'] && !$this->request->data['Report']['date']) {
                $this->Session->setFlash(__('At Least one filter option is needed!,Please Try Again'));
                $this->redirect($this->referer());
            }
            $sql = "SELECT 
                Unit.name,Client.name,
                Contract.contract_no,
                ProductCategory.name,
                Product.name,
                Production.lot_id,
                Production.quantity,
                Production.uom,
                Production.unit_weight,
                Production.unit_weight_uom,
                Production.planned_completion_date,
                Production.actual_completion_date 
                
                FROM productions AS Production
                LEFT JOIN contracts AS Contract
                ON Contract.id=Production.contract_id
                LEFT JOIN units AS Unit
                ON Unit.id=Contract.unit_id
                LEFT JOIN clients AS Client
                ON Client.id=Contract.client_id
                LEFT JOIN product_categories AS ProductCategory
                ON ProductCategory.id=Production.product_category_id
                LEFT JOIN products AS Product 
                ON Product.id=Production.product_id WHERE 1=1 ";
            if ($this->request->data['Report']['product_category_id']) {
                $sql.=" AND Production.product_category_id=" . $this->request->data['Report']['product_category_id'] . "";
            }
            if ($this->request->data['Report']['contract_id']) {
                $contract_id = $this->request->data['Report']['contract_id'];
                $sql.=" AND Production.contract_id=" . $this->request->data['Report']['contract_id'] . "";
            }

            if ($this->request->data['Report']['lot_id']) {
                $lot_id = $this->request->data['Report']['lot_id'];
                $sql.=" AND Production.lot_id='" . $this->request->data['Report']['lot_id'] . "'";
            }

            if ($this->request->data['Report']['unit_id']) {
                $sql.=" AND Contract.unit_id=" . $this->request->data['Report']['unit_id'] . "";
            }

            if ($this->request->data['Report']['client_id']) {
                $sql.=" AND Contract.client_id=" . $this->request->data['Report']['client_id'] . "";
            }

            if ($this->request->data['Report']['date_from'] || $this->request->data['Report']['date_to'] || $this->request->data['Report']['date']) {
                if ($this->request->data['Report']['date_from'] && $this->request->data['Report']['date_to'] && $this->request->data['Report']['date']) {
                    $sql.=" AND Production." . $this->request->data['Report']['date'] . " BETWEEN '" . $this->request->data['Report']['date_from'] . "' AND '" . $this->request->data['Report']['date_to'] . "'" . "";
                    $sql.=" AND Production." . $this->request->data['Report']['date'] . " NOT LIKE '0000-00-00'";
                } else {
                    $this->Session->setFlash(__('Date From,Date To and Date Type is Required!,Please Try Again'));
                    $this->redirect($this->referer());
                }
            }
            #execution of sql query
            #echo $sql;exit;        
            $results = $this->Report->query($sql);
            #echo '<pre>';print_r($results);exit;
        }

        #delivry date type
        $dates = array(
            'planned_completion_date' => 'Planned Completion Date',
            'actual_completion_date' => 'Actual Completion Date'
        );
        #contract list box

        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);

        #Client

        $this->loadModel('Client');
        $this->Client->recursive = -1;
        $clients = $this->Client->find('list');

        #Unit
        $this->loadModel('Unit');
        $this->Unit->recursive = -1;
        $units = $this->Unit->find('list');
        #Product category

        $this->loadModel('Production');
        $product_categories = $this->Production->ProductCategory->find('list');

        #lot model
        if ($contract_id):
            $this->loadModel('Lot');
            $option = array('conditions' => array(
                    'Lot.contract_id' => $contract_id
                ),
                'fields' => array('Lot.lot_no', 'Lot.lot_no')
            );
            $lots = $this->Lot->find('list', $option);
        endif;


        $this->set(compact('lots', 'lot_id', 'contracts', 'clients', 'units', 'product_categories', 'dates', 'results'));
    }

    /*
      public function credit_ar_report(){
      $results=null;
      if ($this->request->is('post')) {
      if(!$this->request->data['Report']['product_category_id']&&!$this->request->data['Report']['contract_id']&&!$this->request->data['Report']['unit_id']&&!$this->request->data['Report']['client_id']&&!$this->request->data['Report']['date_from']&&!$this->request->data['Report']['date_to']&&!$this->request->data['Report']['date'])
      {
      $this->Session->setFlash(__('At Least one filter option is needed!,Please Try Again'));
      $this->redirect($this->referer());
      }
      $sql="SELECT Unit.name,Client.name,
      Contract.contract_no,
      ProductCategory.name,

      SUM(Delivery.quantity) as quantity,
      SUM(Delivery.quantity*Delivery.unit_price) as delivery_value,

      'SUM(Collection.invoice_amount) as invoice_amount',
      'SUM(Collection.amount_received) as amount_received',
      'SUM(Collection.ait) as ait',
      'SUM(Collection.vat) as vat',
      'SUM(Collection.ld) as ld',
      'SUM(Collection.other_deduction) as other_deduction',
      'SUM(Collection.amount_received+Collection.ait+Collection.vat+Collection.ld+Collection.other_deduction) as total_collection'

      FROM deliveries AS Delivery
      LEFT JOIN contracts AS Contract
      ON Contract.id=Delivery.contract_id
      LEFT JOIN units AS Unit
      ON Unit.id=Contract.unit_id
      LEFT JOIN clients AS Client
      ON Client.id=Contract.client_id
      LEFT JOIN product_categories AS ProductCategory
      ON ProductCategory.id=Delivery.product_category_id
      LEFT JOIN collections AS Collection
      ON Contract.id=Collection.contract_id

      WHERE 1=1 ";
      if ($this->request->data['Report']['product_category_id']) {
      $sql.=" AND Delivery.product_category_id=".$this->request->data['Report']['product_category_id']."";
      }
      if ($this->request->data['Report']['contract_id']) {
      $sql.=" AND Delivery.contract_id=".$this->request->data['Report']['contract_id']."";
      }

      if ($this->request->data['Report']['unit_id']) {
      $sql.=" AND Contract.unit_id=".$this->request->data['Report']['unit_id']."";
      }

      if ($this->request->data['Report']['client_id']) {
      $sql.=" AND Contract.client_id=".$this->request->data['Report']['client_id']."";
      }

      if ($this->request->data['Report']['currency']) {
      $sql.=" AND Delivery.currency='".$this->request->data['Report']['currency']."'";
      }

      if($this->request->data['Report']['date_from'])
      {
      $sql.=" AND Delivery.actual_delivery_date <=".$this->request->data['Report']['currency']."";
      $sql.=" AND Delivery.actual_delivery_date NOT LIKE '0000-00-00'%"." ";

      #collection option
      $sql.=" AND Collection.payment_credited_to_bank_date <=".$this->request->data['Report']['currency']."";
      $sql.=" AND Collection.payment_credited_to_bank_date NOT LIKE '0000-00-00'%"." ";

      }
      $sql.=" group by Delivery.Contract_id,Delivery.product_category_id,Contract.client_id,Contract.unit_id,Contract.id,Collection.contract_id,Collection.product_category_id";
      #execution of sql query
      echo $sql;exit;
      $results=  $this->Report->query($sql);
      #echo '<pre>';print_r($results);exit;
      }

      #delivry date type
      $dates = array(
      'planned_completion_date' => 'Planned Completion Date',
      'actual_completion_date' => 'Actual Completion Date'
      );
      #contract list box
      $contracts=  $this->Session->read('contracts');
      if(!$contracts):
      $this->loadModel('Contract');
      $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
      $this->Contract->recursive = -1;
      $contracts = $this->Contract->find('list', $options);
      $this->Session->write('contracts',$contracts);
      endif;
      #Client
      $clients=  $this->Session->read('clients');
      if(!$clients):
      $this->loadModel('Client');
      $this->Client->recursive = -1;
      $clients = $this->Client->find('list');
      $this->Session->write('clients',$clients);
      endif;
      #Unit
      $this->loadModel('Unit');
      $this->Unit->recursive = -1;
      $units = $this->Unit->find('list');
      #Product category
      $product_categories=  $this->Session->read('product_categories');
      if(!$product_categories):
      $this->loadModel('Production');
      $product_categories=$this->Production->ProductCategory->find('list');
      $this->Session->write('product_categories',$product_categories);
      endif;
      $currencies = array('USD' => 'USD', 'BDT' => 'BDT');
      $this->set(compact('contracts','clients','units','product_categories','dates','results','currencies'));
      }

     */

    public function lot_report() {
        $results = null;
        if ($this->request->is('post')) {
            if (!$this->request->data['Report']['contract_id'] && !$this->request->data['Report']['lot_id']) {
                $this->Session->setFlash(__('At Least one filter option is needed!,Please Try Again'));
                $this->redirect($this->referer());
            }
            $sql = "SELECT 
                Unit.name,Client.name,
                Contract.contract_no,
                ProductCategory.name,
                Product.name,
                LotProduct.quantity,
                LotProduct.uom,
                LotProduct.unit_weight,
                LotProduct.unit_weight_uom,
                LotProduct.lot_id
                
                FROM lot_products AS LotProduct
                LEFT JOIN contracts AS Contract
                ON Contract.id=LotProduct.contract_id
                LEFT JOIN units AS Unit
                ON Unit.id=Contract.unit_id
                LEFT JOIN clients AS Client
                ON Client.id=Contract.client_id
                LEFT JOIN product_categories AS ProductCategory
                ON ProductCategory.id=LotProduct.product_category_id
                LEFT JOIN products AS Product 
                ON Product.id=LotProduct.product_id                
                WHERE 1=1 ";

            if ($this->request->data['Report']['contract_id']) {
                $contract_id = $this->request->data['Report']['contract_id'];
                $sql.=" AND LotProduct.contract_id=" . $this->request->data['Report']['contract_id'] . "";
            }

            if ($this->request->data['Report']['lot_id']) {
                $lot_id = $this->request->data['Report']['lot_id'];
                $sql.=" AND LotProduct.lot_id='" . $this->request->data['Report']['lot_id'] . "'";
            }

            #execution of sql query
            #echo $sql;exit;        
            $results = $this->Report->query($sql);
            #echo '<pre>';print_r($results);exit;
            #load lots by contract 
            $options = array('conditions' => array('Lot.contract_id' => $contract_id), 'fields' => array('lot_no', 'lot_no'), 'order' => array('Lot.id' => 'DESC'));
            $this->loadModel('Lot');
            $losts = $this->Lot->find('list', $options);
        }

        #contract list box    
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);

        $this->set(compact('contracts', 'results', 'lot_id', 'losts'));
    }

    public function procurement_report() {
        $results = null;
        if ($this->request->is('post')) {
            if (!$this->request->data['Report']['contract_id'] && !$this->request->data['Report']['lot_id']) {
                $this->Session->setFlash(__('At Least one filter option is needed!,Please Try Again'));
                $this->redirect($this->referer());
            }
            $sql = "SELECT 
                Unit.name,Client.name,
                Contract.contract_no,
                ProductCategory.name,
                Product.name,
                Procurement.quantity,
                Procurement.uom,
                Procurement.unit_weight,
                Procurement.unit_weight_uom,
                Procurement.lot_id
                
                FROM procurements AS Procurement
                LEFT JOIN contracts AS Contract
                ON Contract.id=Procurement.contract_id
                LEFT JOIN units AS Unit
                ON Unit.id=Contract.unit_id
                LEFT JOIN clients AS Client
                ON Client.id=Contract.client_id
                LEFT JOIN product_categories AS ProductCategory
                ON ProductCategory.id=Procurement.product_category_id
                LEFT JOIN products AS Product 
                ON Product.id=Procurement.product_id                
                WHERE 1=1 ";

            if ($this->request->data['Report']['contract_id']) {
                $contract_id = $this->request->data['Report']['contract_id'];
                $sql.=" AND Procurement.contract_id=" . $this->request->data['Report']['contract_id'] . "";
            }

            if ($this->request->data['Report']['lot_id']) {
                $lot_id = $this->request->data['Report']['lot_id'];
                $sql.=" AND Procurement.lot_id='" . $this->request->data['Report']['lot_id'] . "'";
            }

            #execution of sql query
            #echo $sql;exit;        
            $results = $this->Report->query($sql);
            #echo '<pre>';print_r($results);exit;
            #load lots by contract 
            $options = array('conditions' => array('Lot.contract_id' => $contract_id), 'fields' => array('lot_no', 'lot_no'), 'order' => array('Lot.id' => 'DESC'));
            $this->loadModel('Lot');
            $losts = $this->Lot->find('list', $options);
        }

        #contract list box       
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);

        $this->set(compact('contracts', 'results', 'lot_id', 'losts'));
    }

    public function psi_report() {
        $results = null;
        if ($this->request->is('post')) {
            if (!$this->request->data['Report']['contract_id'] && !$this->request->data['Report']['lot_id']) {
                $this->Session->setFlash(__('At Least one filter option is needed!,Please Try Again'));
                $this->redirect($this->referer());
            }
            $sql = "SELECT 
                Unit.name,Client.name,
                Contract.contract_no,
                ProductCategory.name,
                Product.name,
                Inspection.quantity,
                Inspection.uom,
                Inspection.unit_weight,
                Inspection.unit_weight_uom,
                Inspection.lot_id
                
                FROM inspections AS Inspection
                LEFT JOIN contracts AS Contract
                ON Contract.id=Inspection.contract_id
                LEFT JOIN units AS Unit
                ON Unit.id=Contract.unit_id
                LEFT JOIN clients AS Client
                ON Client.id=Contract.client_id
                LEFT JOIN product_categories AS ProductCategory
                ON ProductCategory.id=Inspection.product_category_id
                LEFT JOIN products AS Product 
                ON Product.id=Inspection.product_id                
                WHERE 1=1 ";

            if ($this->request->data['Report']['contract_id']) {
                $contract_id = $this->request->data['Report']['contract_id'];
                $sql.=" AND Inspection.contract_id=" . $this->request->data['Report']['contract_id'] . "";
            }

            if ($this->request->data['Report']['lot_id']) {
                $lot_id = $this->request->data['Report']['lot_id'];
                $sql.=" AND Inspection.lot_id='" . $this->request->data['Report']['lot_id'] . "'";
            }

            #execution of sql query
            #echo $sql;exit;        
            $results = $this->Report->query($sql);
            #echo '<pre>';print_r($results);exit;
            #load lots by contract 
            $options = array('conditions' => array('Lot.contract_id' => $contract_id), 'fields' => array('lot_no', 'lot_no'), 'order' => array('Lot.id' => 'DESC'));
            $this->loadModel('Lot');
            $losts = $this->Lot->find('list', $options);
        }

        #contract list box

        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);

        $this->set(compact('contracts', 'results', 'lot_id', 'losts'));
    }

    public function pli_report() {
        if ($this->request->is('post')) {
            if (!$this->request->data['Report']['product_category_id'] && !$this->request->data['Report']['contract_id'] && !$this->request->data['Report']['unit_id'] && !$this->request->data['Report']['client_id'] && !$this->request->data['Report']['date_from'] && !$this->request->data['Report']['date_to'] && !$this->request->data['Report']['date']) {
                $this->Session->setFlash(__('At Least one filter option is needed!,Please Try Again'));
                $this->redirect($this->referer());
            }
            $sql = "SELECT 
                Unit.name,
                Client.name,
                Contract.contract_no,
                ProductCategory.name,
                Product.name,
                Delivery.quantity,
				Delivery.pli_qty,
                Delivery.uom,
                Delivery.unit_weight,
                Delivery.unit_weight_uom,
                Delivery.lot_id,
                Delivery.planned_delivery_date,
                Delivery.actual_delivery_date,
                Delivery.planned_pli_date,
                Delivery.actual_pli_date,
                Delivery.planned_date_of_pli_aproval,
                Delivery.actual_date_of_pli_aproval
                
                FROM deliveries AS Delivery
                LEFT JOIN contracts AS Contract
                ON Contract.id=Delivery.contract_id
                LEFT JOIN units AS Unit
                ON Unit.id=Contract.unit_id
                LEFT JOIN clients AS Client
                ON Client.id=Contract.client_id
                LEFT JOIN product_categories AS ProductCategory
                ON ProductCategory.id=Delivery.product_category_id
                LEFT JOIN products AS Product 
                ON Product.id=Delivery.product_id WHERE 1=1 ";
            if ($this->request->data['Report']['product_category_id']) {
                $sql.=" AND Delivery.product_category_id=" . $this->request->data['Report']['product_category_id'] . "";
            }
            if ($this->request->data['Report']['contract_id']) {
                $contract_id = $this->request->data['Report']['contract_id'];
                $sql.=" AND Delivery.contract_id=" . $this->request->data['Report']['contract_id'] . "";
            }

            if ($this->request->data['Report']['unit_id']) {
                $sql.=" AND Contract.unit_id=" . $this->request->data['Report']['unit_id'] . "";
            }

            if ($this->request->data['Report']['client_id']) {
                $sql.=" AND Contract.client_id=" . $this->request->data['Report']['client_id'] . "";
            }
            if ($this->request->data['Report']['lot_id']) {
                $lot_id = $this->request->data['Report']['lot_id'];
                $sql.=" AND Delivery.lot_id='" . $this->request->data['Report']['lot_id'] . "'";
            }
            if ($this->request->data['Report']['date_from'] || $this->request->data['Report']['date_to'] || $this->request->data['Report']['date']) {
                if ($this->request->data['Report']['date_from'] && $this->request->data['Report']['date_to'] && $this->request->data['Report']['date']) {
                    $sql.=" AND Delivery." . $this->request->data['Report']['date'] . " BETWEEN '" . $this->request->data['Report']['date_from'] . "' AND '" . $this->request->data['Report']['date_to'] . "'" . "";
                    $sql.=" AND Delivery." . $this->request->data['Report']['date'] . " NOT LIKE '0000-00-00'";
                } else {
                    $this->Session->setFlash(__('Date From,Date To and Date Type is Required!,Please Try Again'));
                    $this->redirect($this->referer());
                }
            }
            #execution of sql query
            #echo $sql;exit;        
            $results = $this->Report->query($sql);
            #echo '<pre>';print_r($results);exit;
            #load lots by contract 
            $options = array('conditions' => array('Lot.contract_id' => $contract_id), 'fields' => array('lot_no', 'lot_no'), 'order' => array('Lot.id' => 'DESC'));
            $this->loadModel('Lot');
            $losts = $this->Lot->find('list', $options);
        }

        #delivry date type
        $dates = array(
            'planned_delivery_date' => 'Planned Delivery Date',
            'actual_delivery_date' => 'Actual Delivery Date',
            'planned_pli_date' => 'Planned PLI Date',
            'actual_pli_date' => 'Actual PLI Date',
            'planned_date_of_pli_aproval' => 'Planned PLI Approval Date',
            'actual_date_of_pli_aproval' => 'Actual PLI Approval Date'
        );
        #contract list box         
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);

        #Client        
        $this->loadModel('Client');
        $this->Client->recursive = -1;
        $clients = $this->Client->find('list');

        #Unit
        $this->loadModel('Unit');
        $this->Unit->recursive = -1;
        $units = $this->Unit->find('list');
        #Product category

        $this->loadModel('Delivery');
        $product_categories = $this->Delivery->ProductCategory->find('list');
        $this->Session->write('product_categories', $product_categories);

        $this->set(compact('losts', 'lot_id', 'contracts', 'clients', 'units', 'product_categories', 'dates', 'results'));
    }

    public function po_product_summary_report() {
        if($this->request->is('post')) {
            if (!$this->request->data['Report']['contract_id']) {
                $this->Session->setFlash(__('PO. No is required!,Please Try Again'));
                $this->redirect($this->referer());
            }
            if ($this->request->data['Report']['product_category_id']) {
                $option[] = "product_category_id=" . $this->request->data['Report']['product_category_id'];
            }
            if ($this->request->data['Report']['contract_id']) {
                $option[] = "contract_id=" . $this->request->data['Report']['contract_id'];
            }
            $option = implode(" AND ", $option);
            
            #contract products
            $cp_sql = "SELECT "
                    . "cp.contract_id,"
                    . "(select name from products as p where cp.product_id=p.id) name,"
                    . "(select name from product_categories as pc where cp.product_category_id=pc.id) category,"
                    . "cp.product_id,"
                    . "cp.quantity,"
                    . "cp.uom,"
                    . "cp.unit_price,"
                    . "cp.currency,"
                    . "cp.unit_weight,"
                    . "cp.unit_weight_uom"
                    . " FROM contract_products as cp"
                    . " where $option";
            $result = $this->Report->query($cp_sql);
            #echo '<pre>';print_r($result);exit;
            foreach ($result as $value) {
                #store contract and product id
                $data_product[$value['cp']['product_id']] = $value['cp']['contract_id'];
                $data['cp'][$value['cp']['product_id']]['name'] = $value[0]['name'];
                $data['cp'][$value['cp']['product_id']]['category'] = $value[0]['category'];
                $data['cp'][$value['cp']['product_id']]['quantity'] = $value['cp']['quantity'];
                $data['cp'][$value['cp']['product_id']]['uom'] = $value['cp']['uom'];
                $data['cp'][$value['cp']['product_id']]['unit_price'] = $value['cp']['unit_price'];
                $data['cp'][$value['cp']['product_id']]['currency'] = $value['cp']['currency'];
                $data['cp'][$value['cp']['product_id']]['unit_weight'] = $value['cp']['unit_weight'];
                $data['cp'][$value['cp']['product_id']]['unit_weight_uom'] = $value['cp']['unit_weight_uom'];
            }

            #lot products
            $lp_sql = "SELECT contract_id,"
                    . "product_id,"
                    . "sum(quantity) as quantity"
                    . " FROM lot_products as lp "
                    . "WHERE $option "
                    . "group by lp.product_id ";
            $result = $this->Report->query($lp_sql);
            foreach ($result as $value) {
                $data['lp'][$value['lp']['product_id']]['quantity'] = $value[0]['quantity'];
            }
            #group by lot
            $lp_groupbylot_sql = "SELECT contract_id,"
                    . "product_id,"
                    . "lot_id,"
                    . "sum(quantity) as quantity"
                    . " FROM lot_products as lp "
                    . "WHERE $option "
                    . "group by lp.product_id,lp.lot_id";
            $result = $this->Report->query($lp_groupbylot_sql);
            foreach ($result as $value) {
                $lot=explode('Lot-',$value['lp']['lot_id']);                
                $lot_info[$value['lp']['product_id']].='L-'.$lot[1].'#'.$value[0]['quantity'].'<br/>';
            }
            
            #procurement 
            $rm_sql = "SELECT contract_id,"
                    . "product_id,sum(quantity) as quantity"
                    . " FROM procurements rm "
                    . "WHERE $option and rm.actual_arrival_date NOT LIKE '0000-00-00' group by rm.product_id";
            $result = $this->Report->query($rm_sql);
            #echo '<pre>';print_r($result);exit;
            foreach ($result as $value) {
                $data['rm'][$value['rm']['product_id']]['quantity'] = $value[0]['quantity'];
            }
            #production
            $pr_sql = "SELECT contract_id,"
                    . "product_id,"
                    . "sum(quantity) as quantity"
                    . " FROM productions p "
                    . "WHERE $option and actual_completion_date!='0000-00-00' group by p.product_id";
            $result = $this->Report->query($pr_sql);
            foreach ($result as $value) {
                $data['p'][$value['p']['product_id']]['quantity'] = $value[0]['quantity'];
            }
            #Inspection
            $ins_sql = "SELECT contract_id,"
                    . "product_id,"
                    . "sum(quantity) as quantity"
                    . " FROM inspections i "
                    . "WHERE $option and actual_inspection_date!='0000-00-00' group by i.product_id";
            $result = $this->Report->query($ins_sql);
            foreach ($result as $value) {
                $data['i'][$value['i']['product_id']]['quantity'] = $value[0]['quantity'];
            }
            #Inspection
            $deli_sql = "SELECT contract_id,"
                    . "product_id,"
                    . "sum(quantity) as quantity,"
                    . "sum(pli_qty) as pli_qty"
                    . " FROM deliveries d "
                    . "WHERE $option and actual_delivery_date!='0000-00-00' group by d.product_id";
            $result = $this->Report->query($deli_sql);
            foreach ($result as $value) {
                $data['d'][$value['d']['product_id']]['quantity'] = $value[0]['quantity'];
                $data['d'][$value['d']['product_id']]['pli_qty'] = $value[0]['pli_qty'];
            }
            #Progressive payment
            $prog_sql = "SELECT contract_id,"
                    . "product_id,"
                    . "sum(quantity) as quantity"
                    . " FROM progressive_payments pp "
                    . "WHERE $option and sessionid!=0 group by pp.product_id";
            $result = $this->Report->query($prog_sql);
            foreach ($result as $value) {
                $data['pp'][$value['pp']['product_id']]['quantity'] = $value[0]['quantity'];
            }
        }
        #contract list box         
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));

        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);

        #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');

        $this->set(compact('data', 'data_product', 'contracts', 'product_categories','lot_info'));
    }
    
    public function yearly_plan_with_work_in_hand()
    {
        if($this->request->is('post')) {            
            if ($this->request->data['Report']['product_category_id']) {
                $product_category_id=$this->request->data['Report']['product_category_id'];
                $option[] = "cp.product_category_id=" . $this->request->data['Report']['product_category_id'];
            }
            if ($this->request->data['Report']['contract_id']) {
                $option[] = "cp.contract_id=" . $this->request->data['Report']['contract_id'];
            }
            if ($this->request->data['Report']['product_id']) {
                $product_id=$this->request->data['Report']['product_id'];
                $option[] = "cp.product_id=" . $this->request->data['Report']['product_id'];
            }
            if ($this->request->data['Report']['date_from']||$this->request->data['Report']['date_to'])
            {
                 if ($this->request->data['Report']['date_from']&&$this->request->data['Report']['date_to'])
                 {
                     $date_from=$this->request->data['Report']['date_from'];
                     $date_to=$this->request->data['Report']['date_to'];
                     $option[] = "SUBSTRING(cp.added_date,1,10) BETWEEN '".$this->request->data['Report']['date_from']."' AND '".$this->request->data['Report']['date_to']."'";
                 }
                 else if($this->request->data['Report']['date_from'])
                 {
                     $date_from=$this->request->data['Report']['date_from'];                    
                     $option[] = "SUBSTRING(cp.added_date,1,10) = '".$this->request->data['Report']['date_from']."'";
                 }
                 else if($this->request->data['Report']['date_to'])
                 {
                     $date_to=$this->request->data['Report']['date_to'];
                     $option[] = "SUBSTRING(cp.added_date,1,10) = '".$this->request->data['Report']['date_to']."'";
                 }
            }            
            
            $option = implode(" AND ", $option); 
            if($option)
            {
                $option=" AND ".$option;
            }
            else{
                $option='';
            }
            
            $sql="SELECT pc.name,
                    p.name,
                    c.contract_no,
                    c.contract_date,
                    cp.quantity,
                    cp.uom,
                    cp.unit_weight,
                    cp.unit_weight_uom,
                    cp.unit_price,
                    cp.currency,
                    cp.added_by,
                    cp.added_date
                    FROM contract_products as cp
                    LEFT JOIN contracts as c ON cp.contract_id=c.id
                    LEFT JOIN product_categories as pc ON cp.product_category_id=pc.id
                    LEFT JOIN products as p ON cp.product_id=p.id
                    WHERE 1=1  $option
                    ORDER BY cp.product_id ASC";
            $results=  $this->Report->query($sql);
            #echo '<pre>';print_r($results);exit;
            
        }
       #ProductCategory list box
       $this->loadModel('ProductCategory');
       $product_categories = $this->ProductCategory->find('list');
       
       #contract list box         
       $this->loadModel('Contract');
       $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
       $this->Contract->recursive = -1;
       $contracts = $this->Contract->find('list', $options);
       if(isset($product_category_id))
       {
           $this->loadModel('Product');
           $option=array(
               'conditions'=>array(
                   'Product.product_category_id'=>$product_category_id
               )
           );
           
           $products=  $this->Product->find('list',$option);
       }
       
       $this->set(compact('results','date_from','date_to','product_categories','contracts','product_id','products')); 
    }
    
    public function work_in_progress_summary_report()
    {
           
         if($this->request->is('post')) {
             
             if ($this->request->data['Report']['product_category_id']) {
               $option[]='product_category_id='.$this->request->data['Report']['product_category_id'];                
            }
            
            if ($this->request->data['Report']['contract_id']) {
               $option[]='contract_id='.$this->request->data['Report']['contract_id'];                
            }
            if ($this->request->data['Report']['unit_id']) {
                  $option[]='po.unit_id='.$this->request->data['Report']['unit_id'];                
               }
            if ($this->request->data['Report']['client_id']) {
               $option[]='po.client_id='.$this->request->data['Report']['client_id'];                
            }
            $option=  implode(" AND ", $option);
            $con='';
            if($option)
            {
                $con=" AND ".$option;
            } 
            $data=array();
            $sql="SELECT pc.name,sum(cp.quantity) as con_qty,cp.uom,cp.product_category_id FROM contract_products as cp,contracts as po, product_categories as pc where po.id=cp.contract_id and pc.id=cp.product_category_id $con GROUP BY cp.product_category_id,cp.uom";  
            $result=$this->Report->query($sql);
            $iteration=array();
            foreach ($result as $value)
            {
               $iteration[$value['cp']['product_category_id'].'-'.$value['cp']['uom']]=$value['cp']['product_category_id'];
               $data['po.qty'][$value['cp']['product_category_id'].'-'.$value['cp']['uom']]=$value[0]['con_qty'];
               $data[$value['cp']['product_category_id']]['name']=$value['pc']['name'];                
            }            
            $sql="SELECT sum(d.quantity) as deli_qty,d.uom,d.product_category_id FROM deliveries as d,contracts as po where po.id=d.contract_id $con GROUP BY d.product_category_id,d.uom";
            $result=$this->Report->query($sql);
            foreach ($result as $value)
            {                
               $data['d.qty'][$value['d']['product_category_id'].'-'.$value['d']['uom']]=$value[0]['deli_qty'];                
            }
         }
         
        #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');
       
        #contract list box         
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);
        #Client        
        $this->loadModel('Client');
        $this->Client->recursive = -1;
        $clients = $this->Client->find('list');

        #Unit
        $this->loadModel('Unit');
        $this->Unit->recursive = -1;
        $units = $this->Unit->find('list');
         
         $this->set(compact('data','iteration','product_categories','contracts','clients','units'));
    }
    
    public function invoice_planned_date_delivery_wise()
    {
        if($this->request->is('post')) {
            
            $option['Delivery.actual_delivery_date NOT LIKE']="0000-00-00";
            
            if ($this->request->data['Report']['product_category_id']) {
               $option['Delivery.product_category_id']=$this->request->data['Report']['product_category_id'];                
            }
            
            if ($this->request->data['Report']['contract_id']) {
               $option['Delivery.contract_id']=$this->request->data['Report']['contract_id'];                
            }
            if ($this->request->data['Report']['unit_id']) {
                  $option['Delivery.unitid']=$this->request->data['Report']['unit_id'];                
               }
            if ($this->request->data['Report']['client_id']) {
               $option['Delivery.clientid']=$this->request->data['Report']['client_id'];                
            }
             if ($this->request->data['Report']['currency']) {
               $option['Delivery.currency']=$this->request->data['Report']['currency'];                
            }
            
             if ($this->request->data['Report']['date_from']&&$this->request->data['Report']['date_to']) {
               $option['Delivery.payment_cheque_collection_progressive BETWEEN ? AND ?']=array($this->request->data['Report']['date_from'],$this->request->data['Report']['date_to']);                
            }
            else if($this->request->data['Report']['date_from']||$this->request->data['Report']['date_to']){
                $option['Delivery.payment_cheque_collection_progressive <=']=isset($this->request->data['Report']['date_from'])?$this->request->data['Report']['date_from']:$this->request->data['Report']['date_to'];
            }
            
            $conditions=array(
                'conditions'=>$option,
                    'fields'=>array(
                        'Delivery.product_category_id',
                        'Delivery.contract_id',
                        'Delivery.unitid',
                        'Delivery.clientid',
                        'Delivery.currency',
                        'SUM(Delivery.quantity) as quantity ',
                        'Delivery.unit_price',
                        'Delivery.uom',
                        'Delivery.lot_id',
                        'Delivery.unit_price',
                        'MAX(Delivery.actual_delivery_date) as actual_delivery_date',   
                        
                        'Contract.contract_no',
                        'Contract.pli_pac',
                        'Contract.pli_aproval',
                        'Contract.rr_collection_progressive',
                        'Contract.invoice_submission_progressive',
                        'Contract.payment_cheque_collection_progressive',
                        'Contract.payment_credited_to_bank_progressive',
                        'ProductCategory.name'
                        
                        
                    ),
                'group'=>array(
                    'Delivery.actual_delivery_date',
                    'Delivery.product_category_id',
                    'Delivery.contract_id',
                    'Delivery.unitid',
                    'Delivery.clientid',
                    'Delivery.currency',
                    'Delivery.uom',
                    'Delivery.lot_id'
                ),
                'order'=>array(
                    'Delivery.actual_delivery_date'=>"DESC",
                )
                 
            );
            $this->loadModel('Delivery');
            $results=$this->Delivery->find('all',$conditions);
            #echo '<pre>';print_r($results);exit;
        }
        #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list'); 
       
        #contract list box         
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);
        #Client        
        $this->loadModel('Client');
        $this->Client->recursive = -1;
        $clients = $this->Client->find('list');

        #Unit
        $this->loadModel('Unit');
        $this->Unit->recursive = -1;
        $units = $this->Unit->find('list');
        #currency
        $currencies = array('USD' => 'USD', 'BDT' => 'BDT');		
        $this->set(compact('product_categories','contracts','clients','units','results','currencies'));
    }
    
   public function invoice_planned_date_delivery_wise_with_collection()
    {
        if($this->request->is('post')) {
            
            $option['Delivery.actual_delivery_date NOT LIKE']="0000-00-00";
            
            if ($this->request->data['Report']['product_category_id']) {
               $option['Delivery.product_category_id']=$this->request->data['Report']['product_category_id'];                
            }
            
            if ($this->request->data['Report']['contract_id']) {
               $option['Delivery.contract_id']=$this->request->data['Report']['contract_id'];                
            }
            if ($this->request->data['Report']['unit_id']) {
                  $option['Delivery.unitid']=$this->request->data['Report']['unit_id'];                
               }
            if ($this->request->data['Report']['client_id']) {
               $option['Delivery.clientid']=$this->request->data['Report']['client_id'];                
            }
             if ($this->request->data['Report']['currency']) {
               $option['Delivery.currency']=$this->request->data['Report']['currency'];                
            }
           
             if ($this->request->data['Report']['date_from']&&$this->request->data['Report']['date_to']) {
                $option['Delivery.payment_cheque_collection_progressive BETWEEN ? AND ?']=array($this->request->data['Report']['date_from'],$this->request->data['Report']['date_to']);                
            }
            else if($this->request->data['Report']['date_from']||$this->request->data['Report']['date_to']){
                $option['Delivery.payment_cheque_collection_progressive <=']=isset($this->request->data['Report']['date_from'])?$this->request->data['Report']['date_from']:$this->request->data['Report']['date_to'];
            }
           
            $conditions=array(
                'conditions'=>$option,
                    'fields'=>array(
                        'Delivery.product_category_id',
                        'Delivery.contract_id',
                        'Delivery.unitid',
                        'Delivery.clientid',
                        'Delivery.currency',
                        'SUM(Delivery.quantity) as quantity ',
			'SUM(Delivery.quantity*Delivery.unit_price) as delivery_amount',
                        'Delivery.unit_price',
                        'Delivery.uom',
                        'Delivery.actual_delivery_date',
                        'Delivery.lot_id',
                        'Delivery.unit_price',
                        'Delivery.invoice_submission_progressive',
                        'Delivery.payment_cheque_collection_progressive',
                        'Delivery.payment_credited_to_bank_progressive',
                        'MAX(Delivery.actual_delivery_date) as actual_delivery_date',   
                        
                        'Contract.contract_no',
                        'Contract.pli_pac',
                        'Contract.pli_aproval',
                        'Contract.rr_collection_progressive',
                        'Contract.billing_percent_progressive',
                        'Contract.invoice_submission_progressive',
                        'Contract.payment_cheque_collection_progressive',
                        'Contract.payment_credited_to_bank_progressive',
                        'ProductCategory.name'
                        
                        
                    ),
                'group'=>array(
                    'Delivery.actual_delivery_date',
                    'Delivery.product_category_id',
                    'Delivery.contract_id',
                    'Delivery.unitid',
                    'Delivery.clientid',
                    'Delivery.currency',
                    'Delivery.uom',
                    'Delivery.lot_id'
                ),
                'order'=>array(
                    'Delivery.actual_delivery_date'=>"DESC",
                )
                 
            );
            $this->loadModel('Delivery');
            $results=$this->Delivery->find('all',$conditions);
            #echo '<pre>';print_r($results);exit;
        }
        #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list'); 
       
        #contract list box         
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);
        #Client        
        $this->loadModel('Client');
        $this->Client->recursive = -1;
        $clients = $this->Client->find('list');

        #Unit
        $this->loadModel('Unit');
        $this->Unit->recursive = -1;
        $units = $this->Unit->find('list');
        #currency
        $currencies = array('USD' => 'USD', 'BDT' => 'BDT');
         
        $this->set(compact('product_categories','contracts','clients','units','results','currencies','date_from','date_to','both_date'));
    }
    
    //this function has defined for updating the planned invoice,cheque and payment credited
    public function calculation()
    {
        $this->autoRender=false;
        $this->loadModel('Contract');
        $this->loadModel('Delivery');
        $this->Contract->recursive=-1;
        $contracts=$this->Contract->find('all');
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
             }
            if($sql){
               
             $this->Delivery->query($sql);
            }
        } 
    }
    
    //this function has defined for updating the planned invoice,cheque and payment credited
    public function calculation_lot()
    {
        $this->autoRender=false;
        $this->loadModel('Contract');
        $this->loadModel('Delivery');
        $this->Contract->recursive=-1;
        $contracts=$this->Contract->find('all');
         $this->Delivery->recursive=-1;
        foreach ($contracts as $contract)
        {
            $contract_id=$contract['Contract']['id'];            
             $conditions=array(
                'conditions'=>array(
                    'Delivery.contract_id'=>$contract_id,
                    'Delivery.actual_delivery_date NOT LIKE'=>"0000-00-00",
                    //'Delivery.invoice_submission_progressive LIKE'=>"0000-00-00",//this condition may change
                ),
                'fields'=>array(
                    'Delivery.payment_cheque_collection_progressive',
                    'Delivery.actual_delivery_date',
                    'Delivery.product_category_id',
                    'Delivery.contract_id',
                    'Delivery.unitid',
                    'Delivery.clientid',
                    'Delivery.currency',
                    'Delivery.uom',
                    'Delivery.lot_id'
                ),
                'group'=>array(
                    'Delivery.actual_delivery_date',
                    'Delivery.product_category_id',
                    'Delivery.contract_id',
                    'Delivery.unitid',
                    'Delivery.clientid',
                    'Delivery.currency',
                    'Delivery.uom',
                    'Delivery.lot_id'
                )
            );
            $deliveries=$this->Delivery->find('all',$conditions);
            $sql="";
            foreach ($deliveries as $deliverie)
            {
                
                $sql.="UPDATE collections SET lot_id = '".$deliverie['Delivery']['lot_id']."' WHERE contract_id=".$deliverie['Delivery']['contract_id']." and planned_payment_certificate_or_cheque_collection_date='".$deliverie['Delivery']['payment_cheque_collection_progressive']."' and product_category_id=".$deliverie['Delivery']['product_category_id']." and unitid=".$deliverie['Delivery']['unitid']." and clientid=".$deliverie['Delivery']['clientid']." and currency='".$deliverie['Delivery']['currency']."' and collection_type='Progressive';" ;
             }
            if($sql){
               
             $this->Delivery->query($sql);
            }
        } 
    }
    
    //received payment/cheque report
    public function cheque_payment_received_report()
    {   
                #Client        
                $this->loadModel('Client');
                $this->Client->recursive = -1;
                $clients = $this->Client->find('list');
                
                if ($this->request->is('post')) {
                    if($this->request->data['Report']['invoice_ref_no'])
                    {
                        $option['CollectionDetail.invoice_ref_no LIKE']=$this->request->data['Report']['invoice_ref_no']."%";
                    }
                    if($this->request->data['Report']['contract_id'])
                    {
                        $option['CollectionDetail.contract_id']=$this->request->data['Report']['contract_id'];
                    }
                    if($this->request->data['Report']['currency'])
                    {
                        $option['CollectionDetail.currency']=$this->request->data['Report']['currency'];
                    }
                     if($this->request->data['Report']['collection_type'])
                    {
                        $option['CollectionDetail.collection_type']=$this->request->data['Report']['collection_type'];
                    }
                    
                     if($this->request->data['Report']['client_id'])
                    {
                        $option['Contract.client_id']=$this->request->data['Report']['client_id'];
                    }
                    
                     if($this->request->data['Report']['unit_id'])
                    {
                        $option['Contract.unit_id']=$this->request->data['Report']['unit_id'];
                    }
                    
                     if($this->request->data['Report']['product_category_id'])
                    {
                        $option['ProductCategory.id']=$this->request->data['Report']['product_category_id'];
                    }
                    
                    
                     if($this->request->data['Report']['date_from']||$this->request->data['Report']['date_to']||$this->request->data['Report']['date_type'])
                    {
                         if($this->request->data['Report']['date_type'])
                            {
                               $date_type=$this->request->data['Report']['date_type']; 
                               $option["CollectionDetail.$date_type NOT LIKE"]="NULL";
                                if($this->request->data['Report']['date_from']&&$this->request->data['Report']['date_to'])
                                {
                                    $option["CollectionDetail.$date_type BETWEEN ? AND ?"]=array(date('Y-m-d',  strtotime($this->request->data['Report']['date_from'])),date('Y-m-d',  strtotime($this->request->data['Report']['date_to'])));
                                }
                                else if($this->request->data['Report']['date_from'])
                                {
                                    $option["CollectionDetail.$date_type <="]=date('Y-m-d',  strtotime($this->request->data['Report']['date_from']));
                                }
                                 else if($this->request->data['Report']['date_to'])
                                {
                                    $option["CollectionDetail.$date_type <="]=date('Y-m-d',  strtotime($this->request->data['Report']['date_to']));
                                }
                                else{
                                    $this->Session->setFlash(__('Please Give Date From or Date To Filed in search form,Please Try Again'));
                                    $this->redirect($this->referer());  
                                }
                            }
                            else{
                                    $this->Session->setFlash(__('Please Choose Date Type,Please Try Again'));
                                    $this->redirect($this->referer());  
                                }
                             
                    }
                    $this->loadModel('CollectionDetail');
                    //echo '<pre>';print_r($option);exit;
                    $conditions=array(
                          'conditions'=>$option
                      );
                    $collectionDetails=  $this->CollectionDetail->find('all',$conditions); 
                    
                    if($this->request->data['Report']['showreport']=="download"){
                        $this->autoRender=false;
                        $this->layout = false;
                        $fileName = "received_payment_report_".date("d-m-y:h:s").".xls";
                       
                        
                         foreach ($collectionDetails as $collectionDetail)
                            {
                                $data[]=array(
                                    h($collectionDetail['Contract']['contract_no']),
                                    h($clients[$collectionDetail['Contract']['client_id']]),
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
                                    h($collectionDetail['CollectionDetail']['planned_payment_certificate_or_cheque_collection_date']),
                                    h($collectionDetail['CollectionDetail']['cheque_or_payment_certification_date']),
                                    h($collectionDetail['CollectionDetail']['actual_payment_certificate_or_cheque_collection_date']),
                                    h($collectionDetail['CollectionDetail']['forecasted_payment_collection_date']),
                                    h($collectionDetail['CollectionDetail']['payment_credited_to_bank_date']),
                                );
                            }
                         $headerRow = array("PO/Contract No","Client","Category/Product","Collection Type","Invoice Ref No","Cheque Amount","Received Amount","Adj. Adv. Amount","AIT","VAT","L.D","Other Deduction","Currency","Planned Certificate/Cheque Collection Date","Payment Certification/Cheque Date","Actual Payment Certification/Cheque Collection Date","Forecasted Payment Collection Date","Payment (Credited to Bank) date");
                         //echo '<pre>';print_r($data);exit;
                         
                        $this->ExportXls->export($fileName, $headerRow, $data);               
                        }
                       
                }  
                
                #contract list box         
                $this->loadModel('Contract');
                $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
                $this->Contract->recursive = -1;
                $contracts = $this->Contract->find('list', $options);                
                #currency
                $currencies = array('USD' => 'USD', 'BDT' => 'BDT');
                //collection types
                $collection_types = array(
                    'Advance' => 'Advance',
                    'Progressive' => 'Progressive',
                    'Retention(1st)' => 'Retention(1st)',
                    'Retention(2nd)' => 'Retention(2nd)'
                );
                $date_types = array(        
                    'payment_credited_to_bank_date' => 'Payment (Credited To Bank) Date',
                    'forecasted_payment_collection_date' => 'Forecasted Payment Collection Date',
                    'cheque_or_payment_certification_date' => 'Payment Certificate/Cheque Date',
                    'actual_payment_certificate_or_cheque_collection_date' => 'Actual Payment Certificate/Cheque Collection Date'
                );
                //reference no
                #contract list box         
                $this->loadModel('CollectionDetail');
                $options = array('fields' => array('CollectionDetail.invoice_ref_no', 'CollectionDetail.invoice_ref_no'), 'order' => array('CollectionDetail.id' => 'DESC'));
                $this->CollectionDetail->recursive = -1;
                $invoice_ref_nos = $this->CollectionDetail->find('list', $options); 
               

                #Unit
                $this->loadModel('Unit');
                $this->Unit->recursive = -1;
                $units = $this->Unit->find('list');
                #ProductCategory list box
                $this->loadModel('ProductCategory');
                $product_categories = $this->ProductCategory->find('list'); 
                 
                
                $this->set(compact('collectionDetails','contracts','currencies','collection_types','date_types','invoice_ref_nos','clients','units','product_categories'));   
	}
        
        public function finance_invoice_planned_date_delivery_wise_with_collection()
        {
        #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');
        
        #Client        
        $this->loadModel('Client');
        $this->Client->recursive = -1;
        $clients = $this->Client->find('list');

        #Unit
        $this->loadModel('Unit');
        $this->Unit->recursive = -1;
        $units = $this->Unit->find('list');    
            
        if($this->request->is('post')) {
             
            $option['Delivery.actual_delivery_date NOT LIKE']="0000-00-00";
            $option_1['Collection.collection_type']="Progressive";
            
            if ($this->request->data['Report']['product_category_id']) {
               $option['Delivery.product_category_id']=$this->request->data['Report']['product_category_id']; 
               $option_1['Collection.product_category_id']=$this->request->data['Report']['product_category_id'];
            }
            
            if ($this->request->data['Report']['contract_id']) {
               $option['Delivery.contract_id']=$this->request->data['Report']['contract_id'];
               $option_1['Collection.contract_id']=$this->request->data['Report']['contract_id'];
            }
            if ($this->request->data['Report']['unit_id']) {
                  $option['Delivery.unitid']=$this->request->data['Report']['unit_id'];
                  $option_1['Collection.unitid']=$this->request->data['Report']['unit_id'];    
               }
            if ($this->request->data['Report']['client_id']) {
               $option['Delivery.clientid']=$this->request->data['Report']['client_id']; 
               $option_1['Collection.clientid']=$this->request->data['Report']['client_id']; 
            }
             if ($this->request->data['Report']['currency']) {
               $option['Delivery.currency']=$this->request->data['Report']['currency']; 
               $option_1['Collection.currency']=$this->request->data['Report']['currency']; 
            }
           if ($this->request->data['Report']['balance_carry']&&$this->request->data['Report']['balance_carry']=='no') {
                if ($this->request->data['Report']['date_from']&&$this->request->data['Report']['date_to']) {
                   $option['Delivery.payment_cheque_collection_progressive BETWEEN ? AND ?']=array($this->request->data['Report']['date_from'],$this->request->data['Report']['date_to']); 
                   $option_1['Collection.planned_payment_certificate_or_cheque_collection_date BETWEEN ? AND ?']=array($this->request->data['Report']['date_from'],$this->request->data['Report']['date_to']); 
               }
               else if($this->request->data['Report']['date_from']||$this->request->data['Report']['date_to']){
                   $option['Delivery.payment_cheque_collection_progressive <=']=isset($this->request->data['Report']['date_from'])?$this->request->data['Report']['date_from']:$this->request->data['Report']['date_to'];
                   $option_1['Collection.planned_payment_certificate_or_cheque_collection_date <=']=isset($this->request->data['Report']['date_from'])?$this->request->data['Report']['date_from']:$this->request->data['Report']['date_to'];
               }
           }
            
            $balance_greater_than=($this->request->data['Report']['balance_greater_than']>0)?trim($this->request->data['Report']['balance_greater_than']):0;
           
            $conditions=array(
                'conditions'=>$option,
                    'fields'=>array(
                        'Delivery.product_category_id',
                        'Delivery.contract_id',
                        'Delivery.unitid',
                        'Delivery.clientid',
                        'Delivery.currency',
                        'SUM(Delivery.quantity) as quantity ',
			            'SUM(Delivery.quantity*Delivery.unit_price) as delivery_amount',
                        'Delivery.unit_price',
                        'Delivery.uom',
                        'Delivery.actual_delivery_date',
                        'Delivery.lot_id',
                        'Delivery.unit_price',
                        'Delivery.invoice_submission_progressive',
                        'Delivery.payment_cheque_collection_progressive',
                        'Delivery.payment_credited_to_bank_progressive',
                        'MAX(Delivery.actual_delivery_date) as actual_delivery_date',   
                        
                        'Contract.contract_no',
                        'Contract.pli_pac',
                        'Contract.pli_aproval',
                        'Contract.rr_collection_progressive',
                        'Contract.billing_percent_progressive',
                        'Contract.invoice_submission_progressive',
                        'Contract.payment_cheque_collection_progressive',
                        'Contract.payment_credited_to_bank_progressive',
                        'ProductCategory.name'
                        
                        
                    ),
                'group'=>array(
                    'Delivery.payment_cheque_collection_progressive',
                    'Delivery.product_category_id',
                    'Delivery.contract_id',
                    'Delivery.unitid',
                    'Delivery.clientid',
                    'Delivery.currency',
                    'Delivery.uom',
                    'Delivery.lot_id'
                ),
                'order'=>array(
                    'Delivery.actual_delivery_date'=>"DESC",
                )
                 
            );
            $this->loadModel('Delivery');
            $results=$this->Delivery->find('all',$conditions);
            
            //query for payment collections
            $cond1=array(
                'conditions'=>$option_1,
                'fields'=>array(
                    'Collection.invoice_ref_no',
                    'Collection.product_category_id',
                    'Collection.contract_id',
                    'Collection.unitid',
                    'Collection.clientid',
                    'Collection.currency',
					'Collection.lot_id',
                    'Collection.planned_payment_certificate_or_cheque_collection_date',
                    'Collection.planned_payment_collection_date',
                    'Collection.payment_credited_to_bank_date',                     
                    'SUM(Collection.invoice_amount)as invoice_amount',
                    'SUM(Collection.cheque_amount)as cheque_amount',
                    'SUM(Collection.amount_received)as amount_received',
                    'SUM(Collection.ajust_adv_amount)as ajust_adv_amount',
                    'SUM(Collection.ait)as ait',
                    'SUM(Collection.vat)as vat',
                    'SUM(Collection.ld)as ld',
                    'SUM(Collection.other_deduction)as other_deduction',
                    ),
                'group'=>array(
                    'Collection.planned_payment_certificate_or_cheque_collection_date',
                    'Collection.product_category_id',
                    'Collection.contract_id',
                    'Collection.unitid',
                    'Collection.clientid',
                    'Collection.currency',
                    'Collection.lot_id'
                )
            );
            $this->loadModel('Collection');
            $results_1=$this->Collection->find('all',$cond1);
            
            $data='';
            foreach ($results_1 as $value)
            {
               $data[$value['Collection']['lot_id'].'-'.$value['Collection']['planned_payment_certificate_or_cheque_collection_date'].'-'.$value['Collection']['product_category_id'].'-'.$value['Collection']['contract_id'].'-'.$value['Collection']['unitid'].'-'.$value['Collection']['clientid'].'-'.$value['Collection']['currency'].'invoice_ref_no'] =$value['Collection']['invoice_ref_no'];
               $data[$value['Collection']['lot_id'].'-'.$value['Collection']['planned_payment_certificate_or_cheque_collection_date'].'-'.$value['Collection']['product_category_id'].'-'.$value['Collection']['contract_id'].'-'.$value['Collection']['unitid'].'-'.$value['Collection']['clientid'].'-'.$value['Collection']['currency'].'payment_credited_to_bank_date'] =$value['Collection']['payment_credited_to_bank_date'];
               $data[$value['Collection']['lot_id'].'-'.$value['Collection']['planned_payment_certificate_or_cheque_collection_date'].'-'.$value['Collection']['product_category_id'].'-'.$value['Collection']['contract_id'].'-'.$value['Collection']['unitid'].'-'.$value['Collection']['clientid'].'-'.$value['Collection']['currency'].'invoice_amount'] =$value[0]['invoice_amount'];
               $data[$value['Collection']['lot_id'].'-'.$value['Collection']['planned_payment_certificate_or_cheque_collection_date'].'-'.$value['Collection']['product_category_id'].'-'.$value['Collection']['contract_id'].'-'.$value['Collection']['unitid'].'-'.$value['Collection']['clientid'].'-'.$value['Collection']['currency'].'cheque_amount'] =$value[0]['cheque_amount'];
               $data[$value['Collection']['lot_id'].'-'.$value['Collection']['planned_payment_certificate_or_cheque_collection_date'].'-'.$value['Collection']['product_category_id'].'-'.$value['Collection']['contract_id'].'-'.$value['Collection']['unitid'].'-'.$value['Collection']['clientid'].'-'.$value['Collection']['currency'].'amount_received'] =$value[0]['amount_received'];
               $data[$value['Collection']['lot_id'].'-'.$value['Collection']['planned_payment_certificate_or_cheque_collection_date'].'-'.$value['Collection']['product_category_id'].'-'.$value['Collection']['contract_id'].'-'.$value['Collection']['unitid'].'-'.$value['Collection']['clientid'].'-'.$value['Collection']['currency'].'ajust_adv_amount'] =$value[0]['ajust_adv_amount'];
               $data[$value['Collection']['lot_id'].'-'.$value['Collection']['planned_payment_certificate_or_cheque_collection_date'].'-'.$value['Collection']['product_category_id'].'-'.$value['Collection']['contract_id'].'-'.$value['Collection']['unitid'].'-'.$value['Collection']['clientid'].'-'.$value['Collection']['currency'].'ait'] =$value[0]['ait'];
               $data[$value['Collection']['lot_id'].'-'.$value['Collection']['planned_payment_certificate_or_cheque_collection_date'].'-'.$value['Collection']['product_category_id'].'-'.$value['Collection']['contract_id'].'-'.$value['Collection']['unitid'].'-'.$value['Collection']['clientid'].'-'.$value['Collection']['currency'].'vat'] =$value[0]['vat'];
               $data[$value['Collection']['lot_id'].'-'.$value['Collection']['planned_payment_certificate_or_cheque_collection_date'].'-'.$value['Collection']['product_category_id'].'-'.$value['Collection']['contract_id'].'-'.$value['Collection']['unitid'].'-'.$value['Collection']['clientid'].'-'.$value['Collection']['currency'].'ld'] =$value[0]['ld'];
               $data[$value['Collection']['lot_id'].'-'.$value['Collection']['planned_payment_certificate_or_cheque_collection_date'].'-'.$value['Collection']['product_category_id'].'-'.$value['Collection']['contract_id'].'-'.$value['Collection']['unitid'].'-'.$value['Collection']['clientid'].'-'.$value['Collection']['currency'].'other_deduction'] =$value[0]['other_deduction'];
            }
             
            $this->autoRender=false;
            $this->layout = false;
            $fileName = "Planned_invoice_report_finance_".date("d-m-y:h:s").".xls";
            
            foreach ($results as $result): 
                 $actual_invoice_amount=$data[$result['Delivery']['lot_id'].'-'.$result['Delivery']['payment_cheque_collection_progressive'].'-'.$result['Delivery']['product_category_id'].'-'.$result['Delivery']['contract_id'].'-'.$result['Delivery']['unitid'].'-'.$result['Delivery']['clientid'].'-'.$result['Delivery']['currency'].'invoice_amount'];
                 $actual_invoice_amount=($actual_invoice_amount)?$actual_invoice_amount:0;
                 
                 $amount_received=$data[$result['Delivery']['lot_id'].'-'.$result['Delivery']['payment_cheque_collection_progressive'].'-'.$result['Delivery']['product_category_id'].'-'.$result['Delivery']['contract_id'].'-'.$result['Delivery']['unitid'].'-'.$result['Delivery']['clientid'].'-'.$result['Delivery']['currency'].'amount_received'];
                 $amount_received=($amount_received)?$amount_received:0;
                 
                 $ajust_adv_amount=$data[$result['Delivery']['lot_id'].'-'.$result['Delivery']['payment_cheque_collection_progressive'].'-'.$result['Delivery']['product_category_id'].'-'.$result['Delivery']['contract_id'].'-'.$result['Delivery']['unitid'].'-'.$result['Delivery']['clientid'].'-'.$result['Delivery']['currency'].'ajust_adv_amount'];
                 $ajust_adv_amount=($ajust_adv_amount)?$ajust_adv_amount:0;
                 
                 $ait=$data[$result['Delivery']['lot_id'].'-'.$result['Delivery']['payment_cheque_collection_progressive'].'-'.$result['Delivery']['product_category_id'].'-'.$result['Delivery']['contract_id'].'-'.$result['Delivery']['unitid'].'-'.$result['Delivery']['clientid'].'-'.$result['Delivery']['currency'].'ait'];
                 $ait=($ait)?$ait:0;
                 
                 $vat=$data[$result['Delivery']['lot_id'].'-'.$result['Delivery']['payment_cheque_collection_progressive'].'-'.$result['Delivery']['product_category_id'].'-'.$result['Delivery']['contract_id'].'-'.$result['Delivery']['unitid'].'-'.$result['Delivery']['clientid'].'-'.$result['Delivery']['currency'].'vat'];
                 $vat=($vat)?$vat:0;
                 
                 $ld=$data[$result['Delivery']['lot_id'].'-'.$result['Delivery']['payment_cheque_collection_progressive'].'-'.$result['Delivery']['product_category_id'].'-'.$result['Delivery']['contract_id'].'-'.$result['Delivery']['unitid'].'-'.$result['Delivery']['clientid'].'-'.$result['Delivery']['currency'].'ld'];
                 $ld=($ld)?$ld:0;
                 
                 $other_deduction=$data[$result['Delivery']['lot_id'].'-'.$result['Delivery']['payment_cheque_collection_progressive'].'-'.$result['Delivery']['product_category_id'].'-'.$result['Delivery']['contract_id'].'-'.$result['Delivery']['unitid'].'-'.$result['Delivery']['clientid'].'-'.$result['Delivery']['currency'].'other_deduction'];
                 $other_deduction=($other_deduction)?$other_deduction:0;
                 
                 $banlance=round($actual_invoice_amount-($amount_received+$ait+$vat+$ld+$other_deduction),3);
                 
                if($banlance>$balance_greater_than):
                $data_csv[]=array(
                        h($result['Contract']['contract_no']),
                        h($result['Delivery']['lot_id']),
                        h($units[$result['Delivery']['unitid']]),
                        h($clients[$result['Delivery']['clientid']]),
                        h($result['ProductCategory']['name']),
                        h($delivery_amount=$result[0]['delivery_amount']),
                        h($invoice_amount=round(($delivery_amount*$result['Contract']['billing_percent_progressive'])/100,3)),
                        h($actual_invoice_amount),
                        h($result['Delivery']['currency']),
                        h($data[$result['Delivery']['lot_id'].'-'.$result['Delivery']['payment_cheque_collection_progressive'].'-'.$result['Delivery']['product_category_id'].'-'.$result['Delivery']['contract_id'].'-'.$result['Delivery']['unitid'].'-'.$result['Delivery']['clientid'].'-'.$result['Delivery']['currency'].'invoice_ref_no']),
                        h($result['Delivery']['payment_cheque_collection_progressive']),
                        h($result['Delivery']['payment_credited_to_bank_progressive']),
                        h($data[$result['Delivery']['lot_id'].'-'.$result['Delivery']['payment_cheque_collection_progressive'].'-'.$result['Delivery']['product_category_id'].'-'.$result['Delivery']['contract_id'].'-'.$result['Delivery']['unitid'].'-'.$result['Delivery']['clientid'].'-'.$result['Delivery']['currency'].'payment_credited_to_bank_date']),
                        h($amount_received),
                        h($ajust_adv_amount),
                        h($ait),
                        h($vat),
                        h($ld),
                        h($other_deduction),
                        h($banlance)
                      );
             endif;
            endforeach;
            $headerRow = array("PO.NO","Lot.NO","Unit","Client","Product/Category","Delivery Value","Planned Invoice Amount","Actual Invoice Amount","Currency","Invoice Ref.","Planned Certificate/Cheque Collection Date","Planned Bank Credit (Payment Received) Date","Actual Bank Credit (Payment Received) Date","Amount Received","Adv. Adjustment","AIT","VAT","L.D","Other Deduction","Actual Balance");
                         
           $this->ExportXls->export($fileName, $headerRow, $data_csv);
           
        }
        #contract list box         
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);
        
        #currency
        $currencies = array('USD' => 'USD', 'BDT' => 'BDT');
         
        $this->set(compact('product_categories','contracts','clients','units','results','currencies','date_from','date_to','both_date','data','balance_greater_than'));
    
        }
        
        public function po_product_status(){             
             if($this->request->is('post')) {                  
               $option_c='';  
               $option_cp='';  
               $option_lot='';
               $option_pro='';
               $option_ins='';
               $option_deli='';
               $option_pp='';
               $option_procu='';
                if ($this->request->data['Report']['contract_id']) {
               $option_c.=" AND c.id=".$this->request->data['Report']['contract_id']."";     
               $option_cp.=" AND cp.contract_id=".$this->request->data['Report']['contract_id']."";
               $option_lot.=" AND lotproduct.contract_id=".$this->request->data['Report']['contract_id']."";
               $option_procu.=" AND procurement.contract_id=".$this->request->data['Report']['contract_id']."";
               $option_pro.=" AND production.contract_id=".$this->request->data['Report']['contract_id']."";
               $option_ins.=" AND inspection.contract_id=".$this->request->data['Report']['contract_id']."";
               $option_deli.=" AND delivery.contract_id=".$this->request->data['Report']['contract_id']."";               
               $option_pp.=" AND pp.contract_id=".$this->request->data['Report']['contract_id']."";
               #load lots by contract wise
               $lots=$this->requestAction(array('controller'=>'lots','action'=>'LotListBoxByContract',$this->request->data['Report']['contract_id']));
               
            }  
            else{
                $this->Session->setFlash(__('PO. No is required!,Please Try Again'));
                $this->redirect($this->referer());
            }
               if ($this->request->data['Report']['product_category_id']) {
               $option_cp.=" AND cp.product_category_id='".$this->request->data['Report']['product_category_id']."'";
               $option_lot.=" AND lotproduct.product_category_id='".$this->request->data['Report']['product_category_id']."'";
               $option_procu.=" AND procurement.product_category_id='".$this->request->data['Report']['product_category_id']."'";
               $option_pro.=" AND production.product_category_id='".$this->request->data['Report']['product_category_id']."'";
               $option_ins.=" AND inspection.product_category_id='".$this->request->data['Report']['product_category_id']."'";
               $option_deli.=" AND delivery.product_category_id='".$this->request->data['Report']['product_category_id']."'";               
               $option_pp.=" AND pp.product_category_id='".$this->request->data['Report']['product_category_id']."'";
            }  
             if ($this->request->data['Report']['unit_id']) {
               $option_c.=" AND c.unit_id=".$this->request->data['Report']['unit_id']."";              
               $option_deli.=" AND delivery.unitid=".$this->request->data['Report']['unit_id']."";               
               $option_pp.=" AND pp.unitid=".$this->request->data['Report']['unit_id']."";
            }  
             if ($this->request->data['Report']['client_id']) {
               $option_c.=" AND c.client_id='".$this->request->data['Report']['client_id']."'";
               $option_deli.=" AND delivery.clientid='".$this->request->data['Report']['client_id']."'";               
               $option_pp.=" AND pp.clientid='".$this->request->data['Report']['client_id']."'";
            }  
             if ($this->request->data['Report']['lot_id']) {     
               $lot_id=$this->request->data['Report']['lot_id'];  
               $option_lot.=" AND lotproduct.lot_id='".$this->request->data['Report']['lot_id']."'";
               $option_procu.=" AND procurement.lot_id='".$this->request->data['Report']['lot_id']."'";
               $option_pro.=" AND production.lot_id='".$this->request->data['Report']['lot_id']."'";
               $option_ins.=" AND inspection.lot_id='".$this->request->data['Report']['lot_id']."'";
               $option_deli.=" AND delivery.lot_id='".$this->request->data['Report']['lot_id']."'";               
               $option_pp.=" AND pp.lot_id='".$this->request->data['Report']['lot_id']."'";
            }  
         $sql="SELECT c.id,
       c.contract_no,
       c.contracttype,
       u.name as unit,
       cl.name as client,
       lotproduct.lot_id,
       cp.pc_name as pc_name,
       IFNULL(cp.cp_qty,0) as cp_qty,
       IFNULL(lotproduct.lot_qty,0) as lot_qty,
       IFNULL(procurement.procurement_qty,0) as procurement_qty,
       IFNULL(inspection.inspection_qty,0) as inspection_qty,
       IFNULL(production.production_qty,0) as production_qty,
       IFNULL(delivery.delivery_qty,0) as delivery_qty,
       IFNULL(delivery.pli_qty,0) as pli_qty,
       IFNULL(pp.progressive_qty,0) as progressive_qty,       
       cp.uom
       FROM contracts c  
       LEFT JOIN (
                   SELECT sum(quantity) as cp_qty,contract_id,(SELECT name from product_categories AS pc WHERE pc.id=cp.product_category_id) as pc_name,uom,product_category_id
                   FROM contract_products as cp
                   WHERE 1=1	
                   $option_cp
                   GROUP BY product_category_id,uom,contract_id
       ) AS cp ON c.id=cp.contract_id  

LEFT JOIN (
                   SELECT sum(quantity) as procurement_qty,contract_id,product_category_id,uom
                   FROM procurements  procurement   
                   WHERE 1=1
                   $option_procu
                   GROUP BY product_category_id,uom,contract_id
       ) AS procurement ON c.id=procurement.contract_id AND cp.uom=procurement.uom AND cp.product_category_id=procurement.product_category_id
LEFT JOIN (
                   SELECT sum(quantity) as lot_qty,contract_id,product_category_id,uom,lot_id
                   FROM lot_products lotproduct
				   WHERE 1=1
                                   $option_lot
                   GROUP BY product_category_id,uom,contract_id
       ) AS lotproduct ON c.id=lotproduct.contract_id AND cp.uom=lotproduct.uom AND cp.product_category_id=lotproduct.product_category_id

LEFT JOIN (
                   SELECT sum(quantity) as production_qty,contract_id,product_category_id,uom
                   FROM productions production
                   WHERE 1=1	
                   $option_pro
                   GROUP BY product_category_id,uom,contract_id
       ) AS production ON c.id=production.contract_id AND cp.uom=production.uom AND cp.product_category_id=production.product_category_id

LEFT JOIN (
                   SELECT sum(quantity) as inspection_qty,contract_id,product_category_id,uom
                   FROM inspections inspection
				   WHERE 1=1
                                   $option_ins
                   GROUP BY product_category_id,uom,contract_id
       ) AS inspection ON c.id=inspection.contract_id AND cp.uom=inspection.uom AND cp.product_category_id=inspection.product_category_id  
LEFT JOIN (
                   SELECT sum(quantity) as delivery_qty,sum(pli_qty) as pli_qty,contract_id,product_category_id,uom
                   FROM deliveries delivery
				   WHERE 1=1
                                   $option_deli
                   GROUP BY product_category_id,uom,contract_id
       ) AS delivery ON c.id=delivery.contract_id AND cp.uom=delivery.uom AND cp.product_category_id=delivery.product_category_id  
LEFT JOIN (
                   SELECT sum(quantity) as progressive_qty,contract_id,product_category_id,uom
                   FROM progressive_payments pp
				   WHERE 1=1
                                   $option_pp
                   GROUP BY product_category_id,uom,contract_id
       ) AS pp ON c.id=pp.contract_id AND cp.uom=pp.uom AND cp.product_category_id=pp.product_category_id  

LEFT JOIN units as u ON u.id=c.unit_id
LEFT JOIN clients as cl ON cl.id=c.client_id 
WHERE 1=1
$option_c
GROUP BY c.unit_id,c.id,c.client_id,cp.contract_id,cp.product_category_id,cp.uom
";
      $results=  $this->Report->query($sql);     
     if($this->request->data['Report']['showreport']=="download")
    {
         $fileName = "po_product_summary_report_".date("d-m-y:h:s").".xls";
         foreach ($results as $result):
         $data_csv[]=array(
                       h($result['c']['contract_no']),                         
                       h($result['c']['contracttype']),
                       h($result['u']['unit']),
                       h($result['cl']['client']),
                       h($result['cp']['pc_name']),
                       h($result[0]['cp_qty']),
                       h($result[0]['lot_qty']),
                       h($result[0]['procurement_qty']),
                       h($result[0]['production_qty']),
                       h($result[0]['inspection_qty']),
                       h($result[0]['delivery_qty']),
                       h($result[0]['pli_qty']),
                       h($result[0]['progressive_qty']),
                      );
                  endforeach;
            $headerRow = array("PO.NO","Contract Type","Unit","Client","Product/Category","PO","Lot","Procurement","Production","Inspection","Delivery","PLI","Invoice");
            $this->ExportXls->export($fileName, $headerRow, $data_csv); 
    } 
             } 
        #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');
        
        #Client        
        $this->loadModel('Client');
        $this->Client->recursive = -1;
        $clients = $this->Client->find('list');

        #Unit
        $this->loadModel('Unit');
        $this->Unit->recursive = -1;
        $units = $this->Unit->find('list'); 
        
         #contract list box         
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);
        
        $this->set(compact('product_categories','contracts','clients','units','results','lots','lot_id'));
        }

}
