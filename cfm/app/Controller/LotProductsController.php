<?php

App::uses('AppController', 'Controller');

/**
 * LotProducts Controller
 *
 * @property LotProduct $LotProduct
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class LotProductsController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index($contract_id=null,$lot_id=null) {
          
        if($this->request->is('post')){
            if($this->request->data['LotProduct']['contract_id']){
                $option['LotProduct.contract_id']=$this->request->data['LotProduct']['contract_id'];
            }
            if($this->request->data['LotProduct']['lot_id']){
                $option['LotProduct.lot_id']=$lot_id=trim($this->request->data['LotProduct']['lot_id']);
               
            }
             if($this->request->data['LotProduct']['product_category_id']){
                $option['LotProduct.product_category_id']=$this->request->data['LotProduct']['product_category_id'];
            }
            $option=array(
                'conditions'=>$option
            );
            //echo '<pre>';print_r($option);exit;
            $this->LotProduct->recursive = 0;
            $this->LotProduct->unbindModel(array('belongsTo'=>array('Contract')));

            $lotProducts=$this->LotProduct->find('all',$option);
        
        }
        else if($contract_id){
             $lot_id=str_replace('|','/',$lot_id);
             $option['LotProduct.contract_id']=$contract_id;
             $option['LotProduct.lot_id']=$lot_id;
             $option=array(
                'conditions'=>$option
            );
             
             $lotProducts=$this->LotProduct->find('all',$option);
        }
        #contract list box
        $this->loadModel('Contract');
        $option1=array(
            'fields'=>array(
                'id','contract_no'
            ),
            'order'=>array(
                'Contract.id'=>"DESC"
            )
        );
        $contracts=  $this->Contract->find('list',$option1);
        #Lot list box
        if(trim($this->request->data['LotProduct']['contract_id'])||$contract_id):             
            $option2=array(
                'conditions'=>array(
                    'LotProduct.contract_id'=>  isset($this->request->data['LotProduct']['contract_id'])?$this->request->data['LotProduct']['contract_id'] :$contract_id
                ),
                'fields'=>array(
                    'lot_id','lot_id'
                )
            ); 
        $lots=  $this->LotProduct->find('list',$option2);
        endif;
        
                #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');
            
        $this->set(compact('lotProducts','contracts','lots','lot_id','contract_id','product_categories'));
    }

    public function add($lot_id=null) {
        //resently added products        
        $user = $this->Session->read('UserAuth');
        $UserID = $this->request->data['LotProduct']['added_by'] = $user['User']['username'];
        $this->LotProduct->recursive = 0;

        if ($this->request->is('post')&&trim($this->request->data['LotProduct']['quantity'])>0) {
          
            $this->LotProduct->create();
            //check duplicate product in same lot no
            $contract_id = $this->request->data['LotProduct']['contract_id'];
            $lot_id = $this->request->data['LotProduct']['lot_id']; 
            $product_id = $this->request->data['LotProduct']['product_id'];
            $quantity=trim($this->request->data['LotProduct']['quantity']);
            
            if(!$contract_id||!$lot_id||!$product_id||!$quantity)
            {
                $this->Session->setFlash(__('The lot product could not be saved Due to Required information is missing. Please, try again.'));
                $this->redirect(array('controller'=>'lots','action'=>'index'));
            }
            
            /***********check lot size with po size ***********/
            #calculate lot product size with current size
            $option1=array(
                'conditions'=>array(
                    'LotProduct.contract_id'=>$contract_id,
                    'LotProduct.product_id'=>$product_id
                ),
                'fields'=>array(
                    'SUM(LotProduct.quantity) as quantiy'
                )
            );
            $previous_lot_qty=  $this->LotProduct->find('first',$option1);
            $previous_lot_qty=($previous_lot_qty[0]['quantiy'])?$previous_lot_qty[0]['quantiy']:0;
            $quantity+=$previous_lot_qty;
            #/calculate lot product size with current size
            
            #calculate po product size
             $option2=array(
                'conditions'=>array(
                    'ContractProduct.contract_id'=>$contract_id,
                    'ContractProduct.product_id'=>$product_id
                ),
                'fields'=>array(
                    'ContractProduct.quantity'
                )
            );
            $this->loadModel('ContractProduct'); 
            $po_size=  $this->ContractProduct->find('first',$option2);
            $po_size=($po_size['ContractProduct']['quantity'])?$po_size['ContractProduct']['quantity']:0;
            
            //check duplicate lot product
             $option = array('conditions' => array('LotProduct.contract_id' => $contract_id, 'LotProduct.lot_id' => $lot_id, 'LotProduct.product_id' => $product_id));
             $this->LotProduct->recursive = -1;

                $this->layout = 'ajax'; 
            #/calculate po product size
            if($po_size<$quantity)
            {
                $options = array('conditions' => array('LotProduct.contract_id' => $contract_id,'LotProduct.lot_id'=>$lot_id), 'order' => array('LotProduct.lot_id' => 'DESC'));
                $this->LotProduct->recursive =0;
                $this->LotProduct->unbindModel(array('belongsTo'=>array('Contract'))) ;
                $lotProducts=$this->LotProduct->find('all', $options);
                $this->set(compact('lotProducts'));
                //return $this->redirect(array('action' => 'lot_wise_products_ajax', $ContractID));
                $this->render('lot_wise_products_ajax','ajax');
                 
            }
            /*********** /check lot size with po size ***********/
          else if ($this->LotProduct->find('first', $option)) {
                $this->Session->setFlash(__('This lot product Exist. Please, try again.'));
                $options = array('conditions' => array('LotProduct.contract_id' => $contract_id,'LotProduct.lot_id'=>$lot_id), 'order' => array('LotProduct.lot_id' => 'DESC'));
                $this->LotProduct->recursive =0;
                $this->LotProduct->unbindModel(array('belongsTo'=>array('Contract'))) ;
                $lotProducts=$this->LotProduct->find('all', $options);
                $this->set(compact('lotProducts'));
                //return $this->redirect(array('action' => 'lot_wise_products_ajax', $ContractID));
                $this->render('lot_wise_products_ajax','ajax');
                
            } 
            else if($this->LotProduct->save($this->request->data)) {
                    $this->Session->setFlash(__('The lot product has been saved.'));
                    $options = array('conditions' => array('LotProduct.contract_id' => $contract_id,'LotProduct.lot_id'=>$lot_id), 'order' => array('LotProduct.lot_id' => 'DESC'));
                    $this->LotProduct->recursive =0;
                    $this->LotProduct->unbindModel(array('belongsTo'=>array('Contract'))) ;
                    $lotProducts=$this->LotProduct->find('all', $options);
                    $this->set(compact('lotProducts'));
                    //return $this->redirect(array('action' => 'lot_wise_products_ajax', $ContractID));
                    $this->render('lot_wise_products_ajax','ajax');                    
                } else {
                    $this->Session->setFlash(__('The lot product could not be saved. Please, try again.'));
                }
            }
        
        if($lot_id):
        $option=array('conditions'=>array('Lot.id'=>$lot_id));    
        $this->loadModel('Lot');        
        $lots = $this->Lot->find('first',$option);
        #echo '<pre>';print_r($lots);exit;
        $this->loadModel('ContractProduct');
        $contract_id=$lots['Lot']['contract_id'];
        $option=array('conditions'=>array('ContractProduct.contract_id'=>$contract_id)); 
       $this->ContractProduct->unbindModel(array('belongsTo'=>array('Contract')));
        $contractProducts = $this->ContractProduct->find('all',$option);
        //echo '<pre>';print_r($contractProducts);exit;
        $products=array();
        foreach ($contractProducts as $value)
        {
         $products[$value['Product']['id']]= $value['Product']['name'];  
         $product_category[$value['ProductCategory']['id']]= $value['ProductCategory']['name'];
        }
       else:
            $this->redirect(array('controller'=>'lots','action'=>'index'));
        endif;
       
         

        $options = array('conditions' => array('LotProduct.contract_id' => $contract_id,'LotProduct.lot_id'=>$lots['Lot']['lot_no']), 'order' => array('LotProduct.lot_id' => 'DESC'));
        $this->LotProduct->unbindModel(array('belongsTo'=>array('Contract'))) ;
        $lotProducts=$this->LotProduct->find('all', $options);
        #echo '<pre>';print_r($options);exit;
        
        $this->set(compact('lots', 'products', 'contracts','contractProducts','lotProducts','product_category'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */

      public function edit($id = null) {
      if (!$this->LotProduct->exists($id)) 
          {
            throw new NotFoundException(__('Invalid lot product'));
      }
      if ($this->request->is(array('post', 'put')))
        {
              $id          =  trim($this->request->data['LotProduct']['id']);
              $contract_id =  trim($this->request->data['LotProduct']['contract_id']);
              $product_id  =  trim($this->request->data['LotProduct']['product_id']);
              $quantity    =  trim($this->request->data['LotProduct']['quantity']);
              //echo '<pre>';print_r($this->request->data);exit;
              if($this->LotProduct->exists($id)): #check lot product exiting
                 #find the contract / po qty with is product 
                  $option1=array(
                      'conditions'=>array(
                          'ContractProduct.contract_id'=>$contract_id,
                          'ContractProduct.product_id'=>$product_id,
                      )
                  );
                  $this->loadModel('ContractProduct');
                  $this->ContractProduct->recursive=-1;
                  $con_pro_qty=$this->ContractProduct->find('first',$option1);
                  $con_pro_qty=$con_pro_qty['ContractProduct']['quantity'];
                  #lot product calculation and explode editing record id
                  $option2=array(
                      'conditions'=>array(
                          'LotProduct.contract_id'=>$contract_id,
                          'LotProduct.product_id'=>$product_id,
                          'LotProduct.id NOT LIKE'=>$id
                      ),
                      'fields'=>array(
                          'SUM(LotProduct.quantity) as quantity'
                      )
                  );
                  $this->LotProduct->recursive=-1;
                  $previous_lot_qty=  $this->LotProduct->find('first',$option2);
                  $previous_lot_qty=($previous_lot_qty[0]['quantity']>0)?$previous_lot_qty[0]['quantity']:0;
                  $previous_lot_qty+=$quantity;
                  #compare lot qty with po qty
                  if($previous_lot_qty<=$con_pro_qty):
                       $this->LotProduct->id=$id;
                       if($this->LotProduct->saveField('quantity', $quantity, false)):#check successfully saved lot qty
                       $this->Session->setFlash(__('The lot product quantity has been saved.')); 
                       
                       else:
                           $this->Session->setFlash(__('There was problem while saving lot product qty!.Please try Again'));     
                       endif; #/check successfully saved lot qty
                       else:
                           $this->Session->setFlash(__("The lot size($previous_lot_qty) should not greater than po size ($con_pro_qty) ."));  
                  endif;#/compare lot qty with po qty                  
                 
              endif; #/check lot product exiting
                     $options = array('conditions' => array('LotProduct.' . $this->LotProduct->primaryKey => $id));
                     $this->request->data = $this->LotProduct->find('first', $options);
      } 
      else
          {
            $options = array('conditions' => array('LotProduct.' . $this->LotProduct->primaryKey => $id));
            $this->request->data = $this->LotProduct->find('first', $options);
         }
       
      }
     
    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null,$product_id = null, $lot_id = null) {
        
        $this->LotProduct->id = $id;         
        if (!$this->LotProduct->exists()) {
            throw new NotFoundException(__('Invalid lot product'));
        }
        #if production of the lot product it does not delete
        if(!$product_id||!$lot_id):
            $this->Session->setFlash(__('There was problem while executing your request. Please, try again.'));
            return $this->redirect($this->referer());
        endif;
         #option to check the production 
        $lot_id=str_replace("||","/",$lotProduct['LotProduct']['lot_id']);
        $option1=array(
            'conditons'=>array(
                'LotProduct.lot_id'=>$lot_id,
                'LotProduct.product_id'=>$product_id
            )
        );
        $this->loadModel('Production');
        $this->Production->recursive=-1;
        if($this->Production->find('first',$option1)):
          $this->Session->setFlash(__('Already there is a product that lot product. Please, try again.'));
          return $this->redirect($this->referer());  
        endif;
        
       // $this->request->allowMethod('post', 'delete');
        if ($this->LotProduct->delete()) {
            $this->Session->setFlash(__('The lot product has been deleted.'));
        } else {
            $this->Session->setFlash(__('The lot product could not be deleted. Please, try again.'));
        }
        return $this->redirect($this->referer());
    }

    public function getLotByContract() {
        //$this->autoRender=false;
        $model = $this->request->params['named']['model'];
        $contract_id = $this->request->data[$model]['contract_id'];

        if ($contract_id) {
            $options = array('conditions' => array('LotProduct.contract_id' => $contract_id), 'order' => array('LotProduct.id' => 'DESC'));
            $this->LotProduct->recursive = -1;
            $clots = $this->LotProduct->find('all', $options);
            //$cproducts = $this->LotProduct->query("SELECT p.name,p.id FROM products p,contract_products cp where p.id=cp.product_id and cp.contract_id=$contract_id");
            if ($clots) {
                $lots = array();
                foreach ($clots as $key => $value) {
                    $lots[$value['LotProduct']['lot_id']] = $value['LotProduct']['lot_id'];
                }
            }
        }
        $this->set('lots', $lots);
        $this->layout = 'ajax';
    }

    public function getProductByLot() {
        //$this->autoRender=false;
        $model = $this->request->params['named']['model'];
        $lot_id = $this->request->data[$model]['lot_id'];

        if ($lot_id) {
            $options = array('conditions' => array('LotProduct.lot_id' => $lot_id), 'order' => array('LotProduct.id' => 'DESC'));
            //$this->LotProduct->recursive=-1;
            $cproducts = $this->LotProduct->find('all', $options);
            //$cproducts = $this->LotProduct->query("SELECT p.name,p.id FROM products p,contract_products cp where p.id=cp.product_id and cp.contract_id=$contract_id");
            if ($cproducts) {
                $products = array();
                foreach ($cproducts as $key => $value) {
                    $products[$value['Product']['id']] = $value['Product']['name'];
                }
            }
        }
        $this->set('products', $products);
        $this->layout = 'ajax';
    }

    public function getAllProductByLot() {
        //$this->autoRender=false;
        //echo '<pre>';print_r($this->request->params);exit;
        $model = $this->request->params['named']['model'];
        $lot_id = $this->request->data[$model]['lot_id'];
        if ($lot_id) {
            $options = array('conditions' => array('LotProduct.lot_id' => $lot_id), 'order' => array('LotProduct.id' => 'DESC'));
            $this->LotProduct->recursive = 0;
            $contractProducts = $this->LotProduct->find('all', $options);
        }
        $this->set(compact('contractProducts', 'lot_id'));
        $this->layout = 'ajax';
    }

    public function getAllProductByContractLotCurrency() {
        $contract_id = $this->request->params['named']['contract_id'];
        $lot_id = $this->request->data['ProgressivePayment']['lot_id'];
        $currency = $this->request->params['named']['currency'];

        if ($contract_id && $lot_id && $currency) {
            $options = "SELECT distinct(cp.product_id) as id,(select name from products p where p.id=cp.product_id) name FROM contract_products as cp,lot_products lp WHERE lp.contract_id=cp.contract_id and lp.contract_id=$contract_id and lp.lot_id='".$lot_id."' and cp.currency='" . $currency . "' ";
            $products = $this->LotProduct->query($options);
        }
        // echo '<pre>';print_r($products);exit;
        $this->set(compact('products'));
        $this->layout = 'ajax';
    }
    
    
    //
    public function __getLotProducts(&$option) {
      /*  $option=array();
        if ($contract_id) {
            $option['LotProduct.contract_id'] = $contract_id;
        }
        if ($lot_id) {
            $option['LotProduct.lot_id'] = $lot_id;
        }*/
        if(empty($option))
        {
            return '';
        }
        $condition = array('conditions' => array($option), 'fields' => array('SUM(LotProduct.quantity) as quantity', 'LotProduct.lot_id', 'LotProduct.uom', 'LotProduct.unit_weight','LotProduct.unit_weight_uom','LotProduct.product_category_id', 'LotProduct.product_id','ProductCategory.name',  'Product.name', 'LotProduct.lot_id', /* 'Contract.contract_no' */), 'group' => array('LotProduct.contract_id', 'LotProduct.lot_id', 'LotProduct.product_id'));
        return $this->LotProduct->find('all', $condition);
    }
    
     public function import_lot_product_by_csv()
    {
         if ($this->request->is('post')) {
            
                if($this->request->data['LotProduct']['contract_id']&&$this->request->data['LotProduct']['import_contract_product_by_csv']&&$this->request->data['LotProduct']['lot_id'])
                {
                 #set contract_id and lot id
                 $lot_id=$this->request->data['LotProduct']['lot_id'];
                 $contract_id=$this->request->data['LotProduct']['contract_id'];   
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
                  if(in_array($this->request->data['LotProduct']['import_contract_product_by_csv']['type'], $csv_mimetypes)&&$this->request->data['LotProduct']['import_contract_product_by_csv']['error']==0)  
                  {
                       
                      $user = $this->Session->read('UserAuth');
                      $UserID = $user['User']['username'];
                      $row = 1;
                    if (($handle = fopen($this->request->data['LotProduct']['import_contract_product_by_csv']['tmp_name'], "r")) !== FALSE) {
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
                        $this->loadModel('ContractProduct');
                        
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            
                            if($row==1)
                            {
                                $row++;
                                continue;                                
                            }                            
                            $row++;
                            #echo '<pre>';print_r($data);exit;
                            if(!is_numeric($data[0])||!$data[0]||!$data[3]||!is_numeric($data[3])||!$data[4]||!is_numeric($data[4]))
                            {
                                $this->Session->setFlash(__('3.Product/Category/Quantity is wrong format!,Please Try Again'));
                                $this->redirect($this->referer());
                                
                            }
                             #check the product in contract
                            $option=array(
                            'conditions'=>array(
                                'ContractProduct.contract_id'=>$this->request->data['LotProduct']['contract_id'],
                                'ContractProduct.product_id'=>$data[0]
                            ),
                           'fields'=>array(
                               'ContractProduct.quantity',
                               'ContractProduct.product_id'
                           )
                            );
                             
                            if(!$this->ContractProduct->find('first',$option))
                            {
                                $this->Session->setFlash(__('7.Product of id '.$data[0].' is not found in contract !,Please Try Again'));
                                $this->redirect($this->referer());   
                            }
                            
                            
                            #check the duplicate product in same lot
                            $option=array(
                            'conditions'=>array(
                                'LotProduct.product_id'=>$data[0],
                                'LotProduct.lot_id'=>$this->request->data['LotProduct']['lot_id'],
                            ),
                           'fields'=>array(
                               'LotProduct.lot_id',
                               'LotProduct.quantity',
                               'LotProduct.product_id'
                           )
                            );
                             $this->LotProduct->recursive=-1;
                                $duplicates=  $this->LotProduct->find('all',$option);
                                 if($duplicates)
                                {
                                  $this->Session->setFlash(__('9.Duplicate Product is found in Same Lot!,Please Try Again'));
                                  $this->redirect($this->referer());   
                                }
                            #find the product information in contract product
                            $option=array(
                                'conditions'=>array(
                                    'ContractProduct.contract_id'=>$this->request->data['LotProduct']['contract_id'],
                                    'ContractProduct.product_id'=>$data[0]
                                ),
                                'fields'=>array(
                                    'quantity',
                                    'uom',
                                    'unit_weight',
                                    'unit_weight_uom'
                                )
                            );
                            
                            $con_quantity=  $this->ContractProduct->find('first',$option);
                            $con_qty=($con_quantity['ContractProduct']['quantity'])?$con_quantity['ContractProduct']['quantity']:0;
                            #find the already exist product quantity
                            $option_lot=array(
                                'conditions'=>array(
                                    'LotProduct.contract_id'=>$this->request->data['LotProduct']['contract_id'],
                                    'LotProduct.product_id'=>$data[0],
                                ),
                                'fields'=>array(
                                    'SUM(LotProduct.quantity) as quantity'
                                )
                            );
                            $previous_lot_qty=$this->LotProduct->find('first',$option_lot);
                            $plq=$data[4]+$previous_lot_qty[0]['quantity'];
                            if($con_qty<$plq)
                            {
                                $this->Session->setFlash(__('6.PO quantity is less than Lot Qty of product id '.$data[0].'!,Please Try Again'));
                                $this->redirect($this->referer()); 
                            }                           
                            #store product id for check duplicate
                            
                            $productid[]=$data[0];
                            
                            $savaData[]=array(
                                'LotProduct'=>array(
                                    'contract_id'=>$this->request->data['LotProduct']['contract_id'],
                                    'lot_id'=>$this->request->data['LotProduct']['lot_id'],
                                    'product_id'=>$data[0],
                                    'product_category_id'=>$data[3],
                                    'quantity'=>$data[4],
                                    'contract_quantity'=>$con_qty,
                                    'uom'=>$con_quantity['ContractProduct']['uom'],                                    
                                    'unit_weight'=>$con_quantity['ContractProduct']['unit_weight'],
                                    'unit_weight_uom'=>$con_quantity['ContractProduct']['unit_weight_uom'],
                                    'added_by'=>$UserID,
                                    'added_date'=>date('Y-m-d H:i:s'),
                                    'modified_by'=>'',
                                    'modified_date'=>'',
                                )
                            );
                            
                        }
                        fclose($handle);
                        #echo '<pre>';print_r($savaData);
                        # Duplicates
                        $unique=array_unique( array_diff_assoc($productid, array_unique($productid)));
                        if($unique)
                        {
                          $this->Session->setFlash(__('8.Duplicate Product is found in CSV files!,Please Try Again'));
                          $this->redirect($this->referer());   
                        }
                        
                        #save the product to contract
                        
                        $this->LotProduct->create();
                        if($this->LotProduct->saveMany($savaData))
                        {
                            $this->Session->setFlash(__('4. LOT products has been saved successfully'));
                            $this->redirect(array('controller'=>'lot_products','action'=>'index/'.$contract_id.'/'.str_replace('/','|',$lot_id))); 
                        }
                        else{
                            $this->Session->setFlash(__('5.There is a problem while saving requested data!,Please Try Again'));
                                $this->redirect($this->referer());
                        }
                        
                    }
                      
                  }else{
                    $this->Session->setFlash(__('Sorry, mime type not allowed!,Please Try Again'));
                    $this->redirect($this->referer());
                }
                    
                }
                else{
                    $this->Session->setFlash(__('2.Please choose PO and CSV files!,Please Try Again'));
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
