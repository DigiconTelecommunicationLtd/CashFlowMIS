<?php

App::uses('AppController', 'Controller');

/**
 * Productions Controller
 *
 * @property Production $Production
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ProductionsController extends AppController {

    public function add() {
        $option = array();
        $option_1 = array();
        $lot_id = null;
        if ($this->request->is('post')) {
            //echo '<pre>';print_r($this->request->data);exit;
            // $this->layout="ajax"; 
            $date = $this->request->data['Production']['date'];
            $date_type = $this->request->data['Production']['date_type'];

            $contract_id = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['Production']['contract_id']));
            $lot_id = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['Production']['lot_id']));
            $FormType = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['Production']['FormType']));

            if (!$contract_id || !$lot_id || !$FormType) {
                $this->Session->setFlash(__('PO & Lot number is required!. Please, try again.'));
                return $this->redirect(array('action' => 'add'));
            }

            if ($this->request->data['Production']['product_category_id']) {
                $option['LotProduct.product_category_id'] = $product_category_id = $this->request->data['Production']['product_category_id'];
                $option_1['Production.product_category_id'] = $this->request->data['Production']['product_category_id'];
            }
            $planned_same_as_actual = trim($this->request->data['Production']['planned_same_as_actual']);

            $option['LotProduct.contract_id'] = $contract_id;
            $option['LotProduct.lot_id'] = $lot_id;
            #production
            $option_1['Production.contract_id'] = $contract_id;
            $option_1['Production.lot_id'] = $lot_id;
            //set default lot no
            $lots[$lot_id] = $lot_id;

            /* Actual date for product arrival from procurement option */
            $actaul_date_options = null;
            $actaul_date_result = null;
            $actual_column = "actual_arrival_date";
            $model = "Procurement";
            if ($contract_id) {
                $actaul_date_options[$model . '.contract_id'] = $contract_id;
            }
            if ($lot_id) {
                $actaul_date_options[$model . '.lot_id'] = $lot_id;
            }
            if ($product_category_id) {
                $actaul_date_options[$model . '.product_category_id'] = $product_category_id;
            }
            $this->loadModel($model);

            if ($actaul_date_options) {
                $actaul_date_options = array('conditions' => array($actaul_date_options), 'fields' => array($model . '.product_id', $model . '.' . $actual_column), 'order' => array($model . '.id' => 'DESC'));
                $actaul_date_info = $this->$model->find('list', $actaul_date_options);
                $this->set('actaul_date_info', $actaul_date_info);
            }
            /* End Actual date for product arrival from procurement option */

            #/check po and lot no 
            #if form is submitted for save planned qty and completion date
            if ($FormType == 'submit'):
                //$this->Production->recursive=-1;
                $pquantitys = $this->request->data['Production']['quantity'];
                $uom = $this->request->data['Production']['uom'];
                $unit_weight = $this->request->data['Production']['unit_weight'];
                $unit_weight_uom = $this->request->data['Production']['unit_weight_uom'];
                $product_category_id = $this->request->data['Production']['product_category_id'];
                //echo '<pre>';print_r($unit_weight_uom);exit;
                $planned = $this->request->data['Production']['planned'];
                //$actual=$this->request->data['Production']['actual'];
                //echo '<pre>';print_r($actual);exit;
                foreach ($pquantitys as $key => $quantity) {
                    /*                     * ***************of check lot qty and production qty ******************* */
                    if (!$quantity || $quantity <= 0 || !trim($planned[$key]) || !$product_category_id[$key]) {
                        continue;
                    }
                    #check lot qty with product id lot number
                    $lot_option1 = array(
                        'conditions' => array(
                            'LotProduct.lot_id' => $lot_id,
                            'LotProduct.product_id' => $key
                        ),
                        'fields' => array(
                            'SUM(LotProduct.quantity) as quantity'
                        )
                    );
                    $this->loadModel('LotProduct');
                    // $this->LotProduct->recursive=-1;
                    $lot_qty = $this->LotProduct->find('first', $lot_option1);
                    $lot_qty = ($lot_qty[0]['quantity'] > 0) ? $lot_qty[0]['quantity'] : 0;

                    #check production qty with product id lot number
                    $pro_option1 = array(
                        'conditions' => array(
                            'Production.lot_id' => $lot_id,
                            'Production.product_id' => $key
                        ),
                        'fields' => array(
                            'SUM(Production.quantity) as quantity'
                        )
                    );
                    //$this->Production->recursive=-1;
                    $pro_qty = $this->Production->find('first', $pro_option1);
                    $pro_qty = ($pro_qty[0]['quantity'] > 0) ? $pro_qty[0]['quantity'] : 0;
                    $pro_qty+=$quantity;
                    #compare lot size with production size
                    if ($pro_qty > $lot_qty):
                        continue;
                    endif;
                    /*                     * ***************end of check lot qty and production qty ******************* */

                    $user = $this->Session->read('UserAuth');
                    $UserID = $user['User']['username'];

                    $option1['Production.product_id'] = $key;
                    $option1['Production.contract_id'] = $contract_id;
                    $option1['Production.lot_id'] = $lot_id;
                    $quantity = trim($quantity);
                    if ($planned[$key]) {
                        $planned_completion_date = str_replace(array("\r", "\n", "\t"), '', date('Y-m-d', strtotime($planned[$key])));
                        if ($planned_completion_date == "1970-01-01") {
                            continue;
                        }
                    } else {
                        continue;
                    }
                    $saveData[] = array(
                        'Production' => array(
                            'contract_id' => $contract_id,
                            'lot_id' => $lot_id,
                            'product_category_id' => $product_category_id[$key],
                            'product_id' => $key,
                            'quantity' => trim($quantity),
                            'uom' => $uom[$key],
                            'planned_completion_date' => $planned_completion_date,
                            'actual_completion_date' => ($planned_same_as_actual) ? $planned_completion_date : '0000-00-00',
                            'unit_weight' => $unit_weight[$key],
                            'unit_weight_uom' => $unit_weight_uom[$key],
                            'added_by' => $UserID
                        )
                    );
                }
                /*                 * *************save production data*************** */
                $count_product = count($saveData);
                if ($saveData > 0) {
                    $this->Production->create();
                    if ($this->Production->saveMany($saveData)) {
                        $this->Session->setFlash(__($count_product . ' products has been saved successfully.'));
                    } else {
                        $this->Session->setFlash(__('Product could not saved successfully.Please, try again.'));
                    }
                } else {
                    $this->Session->setFlash(__('There is no product for saved.Please, try again.'));
                }
            /*             * *************end of save production data*************** */
            #if form is submitted for save planned qty and completion date
            endif;
            //get Lots products by contract and lot no
            App::uses('LotProductsController', 'Controller');
            $lots = new LotProductsController();
            $lots_products = $lots->__getLotProducts($option);

            //lots by contract
            App::uses('LotsController', 'Controller');
            $lots = new LotsController();
            $lots = $lots->__getLotNumberListBoxByContract($contract_id);

            //previously procurement product by contract and lot wise
            $result = $this->__getProductionProducts($option_1);
            $this->Production->unbindModel(array('belongsTo' => array('Contract')));
            $this->Production->recursive = 0;
            $actual_date_results = $this->Production->find('all', array('conditions' => $option_1, 'order' => array('Production.product_id' => 'ASC')));
            //echo '<pre>';print_r($actual_date_results);exit;
        }

        App::uses('ContractsController', 'Controller');
        $contracts = new ContractsController();
        $contracts = $contracts->__getContractsListBox();

        #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');

        $this->set(compact('date', 'date_type', 'contracts', 'lots', 'contract_id', 'lot_id', 'lots_products', 'result', 'actual_date_results', 'product_categories'));
    }

    public function __getProductionProducts(&$option) {
        if (empty($option)) {
            return '';
        }
        $condition = array('conditions' => array($option), 'fields' => array('Production.product_id', 'SUM(Production.quantity) as quantity', 'MAX(Production.planned_completion_date) planned_completion_date', 'MAX(Production.actual_completion_date) actual_completion_date', 'Production.lot_id'), 'group' => array('Production.contract_id', 'Production.lot_id', 'Production.product_id'), 'order' => array('Production.product_id' => 'ASC'));
        $pmt_products = $this->Production->find('all', $condition);
        $data = array();
        foreach ($pmt_products as $key => $value) {
            $data[$value['Production']['product_id']] = $value[0]['quantity'];
            $data['pd_' . $value['Production']['product_id']] = $value[0]['planned_completion_date'];
            $data['ad_' . $value['Production']['product_id']] = $value[0]['actual_completion_date'];
        }
        return $data;
    }

    public function production_completion_date_editing() {
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
            if ($check):
                // $actual_date_update=$this->request->data['actual_date_update'];
                $this->Production->id = $id;
                $this->beforeRender();
                if ($this->Production->saveField('actual_completion_date', $actual_date_update, false)) {
                    $this->Production->saveField('modified_by', $UserID, false);
                    $this->Production->saveField('modified_date', date('Y-m-d h:m:i'), false);
                    $message = "Record updated successfully.";
                } else {
                    $message = "Error:There is an error while record updating!";
                }
            endif;
            echo $message;

            // $this->set(compact('actual_date_update','message'));
        }
    }

    public function production_actual_completion_date_editing_all() {
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
                if ($id && $actual_date) {
                    $sql.="UPDATE productions SET actual_completion_date= '" . $actual_date . "', modified_by= '" . $UserID . "', modified_date= '" . date('Y-m-d H:m:s') . "' WHERE id =$id;";
                }
            }
            if ($this->Production->query($sql)) {
                echo'1';
            } else {
                echo'2';
            }
        }
        $this->autoRender = FALSE;
    }

    public function __getProductionProductsforInspection(&$option) {
        if (empty($option)) {
            return '';
        }
        $condition = array('conditions' => array($option), 'fields' => array('Production.product_id', 'Product.name', 'SUM(Production.quantity) as quantity', 'Production.unit_weight', 'Production.unit_weight_uom', 'Production.uom', 'Production.lot_id', 'ProductCategory.name', 'Production.product_category_id'), 'group' => array('Production.contract_id', 'Production.lot_id', 'Production.product_id'));
        $pmt_products = $this->Production->find('all', $condition);
        return $pmt_products;
    }

    public function delete() {
        $this->layout = 'ajax';
        $this->autoRender = false;
        #find the product option
        $this->Production->id = $id = $this->request->data['id'];
        if (!$this->Production->exists()) {
            //throw new NotFoundException(__('Invalid production product'));
            echo "0";
            exit();
        } else {# valid id is found
            $this->Production->recursive = -1;
            $product = $this->Production->findById($id);

            $product_id = $product['Production']['product_id'];
            $lot_id = $product['Production']['lot_id'];
            $planned_completion_date = $product['Production']['planned_completion_date'];
            if ($planned_completion_date == "0000-00-00") {
                $this->request->allowMethod('post', 'delete');
                if ($this->Production->delete()) {
                    echo "1";
                } else {
                    echo "0";
                }
            } else {
                $option1 = array(
                    'conditions' => array(
                        'Inspection.product_id' => $product_id,
                        'Inspection.lot_id' => $lot_id
                    )
                );
                $this->loadModel('Inspection');
                $this->Inspection->recursive = -1;

                if (!$this->Inspection->find('first', $option1)):#check the product of that lot is in inspection        
                    $this->request->allowMethod('post', 'delete');
                    if ($this->Production->delete()) {
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

    /* this function transfer the product from one lot to another */

    public function product_transfer_lot_to_lot() {
        if ($this->request->is('post')) {
            $contract_id = $this->request->data['Production']['contract_id'];
            $lot_id = $this->request->data['Production']['lot_id'];
            $product_category_id = $this->request->data['Production']['product_category_id'];
            $check_form_submit = $this->request->data['Production']['check_form_submit'];

            $user = $this->Session->read('UserAuth');
            $UserID = $user['User']['username'];

            if (!$contract_id || !$lot_id || !$product_category_id) {
                $this->Session->setFlash(__('PO/LOT/Category input fields are required.Please, try again.'));
                $this->redirect($this->referer());
            }
            if ($check_form_submit == "submitted") {
                //Transfer lot number
                $transfer_lot = $this->request->data['Production']['transfer_lot'];

                if (!$contract_id || !$lot_id || !$product_category_id || !$transfer_lot) {
                    $this->Session->setFlash(__('PO/LOT/Category input fields are required.Please, try again.'));
                    $this->redirect($this->referer());
                }

                $product_ids = $this->request->data['Production']['product_ids'];
                $product_ids = explode("-", $product_ids);

                $data = '';
                //inspection product sum with filter options
                $model = "Inspection";
                $condition = array(
                    'conditions' => array(
                        "$model.contract_id" => $contract_id,
                        "$model.lot_id" => $lot_id,
                        "$model.product_category_id" => $product_category_id,
                        "$model.product_id" => $product_ids
                    ),
                    'fields' => array("$model.product_id", "SUM($model.quantity) as quantity"),
                    'group' => array("$model.product_id")
                );

                $this->loadModel($model);
                $inspections = $this->$model->find('all', $condition);
                //initialization
                foreach ($inspections as $value) {
                    $data[$model][$value[$model]['product_id']] = $value[0]['quantity'];
                }
                //end inspection
                //production product sum with filter options
                $model = "Production";
                $condition = array(
                    'conditions' => array(
                        "$model.contract_id" => $contract_id,
                        "$model.lot_id" => $lot_id,
                        "$model.product_category_id" => $product_category_id,
                        "$model.product_id" => $product_ids
                    ),
                    'fields' => array("$model.product_id", "SUM($model.quantity) as quantity"),
                    'group' => array("$model.product_id")
                );

                //$this->loadModel($model);
                $productions = $this->$model->find('all', $condition);
                //initalization
                foreach ($productions as $value) {
                    $data[$model][$value[$model]['product_id']] = $value[0]['quantity'];
                }
                //end production summation 
                //sql query initialization 
                $sql_product_update = '';
                $sql_new_production_entry = '';
                foreach ($product_ids as $value) {

                    #Product Balance
                    $product_id = $value;
                    $update_qty = ($data['Inspection'][$product_id] > 0) ? $data['Inspection'][$product_id] : 0;

                    $pro_bal = $data['Production'][$product_id] - $update_qty;
                    $pro_bal = $new_qty = ($pro_bal > 0) ? $pro_bal : 0;
                    if ($pro_bal > 0) { //if cond_1 check the balace qty is greater than 0
                        // All production production  List with filter options which will be updated
                        $model = "Production";
                        $condition = array(
                            'conditions' => array(
                                "$model.contract_id" => $contract_id,
                                "$model.lot_id" => $lot_id,
                                "$model.product_category_id" => $product_category_id,
                                "$model.product_id" => $product_id
                            ),
                            'order' => array("$model.quantity" => "DESC")
                        );

                        $this->$model->recursive = -1;
                        $productions_all = $this->$model->find('all', $condition);

                        foreach ($productions_all as $value) {
                            $id = $value[$model]['id'];
                            $uom = $value[$model]['uom'];
                            $unit_weight = $value[$model]['unit_weight'];
                            $unit_weight_uom = $value[$model]['unit_weight_uom'];
                            $planned_completion_date = $value[$model]['planned_completion_date'];
                            $actual_completion_date = $value[$model]['actual_completion_date'];
                            $quantity = $value[$model]['quantity'];

                            //check balance quantity and production quantity of single row
                            if ($quantity >= $pro_bal) {
                                $update_qty = $quantity - $pro_bal;
                                //update product qty
                                if ($id) {
                                    $sql_product_update.="UPDATE productions SET quantity =$update_qty WHERE id=  $id;";
                                }
                                $pro_bal = $quantity - $pro_bal;
                                break;
                            } else {
                                $pro_bal = $pro_bal - $quantity; //reduce the balace and set row qty is 0

                                if ($id) {
                                    $sql_product_update.="UPDATE productions SET quantity =0 WHERE id=  $id;";
                                }
                            }
                        }
                        #check the existing new lot and product in production table
                        $option = array(
                            'conditions' => array(
                                'Production.contract_id' => $contract_id,
                                'Production.lot_id' => $transfer_lot, //new lot id where product will be transfered
                                'Production.product_category_id' => $product_category_id,
                                'Production.product_id' => $product_id
                            )
                        );
                        $this->Production->recursive = -1;
                        $chek_new_pro_with_lot = $this->Production->find('first', $option);

                        if ($chek_new_pro_with_lot) {//update
                            $new_qty = $chek_new_pro_with_lot['Production']['quantity'] + $new_qty; //addition 
                            $id = $chek_new_pro_with_lot['Production']['id'];
                            if ($id) {
                                $sql_product_update.="UPDATE productions SET quantity= $new_qty WHERE id=$id;";
                            }
                        } else { //new product entry with balance quantity
                            $sql_new_production_entry.="INSERT INTO productions VALUES (NULL, '" . $contract_id . "', '" . $transfer_lot . "', '" . $product_category_id . "', '" . $product_id . "', '" . $new_qty . "', '" . $uom . "', '" . $unit_weight . "', '" . $unit_weight_uom . "', '" . $planned_completion_date . "', '" . $actual_completion_date . "', '','" . $UserID . "', '" . date('Y-m-d H:m:s') . "', '', '0000-00-00 00:00:00');";
                        }
                    }//end of if cond_1 check the balace qty is greater than 0
                }
                //execute the query
                if($sql_product_update){
                $this->Production->query($sql_product_update);
                }
                if($sql_new_production_entry){
                $this->Production->query($sql_new_production_entry);
                }


                //redirect to rm to transfer
                $model = "Procurement";
                $condition = array(
                    'conditions' => array(
                        "$model.contract_id" => $contract_id,
                        "$model.lot_id" => $lot_id,
                        "$model.product_category_id" => $product_category_id,
                        "$model.product_id" => $product_ids
                    ),
                    'fields' => array("$model.product_id", "SUM($model.quantity) as quantity"),
                    'group' => array("$model.product_id")
                );
                
                

                $this->loadModel($model);
                $procurements = $this->$model->find('all', $condition);
                if ($procurements) {
                    $this->redirect(array('action' => 'rm_transfer', $contract_id, $product_category_id, str_replace('/', '|', $lot_id), str_replace('/', '|', $transfer_lot)));
                } else {
                    $this->redirect(array('action' => 'lot_transfer', $contract_id, $product_category_id, str_replace('/', '|', $lot_id), str_replace('/', '|', $transfer_lot)));
                }
            }

            $data = '';
            /* inspection */
            $model = "Inspection";
            $condition = array(
                'conditions' => array(
                    "$model.contract_id" => $contract_id,
                    "$model.lot_id" => $lot_id,
                    "$model.product_category_id" => $product_category_id
                ),
                'fields' => array("$model.product_id", "SUM($model.quantity) as quantity"),
                'group' => array("$model.product_id")
            );

            $this->loadModel($model);
            $inspections = $this->$model->find('all', $condition);
            foreach ($inspections as $value) {
                $data[$model][$value[$model]['product_id']] = $value[0]['quantity'];
            }
            /* production */
            $model = "Production";
            $condition = array(
                'conditions' => array(
                    "$model.contract_id" => $contract_id,
                    "$model.lot_id" => $lot_id,
                    "$model.product_category_id" => $product_category_id
                ),
                'fields' => array("$model.product_id", "SUM($model.quantity) as quantity"),
                'group' => array("$model.product_id")
            );

            //$this->loadModel($model);
            $productions = $this->$model->find('all', $condition);
            foreach ($productions as $value) {
                $data[$model][$value[$model]['product_id']] = $value[0]['quantity'];
            }

            /* Procurement */
            $model = "Procurement";
            $condition = array(
                'conditions' => array(
                    "$model.contract_id" => $contract_id,
                    "$model.lot_id" => $lot_id,
                    "$model.product_category_id" => $product_category_id
                ),
                'fields' => array("$model.product_id", "SUM($model.quantity) as quantity"),
                'group' => array("$model.product_id")
            );

            $this->loadModel($model);
            $procurements = $this->$model->find('all', $condition);
            foreach ($procurements as $value) {
                $data[$model][$value[$model]['product_id']] = $value[0]['quantity'];
            }


            /* LOT Products */
            $model = "LotProduct";
            $condition = array(
                'conditions' => array(
                    "$model.contract_id" => $contract_id,
                    "$model.lot_id" => $lot_id,
                    "$model.product_category_id" => $product_category_id
                ),
                'fields' => array("$model.product_id", "$model.quantity", 'Product.name', "$model.id", "$model.product_category_id", "$model.product_id", "$model.uom", "$model.unit_weight", "$model.unit_weight_uom"),
                'group' => array("$model.product_id")
            );

            $this->loadModel($model);
            $lot_products = $this->$model->find('all', $condition);

            /* Find the lot no by contract ID */
            $this->loadModel('Lot');
            $lots = $this->Lot->find('list', array('conditions' => array('Lot.contract_id' => $contract_id), 'fields' => array('Lot.lot_no', 'Lot.lot_no')));
            /* Find the Transfered lot no by contract ID */
            
            $lot_trans = $this->Lot->find('list', array('conditions' => array('Lot.contract_id' => $contract_id,'Lot.lot_no NOT LIKE' => $lot_id), 'fields' => array('Lot.lot_no', 'Lot.lot_no')));
        }

        #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');

        #contract list box         
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options);
        $this->set(compact('product_category_id', 'contract_id', 'lot_id', 'lots', 'data', 'lot_products', 'product_categories', 'contracts','lot_trans'));
    }

    public function rm_transfer($contract_id = null, $product_category_id = null, $lot_id = null, $transfer_lot = null) {
         
        $lot_id = str_replace('|', '/', $lot_id);
        $transfer_lot = str_replace('|', '/', $transfer_lot);

        $user = $this->Session->read('UserAuth');
        $UserID = $user['User']['username'];

        if (!$contract_id || !$lot_id || !$product_category_id || !$transfer_lot) {
            $this->Session->setFlash(__('PO/LOT/Category input fields are required.Please, try again.'));
            $this->redirect($this->referer());
        }

        $data = '';
        //inspection product sum with filter options
        $model = "Production";
        $condition = array(
            'conditions' => array(
                "$model.contract_id" => $contract_id,
                "$model.lot_id" => $lot_id,
                "$model.product_category_id" => $product_category_id
            ),
            'fields' => array("$model.product_id", "SUM($model.quantity) as quantity"),
            'group' => array("$model.product_id")
        );

        $this->loadModel($model);
        $productions = $this->$model->find('all', $condition);
        //initialization
        foreach ($productions as $value) {
            $data[$model][$value[$model]['product_id']] = $value[0]['quantity'];
            $product_ids[$value[$model]['product_id']] = $value[$model]['product_id'];
        }
        //end inspection
        //production product sum with filter options
        $model = "Procurement";
        $condition = array(
            'conditions' => array(
                "$model.contract_id" => $contract_id,
                "$model.lot_id" => $lot_id,
                "$model.product_category_id" => $product_category_id
            ),
            'fields' => array("$model.product_id", "SUM($model.quantity) as quantity"),
            'group' => array("$model.product_id")
        );

        $this->loadModel($model);
        $procurements = $this->$model->find('all', $condition);

        //initalization
        foreach ($procurements as $value) {
            $data[$model][$value[$model]['product_id']] = $value[0]['quantity'];
            $product_ids[$value[$model]['product_id']] = $value[$model]['product_id'];
        }

        //end production summation 
        //sql query initialization 
        $sql_product_update = '';
        $sql_new_production_entry = '';
        foreach ($product_ids as $value) {

            #Product Balance
            $product_id = $value;
            $update_qty = ($data['Production'][$product_id] > 0) ? $data['Production'][$product_id] : 0;

            $pro_bal = $data['Procurement'][$product_id] - $update_qty;
            $pro_bal = $new_qty = ($pro_bal > 0) ? $pro_bal : 0;
            if ($pro_bal > 0) {
                // All production production  List with filter options which will be updated
                $model = "Procurement";
                $condition = array(
                    'conditions' => array(
                        "$model.contract_id" => $contract_id,
                        "$model.lot_id" => $lot_id,
                        "$model.product_category_id" => $product_category_id,
                        "$model.product_id" => $product_id
                    ),
                    'order' => array("$model.quantity" => "DESC")
                );

                $this->$model->recursive = -1;
                $procurement_all = $this->$model->find('all', $condition);

                foreach ($procurement_all as $value) {
                    $id = $value[$model]['id'];
                    
                    $uom = $value[$model]['uom'];
                    $unit_weight = $value[$model]['unit_weight'];
                    $unit_weight_uom = $value[$model]['unit_weight_uom'];

                    $planned_arrival_date = $value[$model]['planned_arrival_date'];
                    $actual_arrival_date = $value[$model]['actual_arrival_date'];
                    $quantity = $value[$model]['quantity'];

                    //check balance quantity and production quantity of single row
                    if ($quantity >= $pro_bal) {
                        $update_qty = $quantity - $pro_bal;
                        //update product qty
                        $sql_product_update.="UPDATE procurements SET quantity =$update_qty WHERE id=  $id;";
                        $pro_bal = $quantity - $pro_bal;
                        break;
                    } else {
                        $pro_bal = $pro_bal - $quantity;
                        $sql_product_update.="UPDATE procurements SET quantity =0 WHERE id=  $id;";
                    }
                }
                #check the existing new lot and product in production table
                $option = array(
                    'conditions' => array(
                        'Procurement.contract_id' => $contract_id,
                        'Procurement.lot_id' => $transfer_lot, //new lot id where product will be transfered
                        'Procurement.product_category_id' => $product_category_id,
                        'Procurement.product_id' => $product_id
                    )
                );
                $this->Procurement->recursive = -1;
                $chek_new_pro_with_lot = $this->Procurement->find('first', $option);

                if ($chek_new_pro_with_lot) {//update
                    $new_qty = $chek_new_pro_with_lot['Procurement']['quantity'] + $new_qty; //addition 
                    $id = $chek_new_pro_with_lot['Procurement']['id'];
                    if ($id) {
                        $sql_product_update.="UPDATE procurements SET quantity= $new_qty WHERE id=$id;";
                    }
                } else { //new product entry with balance quantity
                    $sql_new_production_entry.="INSERT INTO procurements VALUES (NULL, '" . $contract_id . "', '" . $transfer_lot . "', '" . $product_category_id . "', '" . $product_id . "', '" . $new_qty . "', '" . $uom . "', '" . $unit_weight . "', '" . $unit_weight_uom . "', '" . $planned_arrival_date . "', '" . $actual_arrival_date . "', '','" . $UserID . "', '" . date('Y-m-d H:m:s') . "', '', '0000-00-00 00:00:00');";
                }
            }
        }
        //execute the query
        if($sql_product_update){
        $this->Production->query($sql_product_update);
        }
        if($sql_new_production_entry){
        $this->Production->query($sql_new_production_entry);
        }
        $this->redirect(array('action' => 'lot_transfer', $contract_id, $product_category_id, str_replace('/', '|', $lot_id), str_replace('/', '|', $transfer_lot)));
    }

    public function lot_transfer($contract_id = null, $product_category_id = null, $lot_id = null, $transfer_lot = null) {
        $lot_id = str_replace('|', '/', $lot_id);
        $transfer_lot = str_replace('|', '/', $transfer_lot);
        $user = $this->Session->read('UserAuth');
        $UserID = $user['User']['username'];

        if (!$contract_id || !$lot_id || !$product_category_id || !$transfer_lot) {
            $this->Session->setFlash(__('PO/LOT/Category input fields are required.Please, try again.'));
            $this->redirect($this->referer());
        }
        //production 
        $model = "Production";
        $condition = array(
            'conditions' => array(
                "$model.contract_id" => $contract_id,
                "$model.lot_id" => $lot_id,
                "$model.product_category_id" => $product_category_id
            ),
            'fields' => array("$model.product_id", "SUM($model.quantity) as quantity"),
            'group' => array("$model.product_id")
        );

        //$this->loadModel($model);
        $productions = $this->$model->find('all', $condition);
        foreach ($productions as $value) {
            $data[$model][$value[$model]['product_id']] = $value[0]['quantity'];
        }

        //LOT Products
        $model = "LotProduct";
        $condition = array(
            'conditions' => array(
                "$model.contract_id" => $contract_id,
                "$model.lot_id" => $lot_id,
                "$model.product_category_id" => $product_category_id
            ),
            'fields' => array("$model.product_id", "$model.quantity", "$model.id", "$model.product_category_id", "$model.product_id", "$model.uom", "$model.unit_weight", "$model.unit_weight_uom"),
            'group' => array("$model.product_id")
        );

        $this->loadModel($model);
        $lot_products = $this->$model->find('all', $condition);
        
        $sql_product_update='';
        $sql_new_production_entry='';
        
        foreach ($lot_products as $value) {

            $product_id = $value['LotProduct']['product_id'];
            $id = $value['LotProduct']['id'];
            $uom = $value['LotProduct']['uom'];
            $unit_weight = $value['LotProduct']['unit_weight'];
            $unit_weight_uom = $value['LotProduct']['unit_weight_uom'];

            #LOT Balance
            $pro_bal = $value['LotProduct']['quantity'] - $data['Production'][$product_id];
            $pro_bal = ($pro_bal > 0) ? $pro_bal : 0; 
            if ($pro_bal > 0) {
                $update_qty = ($data['Production'][$product_id] > 0) ? $data['Production'][$product_id] : 0;
                if ($id) {
                    $sql_product_update.="UPDATE lot_products SET quantity= $update_qty WHERE id=$id;";
                    #check the existing new lot and product
                    $option = array(
                        'conditions' => array(
                            'LotProduct.contract_id' => $contract_id,
                            'LotProduct.lot_id' => $transfer_lot, //new lot id where product will be transfered
                            'LotProduct.product_category_id' => $product_category_id,
                            'LotProduct.product_id' => $product_id
                        )
                    );
                    $this->LotProduct->recursive = -1;
                    $chek_new_pro_with_lot = $this->LotProduct->find('first', $option);
                    if ($chek_new_pro_with_lot) {//update
                        $new_qty = $chek_new_pro_with_lot['LotProduct']['quantity'] + $pro_bal; //addition 
                        $id = $chek_new_pro_with_lot['LotProduct']['id'];
                        if ($id) {
                            $sql_product_update.="UPDATE lot_products SET quantity= $new_qty WHERE id=$id;";
                        }
                    } else { //insert into lot products with lot no and quantity
                        $sql_new_production_entry.="INSERT INTO lot_products VALUES (NULL, '" . $contract_id . "', '" . $transfer_lot . "', '" . $product_category_id . "', '" . $product_id . "', '" . $pro_bal . "', '0', '0', '" . $uom . "', '" . $unit_weight . "', '" . $unit_weight_uom . "', '', '" . $UserID . "', '" . date('Y-m-d H:m:s') . "', '', '0000-00-00 00:00:00');";
                    }
                }
            }/* lot calculation end here */
        }
        //execute the query
        if($sql_product_update){
        $this->Production->query($sql_product_update);
        }
        if($sql_new_production_entry){
        $this->Production->query($sql_new_production_entry);
        }
        $this->redirect(array('action' => 'lot_transfer_success', $contract_id, $product_category_id, str_replace('/', '|', $lot_id), str_replace('/', '|', $transfer_lot)));
    }
    
    public function lot_transfer_success()
    {
        
    }

}
