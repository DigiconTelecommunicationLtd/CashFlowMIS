<?php

App::uses('AppController', 'Controller');

/**
 * Procurements Controller
 *
 * @property Procurement $Procurement
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ProcurementsController extends AppController {

    public function add() {
        $option = array();
        $option_procurement = array();
        $lot_id=null;
        if ($this->request->is('post')) {            
           // $this->layout="ajax";   
            $date=$this->request->data['Procurement']['date'];
            $date_type=$this->request->data['Procurement']['date_type'];
            
            $contract_id = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['Procurement']['contract_id']));
            $lot_id = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['Procurement']['lot_id']));
            $FormType = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['Procurement']['FormType']));
             
             if (!$contract_id||!$lot_id||!$FormType) {
                $this->Session->setFlash(__('PO & Lot number is required!. Please, try again.'));
                return $this->redirect(array('action'=>'add'));
            }
            if($this->request->data['Procurement']['product_category_id'])
                {
                    $option['LotProduct.product_category_id'] = $this->request->data['Procurement']['product_category_id'];
                    $option_procurement['Procurement.product_category_id'] = $this->request->data['Procurement']['product_category_id'];
                }
                $planned_same_as_actual=trim($this->request->data['Procurement']['planned_same_as_actual']);
                
                #lot option
                $option['LotProduct.contract_id'] = $contract_id;
                $option['LotProduct.lot_id'] =(string) $lot_id;
                #procurement option
                $option_procurement['Procurement.contract_id'] = $contract_id;
                $option_procurement['Procurement.lot_id'] =(string) $lot_id;
                #set current lot id
                $lots[$lot_id]=$lot_id;
            
             
            if($FormType=='submit'):
                //$this->Procurement->recursive=-1;
                $pquantitys=$this->request->data['Procurement']['quantity'];
                $uom=$this->request->data['Procurement']['uom'];
                $unit_weight=$this->request->data['Procurement']['unit_weight'];
                $unit_weight_uom=$this->request->data['Procurement']['unit_weight_uom'];
                $product_category_id=$this->request->data['Procurement']['product_category_id'];
                $planned=$this->request->data['Procurement']['planned'];
                //$actual=$this->request->data['Procurement']['actual'];
                //echo '<pre>';print_r($product_category_id);exit;
                foreach ($pquantitys as $key => $quantity) {
                    /*****************of check lot qty and production qty ********************/ 
                    #if qty and date not set properly
                    if(!$quantity||$quantity<=0||!trim($planned[$key])||!$product_category_id[$key])
                    {
                        continue;
                    }
                    #check lot qty with product id lot number
                    $lot_option1=array(
                        'conditions'=>array(
                            'LotProduct.lot_id'=>$lot_id,
                            'LotProduct.product_id'=>$key
                        ),
                        'fields'=>array(
                            'SUM(LotProduct.quantity) as quantity'
                        )
                    );
                    $this->loadModel('LotProduct');
                   // $this->LotProduct->recursive=-1;
                    $lot_qty=$this->LotProduct->find('first',$lot_option1);
                    $lot_qty=($lot_qty[0]['quantity']>0)?$lot_qty[0]['quantity']:0;
                    
                    #check production qty with product id lot number
                    $pro_option1=array(
                        'conditions'=>array(
                            'Procurement.lot_id'=>$lot_id,
                            'Procurement.product_id'=>$key
                        ),
                        'fields'=>array(
                            'SUM(Procurement.quantity) as quantity'
                        )
                    );
                    //$this->Production->recursive=-1;
                    $pro_qty=$this->Procurement->find('first',$pro_option1);
                    $pro_qty=($pro_qty[0]['quantity']>0)?$pro_qty[0]['quantity']:0;
                    $pro_qty+=$quantity;
                    #compare lot size with production size
                    if($pro_qty>$lot_qty):
                        continue;
                    endif;
                    /*****************end of check lot qty and production qty ********************/
                    
                    $user = $this->Session->read('UserAuth');
                    $UserID =$user['User']['username'];
                    
                    $option1['Procurement.product_id']=$key;
                    $option1['Procurement.contract_id'] = $contract_id;
                    $option1['Procurement.lot_id'] = $lot_id;
                    
                    $quantity=trim($quantity);
                    if ($planned[$key]) {
                        $planned_arrival_date = str_replace(array("\r", "\n", "\t"," "), '',date('Y-m-d', strtotime($planned[$key])));
                        if($planned_arrival_date=="1970-01-01"){
                            continue;
                        }
                    }else{
                       continue; 
                    }
                  
                   $saveData[]=array(
                        'Procurement'=>array(
                                'contract_id'=>$contract_id,
                                'lot_id'=>$lot_id,
                                'product_category_id'=>$product_category_id[$key],
                                'product_id'=>$key,
                                'quantity'=>trim($quantity),
                                'uom'=>$uom[$key],                                
                                'planned_arrival_date'=>$planned_arrival_date,
                                'actual_arrival_date'=>($planned_same_as_actual)?$planned_arrival_date:"0000-00-00",
                                'unit_weight'=>$unit_weight[$key],
                                'unit_weight_uom'=>$unit_weight_uom[$key],
                                'added_by'=>$UserID
                        )
                    );
                }
                /***************save procurement data****************/
                $count_product= count($saveData);
                if($saveData>0){
                    $this->Procurement->create();
                    if($this->Procurement->saveMany($saveData))
                    {
                        $this->Session->setFlash(__($count_product.' products has been saved successfully.'));
                    }
                    else{
                        $this->Session->setFlash(__('Product could not saved successfully.Please, try again.'));
                    }
                }
                else{
                    $this->Session->setFlash(__('There is no product for saved.Please, try again.'));
                }
                /***************end of save procurement data****************/
            endif;
               //get Lots products by contract and lot no
                App::uses('LotProductsController', 'Controller');  
                $lots=new LotProductsController();
                $lots_products=$lots->__getLotProducts($option);
                 if(!$lots_products)
                {
                    $this->Session->setFlash(__('There is no product found in lots with these filter options. Please, try again.'));
                }
               //lots by contract
                App::uses('LotsController', 'Controller');  
                $lots=new LotsController();
                $lots=$lots->__getLotNumberListBoxByContract($contract_id); 
                
                //previously procurement product by contract and lot wise
                $procurement=$this->__getProcurementProducts($option_procurement);
                
                //procurement products for update actual date
                
                $this->Procurement->unbindModel(array('belongsTo'=>array('Contract')));
                $actual_date_results=  $this->Procurement->find('all',array('conditions'=>$option_procurement,'order'=>array('Procurement.product_id'=>'ASC')));
                //echo '<pre>';print_r($actual_date_results);exit;
                
            
       }
       
            App::uses('ContractsController', 'Controller');  
            $contracts=new ContractsController();
            $contracts=$contracts->__getContractsListBox();
            
            #ProductCategory list box
            $this->loadModel('ProductCategory');
            $product_categories = $this->ProductCategory->find('list');
            
            $this->set(compact('date','date_type','contracts','lots','contract_id','lot_id','lots_products','procurement','actual_date_results','product_categories','planned_same_as_actual'));
       
    }
    
    public function __getProcurementProducts(&$option_procurement)
    {
        if(empty($option_procurement)){
            return '';
        }        
        $condition = array('conditions' => array($option_procurement), 'fields' => array('Procurement.product_id', 'SUM(Procurement.quantity) as quantity', 'MAX(Procurement.planned_arrival_date) planned_arrival_date', 'MAX(Procurement.actual_arrival_date) actual_arrival_date'), 'group' => array('Procurement.contract_id', 'Procurement.lot_id', 'Procurement.product_id'),'order'=>array('Procurement.product_id'=>'ASC'));
        $pmt_products = $this->Procurement->find('all', $condition);
        $procurement = array();
        foreach ($pmt_products as $key => $value) {
            $procurement[$value['Procurement']['product_id']] = $value[0]['quantity'];
            $procurement['pd_' . $value['Procurement']['product_id']] = $value[0]['planned_arrival_date'];
            $procurement['ad_' . $value['Procurement']['product_id']] = $value[0]['actual_arrival_date'];
        }
        
        return $procurement;
    }
    
    public function procurement_actual_arrival_date_editing() {
        $this->autoRender = FALSE;
        if ($this->request->data) {
            $user = $this->Session->read('UserAuth');
            $UserID =$user['User']['username'];
            $this->layout = 'ajax';
            $id = $this->request->data['id'];
            if (isset($this->request->data['actual_date_update'])) {
                $actual_date_update = str_replace(array("\r", "\n", "\t"), '',date('Y-m-d', strtotime($this->request->data['actual_date_update'])));
            }            
            $app_conl=new AppController();
            $check=$app_conl->validateDate($actual_date_update);
             $message = "Wrong:Date Format!";
            if($check):
                // $actual_date_update=$this->request->data['actual_date_update'];
                $this->Procurement->id = $id;
                 $this->beforeRender();
                if ($this->Procurement->saveField('actual_arrival_date', $actual_date_update, false)) {
                    $this->Procurement->saveField('modified_by', $UserID, false);
                    $this->Procurement->saveField('modified_date', date('Y-m-d h:m:i'), false);
                    $message = "Record updated successfully.";
                } else {
                    $message = "Error:There is an error while record updating!";
                }
           endif;
            echo $message;
           
            // $this->set(compact('actual_date_update','message'));
        }
    }    
    
    public function procurement_actual_arrival_date_editing_all()
    {        
      $this->layout='ajax';
      $this->request->accepts('application/json');
      $data=$this->request->input ('json_decode', true);
      $user=$this->Session->read('UserAuth');
      $UserID=$user['User']['username'];
      $sql='';
      if($data)
      {
          foreach ($data as $value){
            $id=$value['id'];
            $actual_date=$value['actual_date'];
                if($id&&$actual_date){
                $sql.="UPDATE procurements SET actual_arrival_date= '".$actual_date."', modified_by= '".$UserID."', modified_date= '".date('Y-m-d H:m:s')."' WHERE id =$id;";
            }
          }          
         if($this->Procurement->query($sql)){
              echo'1';
          }
          else{
              echo'2';
          }
      }
     $this->autoRender = FALSE;      
    }

    public function delete() {
        $this->layout = 'ajax';
        $this->autoRender=false;
        #find the product option
        $this->Procurement->id = $id=$this->request->data['id'];
        if (!$this->Procurement->exists()) {
            //throw new NotFoundException(__('Invalid production product'));
            echo "0";
            exit();
        }
        else{# valid id is found
            $this->Procurement->recursive=-1;
            $product=  $this->Procurement->findById($id);

            $product_id=$product['Procurement']['product_id'];
            $lot_id=$product['Procurement']['lot_id'];
            $actual_arrival_date=$product['Procurement']['actual_arrival_date'];
            
            if($actual_arrival_date=="0000-00-00")
            {
                $this->request->allowMethod('post', 'delete');
                if ($this->Procurement->delete()) {
                    echo "1";
                } else {
                     echo "0";
                }
            }
            else{
                $option1=array(
                   'conditions'=>array(
                       'Production.product_id'=>$product_id,
                       'Production.lot_id'=>$lot_id
                   )
               );
               $this->loadModel('Production');
               $this->Production->recursive=-1;

               if(!$this->Production->find('first',$option1)):#check the product of that lot is in inspection        
                   $this->request->allowMethod('post', 'delete');
                   if ($this->Procurement->delete()) {
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
