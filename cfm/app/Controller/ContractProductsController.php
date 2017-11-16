<?php

App::uses('AppController', 'Controller');

/**
 * ContractProducts Controller
 *
 * @property ContractProduct $ContractProduct
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ContractProductsController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index($contract_id=null) {
        if ($this->request->is('post')) {
            if ($this->request->data['ContractProduct']['contract_id']) {
                $data['ContractProduct.contract_id'] = $this->request->data['ContractProduct']['contract_id'];
            }
            if ($this->request->data['ContractProduct']['currency']) {
                $data['ContractProduct.currency'] = $this->request->data['ContractProduct']['currency'];
            }
            if ($this->request->data['ContractProduct']['product_category_id']) {
                $data['ContractProduct.product_category_id'] = $this->request->data['ContractProduct']['product_category_id'];
            }
            if ($this->request->data['ContractProduct']['product_id']) {
                $data['ContractProduct.product_id'] = $this->request->data['ContractProduct']['product_id'];
            }
            if ($this->request->data['ContractProduct']['added_date_from'] && $this->request->data['ContractProduct']['added_date_to']) {
                $data["SUBSTR(ContractProduct.added_date,1,10) BETWEEN ? AND ?"] = array($this->request->data['ContractProduct']['added_date_from'], $this->request->data['ContractProduct']['added_date_to']);
            }
            if ($this->request->data['ContractProduct']['uom']) {
                $data['ContractProduct.uom'] = $this->request->data['ContractProduct']['uom'];
            }
        } 
        else if($contract_id){
            $data['ContractProduct.contract_id'] =$contract_id;
        }
        if($data){
        $this->ContractProduct->recursive = 0;
        $contractProducts = $this->ContractProduct->find('all', array('conditions' => array($data),'order'=>array('ContractProduct.product_id')));
        }

        $this->set(compact('contractProducts', 'data_view'));
        /* if($this->request->is('post')){
          $this->layout='ajax';
          $this->render('/elements/render/ajax_contract_product_search','ajax');
          } */
        //contract
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' =>'DESC'));
        $contracts = $this->Contract->find('list', $options);
        //currency
        $currencies = array('USD' => 'USD', 'BDT' => 'BDT');

        $uoms = array('MT' => 'MT', 'PCs' => 'PCs', 'SETS' => 'SETS');
        
        #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');

        $this->set(compact('lots', 'products', 'contracts', 'currencies', 'uoms','product_categories'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($contract_id = null) {
        if ($this->request->is('post')) {
            $this->layout = 'ajax';
            $this->beforeRender();
            #set added usr information
            $user = $this->Session->read('UserAuth');
            $UserID = $this->request->data['ContractProduct']['added_by'] = $user['User']['username'];
            #check duplicate product for same contract with product id and contract id
            $product_id = $this->request->data['ContractProduct']['product_id'];
            $contract_id = $this->request->data['ContractProduct']['contract_id'];
            $this->request->data['ContractProduct']['unit_weight']=(trim($this->request->data['ContractProduct']['unit_weight']))?$this->request->data['ContractProduct']['unit_weight']:"N/A";
            $this->request->data['ContractProduct']['unit_weight_uom']=(trim($this->request->data['ContractProduct']['unit_weight_uom']))?$this->request->data['ContractProduct']['unit_weight_uom']:"N/A";
            
            if(!$product_id||!$contract_id)
            {
                $this->Session->setFlash(__('The contract product could not be saved. Please, try again.'));
                return;
                exit;
                
            }
            $options = array('conditions' => array('ContractProduct.contract_id' => $contract_id, 'ContractProduct.product_id' => $product_id));
            $this->ContractProduct->recursive = -1;
            if ($this->ContractProduct->find('first', $options)) {
                $this->Session->setFlash(__('The contract product already added.Please, try again.'));
                $this->ContractProduct->recursive = 0;
                $options = array('conditions' => array('ContractProduct.contract_id' => $contract_id), 'order' => array('ContractProduct.product_id' =>'ASC'));
                $this->set('contractProducts', $this->ContractProduct->find('all', $options));
                $this->render('ajax_product', 'ajax');
            } else {
                $this->ContractProduct->create();
                if ($this->ContractProduct->save($this->request->data)) {
                    $this->Session->setFlash(__('The contract product has been saved.'));
                    $this->ContractProduct->recursive = 0;
                    $options = array('conditions' => array('ContractProduct.contract_id' => $contract_id), 'order' => array('ContractProduct.product_id' =>'ASC'));
                    $this->set('contractProducts', $this->ContractProduct->find('all', $options));
                    $this->render('ajax_product', 'ajax');
                } else {
                    $this->Session->setFlash(__('The contract product could not be saved. Please, try again.'));
                }
            }
        }
        if ($contract_id) {
            $option = array('conditions' => array('Contract.id' => $contract_id), 'fields' => array('Contract.id', 'Contract.contract_no'));
            $this->ContractProduct->Contract->recursive = -1;
            $contracts = $this->ContractProduct->Contract->find('first', $option);
        } else {
            return $this->redirect(array('controller' => 'contracts', 'action' => '/ '));
        }
        #prduct category
        $this->loadModel('ProductCategory');
        $productCategories = $this->ProductCategory->find('list');
        #uom list box
        $uoms = array(''=>'','MT' => 'MT', 'PCs' => 'PCs', 'SETS' => 'SETS');
        #uom of weing
        $unit_weight_uoms = array('N/A' => 'N/A', 'MT' => 'MT', 'Quintal' => 'Quintal', 'KG' => 'KG');
        #currency list box
        $currencies = array(''=>'','USD' => 'USD', 'BDT' => 'BDT');
        #resently added products with user 
        $user = $this->Session->read('UserAuth');
        $UserID = $this->request->data['ContractProduct']['added_by'] = $user['User']['username'];
        #find the contract products
        $this->ContractProduct->recursive = 0;
        $options = array('conditions' => array('ContractProduct.contract_id' => $contract_id), 'order' => array('ContractProduct.product_id' => 'ASC'));
        $this->ContractProduct->unbindModel(array('belongsTo' => array('Contract')));
        $contractProducts = $this->ContractProduct->find('all', $options);

        $this->set(compact('contracts', 'productCategories', 'uoms', 'currencies', 'contractProducts', 'unit_weight_uoms'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->ContractProduct->exists($id)) {
            throw new NotFoundException(__('Invalid contract product'));
        }
        if ($this->request->is(array('post', 'put'))) {

            if ((trim($this->request->data['ContractProduct']['quantity']) > 0 || trim($this->request->data['ContractProduct']['unit_price']) || trim($this->request->data['ContractProduct']['unit_weight'])) && trim($this->request->data['ContractProduct']['contract_id'])):
                $id = trim($this->request->data['ContractProduct']['id']);
                $quantity = trim($this->request->data['ContractProduct']['quantity']);
                $contract_id = trim($this->request->data['ContractProduct']['contract_id']);
                $product_id =$this->request->data['ContractProduct']['product_id'];
                $currency = trim($this->request->data['ContractProduct']['currency']);
                //check the lot size for this product
                $option1 = array(
                    'conditions' => array(
                        'LotProduct.product_id' => $id,
                        'LotProduct.contract_id' => $contract_id
                    ),
                    'fields' => array(
                        'SUM(LotProduct.quantity) as quantity'
                    )
                );
                $this->loadModel('LotProduct');
                $this->LotProduct->recursive = -1;
                $lot_quantity = $this->LotProduct->find('first', $option1);
                //echo '<pre>';print_r($lot_quantity);exit;
                $lot_quantity = ($lot_quantity[0]['quantity'] > 0) ? $lot_quantity[0]['quantity'] : 0;
                //save po qty
                $error = null;
                $this->ContractProduct->id = $this->request->data['ContractProduct']['id'];

                if ($lot_quantity <= $quantity)://if po qty is greater than lot size
                    $this->ContractProduct->saveField('quantity', $quantity);
                else:                    
                    $error = "<span style='color:red;'>PO. Qty is less than Lot Size!,Please try again!</span>";
                endif;
                
                $uom=trim($this->request->data['ContractProduct']['uom']);
                $this->ContractProduct->saveField('uom', $uom);
                
                $unit_price=(trim($this->request->data['ContractProduct']['unit_price']))?trim($this->request->data['ContractProduct']['unit_price']):0.000;
                $this->ContractProduct->saveField('unit_price', $unit_price);
                
                $this->ContractProduct->saveField('currency', $currency);
                
                $unit_weight=(trim($this->request->data['ContractProduct']['unit_weight']))?trim($this->request->data['ContractProduct']['unit_weight']):"N/A";
                $this->ContractProduct->saveField('unit_weight',$unit_weight);
                
                $unit_weight_uom=(trim($this->request->data['ContractProduct']['unit_weight_uom']))?trim($this->request->data['ContractProduct']['unit_weight_uom']):"N/A";
                $this->ContractProduct->saveField('unit_weight_uom',$unit_weight_uom);
                
                $this->loadModel('LotProduct');
                
                 //Lot Product update
                $sql="";
                $this->LotProduct->recursive=-1;
                $conditions=array(
                    'conditions'=>array(
                        'LotProduct.contract_id'=>$contract_id,
                        'LotProduct.product_id'=>$product_id
                    )
                );
                if($this->LotProduct->find('first',$conditions)){
                $sql.="UPDATE lot_products SET uom ='".$uom."',unit_weight='".$unit_weight."',unit_weight_uom='".$unit_weight_uom."' WHERE contract_id=$contract_id and product_id=$product_id;";
                }
                 $this->loadModel('Procurement');
                //procurement update
                $this->Procurement->recursive=-1;
                $conditions=array(
                    'conditions'=>array(
                        'Procurement.contract_id'=>$contract_id,
                        'Procurement.product_id'=>$product_id
                    )
                );
                if($this->Procurement->find('first',$conditions)){
                $sql.="UPDATE procurements SET uom ='".$uom."',unit_weight='".$unit_weight."',unit_weight_uom='".$unit_weight_uom."' WHERE contract_id=$contract_id and product_id=$product_id;";
                }
                
                
                
                 //Production update
                 $this->loadModel('Production');
                $this->Production->recursive=-1;
                $conditions=array(
                    'conditions'=>array(
                        'Production.contract_id'=>$contract_id,
                        'Production.product_id'=>$product_id
                    )
                );
                if($this->Production->find('first',$conditions)){
                $sql.="UPDATE productions SET uom ='".$uom."',unit_weight='".$unit_weight."',unit_weight_uom='".$unit_weight_uom."' WHERE contract_id=$contract_id and product_id=$product_id;";
                }
                 //Inspection update
                $this->loadModel('Inspection');
                $this->Inspection->recursive=-1;
                $conditions=array(
                    'conditions'=>array(
                        'Inspection.contract_id'=>$contract_id,
                        'Inspection.product_id'=>$product_id
                    )
                );
                if($this->Inspection->find('first',$conditions)){
                $sql.="UPDATE inspections SET uom ='".$uom."',unit_weight='".$unit_weight."',unit_weight_uom='".$unit_weight_uom."' WHERE contract_id=$contract_id and product_id=$product_id;";
                }
                
                 //Delivey update
                $this->loadModel('Delivery');
                $this->Delivery->recursive=-1;
                $conditions=array(
                    'conditions'=>array(
                        'Delivery.contract_id'=>$contract_id,
                        'Delivery.product_id'=>$product_id
                    )
                );
                if($this->Delivery->find('first',$conditions)){
                $sql.="UPDATE deliveries SET uom ='".$uom."',unit_price=$unit_price,currency='".$currency."',unit_weight='".$unit_weight."',unit_weight_uom='".$unit_weight_uom."' WHERE contract_id=$contract_id and product_id=$product_id;";
                }
                
                 //progressive Payment update
                $this->loadModel('ProgressivePayment');
                $this->ProgressivePayment->recursive=-1;
                $conditions=array(
                    'conditions'=>array(
                        'ProgressivePayment.contract_id'=>$contract_id,
                        'ProgressivePayment.product_id'=>$product_id
                    )
                );
                if($this->ProgressivePayment->find('first',$conditions)){
                $sql.="UPDATE progressive_payments SET uom ='".$uom."',unit_price=$unit_price,currency='".$currency."',unit_weight='".$unit_weight."',unit_weight_uom='".$unit_weight_uom."' WHERE contract_id=$contract_id and product_id=$product_id;";
                }
                 
                $this->ContractProduct->query($sql);
                //update modifiction by information
                $user = $this->Session->read('UserAuth');
                $this->ContractProduct->saveField('modified_by', $user['User']['username']);
                $this->ContractProduct->saveField('modified_date', date('Y-m-d h:i:s'));
                
                if(!$error){
                    $this->Session->setFlash(__('The contract product has been saved.'));
                }
                else{
                    $this->Session->setFlash(__("$error"));
                }
            endif;
            return $this->redirect(array('action' => '/ '));
        } else {
            $options = array('conditions' => array('ContractProduct.' . $this->ContractProduct->primaryKey => $id));
            $this->request->data = $this->ContractProduct->find('first', $options);
            $product_id = $this->request->data['ContractProduct'] ['product_id'];
        }
        $productCategories = $this->ContractProduct->ProductCategory->find('list');
        $products = $this->ContractProduct->Product->find('list');
        $contracts = $this->ContractProduct->Contract->find('list');
        $uoms = array('MT' => 'MT', 'PCs' => 'PCs', 'SETS' => 'SETS');
        $currencies = array('USD' => 'USD', 'BDT' => 'BDT');
        $unit_weight_uoms = array('N/A' => 'N/A', 'MT' => 'MT', 'Quintal' => 'Quintal', 'KG' => 'KG');
        $this->set(compact('contracts', 'products', 'currencies', 'uoms', 'productCategories', 'product_id', 'unit_weight_uoms'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {                         
        $this->ContractProduct->id =$id;
        if (!$this->ContractProduct->exists()) {
            throw new NotFoundException(__('Invalid contract product'));
        }
        $this->ContractProduct->recursive=-1;
        $cp=  $this->ContractProduct->findById($id);
        
        $option=array(
            'conditions'=>array(
                'LotProduct.contract_id'=>$cp['ContractProduct']['contract_id'],
                'LotProduct.product_id'=>$cp['ContractProduct']['product_id']
            )
        );                        
        $this->loadModel('LotProduct');
        if($this->LotProduct->find('first',$option)) //if lot product is defined with this product then not allow to delete
        {
         $this->Session->setFlash(__('The contract product could not be deleted because already lot size has defined with this product. Please, try again.'));   
         return $this->redirect($this->referer());
        }
        
        //$this->request->allowMethod('post', 'delete');
        if ($this->ContractProduct->delete()) {
            /**
                 #Now it po amount edit is manual so it is block
                 #update contract amount by currency wise
                 $contract_id=$cp['ContractProduct']['contract_id'];
                 $currency=$cp['ContractProduct']['currency'];
                if ($contract_id && $currency) {
                    $option = array('conditions' => array('ContractProduct.contract_id' => $contract_id, 'ContractProduct.currency' => $currency), 'fields' => array('SUM(ContractProduct.quantity*ContractProduct.unit_price) as amount'));
                    $this->ContractProduct->recursive = -1;
                    $cproduct = $this->ContractProduct->find('first', $option);
                    $amount = $cproduct[0]['amount'];
                    //update contract amount
                    $this->loadModel('Contract');
                    $this->Contract->id = $contract_id;
                    switch ($currency) {
                        case 'BDT':
                            $this->Contract->saveField('contract_value_bdt', $amount);
                            break;
                        case 'USD':
                            $this->Contract->saveField('contract_value_usd', $amount);
                            break;
                        default:
                            break;
                    }
                }*/
            
            $this->Session->setFlash(__('The contract product has been deleted.'));
        } else {
            $this->Session->setFlash(__('The contract product could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());                
    }

    public function getProductByContract() {
        $this->layout = 'ajax';
        //$this->autoRender=false;
        $model = $this->request->params['named']['model'];
        $contract_id = $this->request->data[$model]['contract_id'];

        if ($contract_id) {
            $options = array('conditions' => array('ContractProduct.contract_id' => $contract_id), 'order' => array('ContractProduct.product_id' => 'ASC'));
            $cproducts = $this->ContractProduct->find('all', $options);
            //$cproducts = $this->LotProduct->query("SELECT p.name,p.id FROM products p,contract_products cp where p.id=cp.product_id and cp.contract_id=$contract_id");
            if ($cproducts) {
                $products = array();
                foreach ($cproducts as $key => $value) {
                    $products[$value['Product']['id']] = $value['Product']['name'];
                }
            }
        }
        $this->set('products', $products);        
    }

    public function getContractProductInfo() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $contract_id = $this->request->data['contract_id'];
        $product_id = $this->request->data['product_id'];

        $cproducts = array();
        if ($contract_id && $product_id):
            $options = array('conditions' => array('ContractProduct.contract_id' => $contract_id, 'ContractProduct.product_id' => $product_id), 'fields' => array('ContractProduct.uom', 'ContractProduct.unit_weight','ContractProduct.unit_weight_uom', 'ContractProduct.unit_price', 'ContractProduct.currency', 'ContractProduct.quantity'),'order'=>array('ContractProduct.product_id'=>'ASC'));
            $cproducts = $this->ContractProduct->find('first', $options);
            //calculated prevoious lot product qty by contract
            $this->loadModel('LotProduct');
            $options = array('conditions' => array('LotProduct.contract_id' => $contract_id, 'LotProduct.product_id' => $product_id), 'fields' => array('SUM(LotProduct.quantity) as lot_qty'));
            $lot_qty = $this->LotProduct->find('first', $options);
            $lot_qty = ($lot_qty[0] ['lot_qty'] > 0) ? $lot_qty[0]['lot_qty'] : 0;
        endif;
        if ($cproducts):
            echo $cproducts['ContractProduct']['uom'] . '%' . $cproducts['ContractProduct']['unit_weight'] . '%' . $cproducts['ContractProduct']['unit_price'] . '%' . $cproducts['ContractProduct']['currency'] . '%' . $cproducts['ContractProduct']['quantity'] . '%' . $lot_qty.'%'.$cproducts['ContractProduct']['unit_weight_uom'];
        else:
            echo '' . '%' . '' . '%' . '' . '%' . '' . '%' . '' . '%' .'' . '%' . '';
        endif;
    }

    public function getAllProductByContract() {
        //$this->autoRender=false;
        $model = $this->request->params['named']['model'];
        $contract_id = $this->request->data[$model]['contract_id'];
        if ($contract_id) {
            $options = array('conditions' => array('ContractProduct.contract_id' => $contract_id), 'order' => array('ContractProduct.product_id' => 'ASC'));
            $this->ContractProduct->recursive = 0;
            //$this->ContractProduct->unbindModel(array('belongsTo'=>array('Contract','ProductCategory')));
            $contractProducts = $this->ContractProduct->find('all', $options);
        }
        $this->set(compact('contractProducts', 'contract_id'));
        $this->layout = 'ajax';
    }

    public function getProductCategoryByContract() {
        $this->layout = 'ajax';
        $pcategorys = array();
        $model = $this->request->params['named']['model'];
        $contract_id = $this->request->data[$model]['contract_id'];
        if ($contract_id) {
            $options = array('conditions' => array('ContractProduct.contract_id' => $contract_id), 'order' => array('ContractProduct.id' => 'DESC'));
            $this->ContractProduct->recursive = 0;
            $this->ContractProduct->unbindModel(array('belongsTo' => array('Contract', 'Product')));
            $pcats = $this->ContractProduct->find('all', $options);
            foreach ($pcats as $key => $value) {
                $pcategorys[$value['ProductCategory'] ['id']] = $value['ProductCategory']['name'];
            }
        }
        $this->set(compact('pcategorys'));
    }
   #get contract product by contract id and category 
    public function getContractProductByCategory()
    {
        $this->layout = 'ajax';
        $this->autoRender=false;
        $contract_id=$this->request->data['contract_id'];
        $product_category_id=$this->request->data['product_category_id'];
        #product options
        $option=array(
            'conditions'=>array(
                'ContractProduct.contract_id'=>$contract_id,
                'ContractProduct.product_category_id'=>$product_category_id,
            )
        );
        $this->ContractProduct->unbindModel(array('belongsTo'=>array('Contract','ProductCategory')));
        $contract_products=$this->ContractProduct->find('all',$option);
        $option='<option value="">Choose a Product</option>';
        foreach ($contract_products as $value):           
         $option.='<option value="'.$value['Product']['id'].'">'.$value['Product']['name'].'</option>';
       endforeach; 
        echo $option;        
    }
    
    public function import_contract_product_by_csv()
    {
         if ($this->request->is('post')) {
            
                if($this->request->data['ContractProduct']['contract_id']&&$this->request->data['ContractProduct']['import_contract_product_by_csv'])
                {
                  #set the contrct id
                  $contract_id=$this->request->data['ContractProduct']['contract_id'];  
                  #check the csv files type
                  $csv_mimetypes = array(
                                        'text/csv',
                                        'text/plain',
                                        'application/csv',
                                        'text/comma-separated-values',
                                        'application/excel',
                                        'application/vnd.ms-excel',
                                        'application/vnd.msexcel',
                                        'text/anytext',
                                        'application/octet-stream',
                                        'application/txt',
                                    );  
                  if(in_array($this->request->data['ContractProduct']['import_contract_product_by_csv']['type'], $csv_mimetypes)&&$this->request->data['ContractProduct']['import_contract_product_by_csv']['error']==0)  
                  {
                       
                      $user = $this->Session->read('UserAuth');
                      $UserID = $user['User']['username'];
                      $row = 1;
                    if (($handle = fopen($this->request->data['ContractProduct']['import_contract_product_by_csv']['tmp_name'], "r")) !== FALSE) {
                        /*
                        #read product and category from session
                        $this->loadModel('Product');    
                        $products=$this->Product->find('list');
                        foreach ($products as $key=>$value) 
                        {
                            $product_name[$value]=$key;
                        }
                        #echo '<pre>';print_r($product_name);exit;
                        $this->loadModel('ProductCategory');
                        $product_categories=$this->ProductCategory->find('list');
                        foreach ($product_categories as $key=>$value)
                        {
                            $category_name[$value]=$key;
                        }
                        #echo '<pre>';print_r($product_categories);exit;                          
                         */
                        $productid=array();
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            
                            if($row==1)
                            {
                                $row++;
                                continue;                                
                            }                            
                            $row++;
                            #echo '<pre>';print_r($data);exit;
                            if(!is_numeric($data[0])||!$data[0]||!$data[3]||!is_numeric($data[3])||!$data[4]||!is_numeric($data[4])||!is_numeric($data[6])||$data[6]<=0)
                            {
                                $this->Session->setFlash(__('1.Product Name/Category/quantity/unit price  is wrong format!,Please Try Again'));
                                $this->redirect($this->referer());                                
                            }
                            $productid[]=$data[0];
                            $savaData[]=array(
                                    'ContractProduct'=>array(
                                    'contract_id'=>$this->request->data['ContractProduct']['contract_id'],
                                    'product_id'=>$data[0],
                                    'product_category_id'=>$data[3],
                                    'quantity'=>$data[4],
                                    'uom'=>$data[5],
                                    'unit_price'=>$data[6],
                                    'currency'=>$data[7],
                                    'unit_weight'=>$data[8],
                                    'unit_weight_uom'=>$data[9],
                                    'added_by'=>$UserID,
                                    'added_date'=>date('Y-m-d H:i:s')                                     
                                )
                            );
                            
                        }
                        fclose($handle);
                        #echo '<pre>';print_r($savaData);
                        # Duplicates
                        $unique=array_unique( array_diff_assoc($productid, array_unique($productid)));
                        if($unique)
                        {
                          $this->Session->setFlash(__('2.Duplicate Product is found in CSV files!,Please Try Again'));
                          $this->redirect($this->referer());   
                        }
                        
                        #check the duplicate product in database
                        $option=array(
                            'conditions'=>array(
                                'ContractProduct.contract_id'=>$this->request->data['ContractProduct']['contract_id'],
                                'ContractProduct.product_id'=>$productid
                            )
                        );
                        $this->ContractProduct->recursive=-1;
                        $duplicates=  $this->ContractProduct->find('all',$option);
                         if($duplicates)
                        {
                          $this->Session->setFlash(__('7.Duplicate Product is found in Same Contract!,Please Try Again'));
                          $this->redirect($this->referer());   
                        }
                        #save the product to contract
                        
                        $this->ContractProduct->create();
                        if($this->ContractProduct->saveMany($savaData))
                        {
                            $this->Session->setFlash(__('3. PO products has been saved successfully'));
                            $this->redirect(array('controller'=>'contract_products','action'=>'index/'.$contract_id)); 
                        }
                        else{
                            $this->Session->setFlash(__('4.There is a problem while saving requested data!,Please Try Again'));
                                $this->redirect($this->referer());
                        }
                        
                    }
                      
                  }else{
                    $this->Session->setFlash(__('5.Sorry, mime type not allowed!,Please Try Again'));
                    $this->redirect($this->referer());
                }
                    
                }
                else{
                    $this->Session->setFlash(__('6.Please choose PO and CSV files!,Please Try Again'));
                    $this->redirect($this->referer());
                }
      
         }
        #contract list box       
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $this->Contract->recursive = -1;
        $contracts = $this->Contract->find('list', $options); 
        
        $this->set(compact('contracts'));
    }

}
