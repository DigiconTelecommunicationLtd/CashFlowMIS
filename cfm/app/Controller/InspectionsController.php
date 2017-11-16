<?php

App::uses('AppController', 'Controller');

/**
 * Inspections Controller
 *
 * @property Inspection $Inspection
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class InspectionsController extends AppController {

    public function add() {
        $option = array();
        $option_1 = array();
        $lot_id=null;
        if ($this->request->is('post')) {            
           // $this->layout="ajax";       
            $date=$this->request->data['Inspection']['date'];
            $date_type=$this->request->data['Inspection']['date_type'];
            
            $contract_id = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['Inspection']['contract_id']));
            $lot_id = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['Inspection']['lot_id']));
            $FormType = str_replace(array("\r", "\n", "\t"), '', ($this->request->data['Inspection']['FormType']));
            
            if (!$contract_id||!$lot_id||!$FormType) {
                $this->Session->setFlash(__('PO & Lot number is required!. Please, try again.'));
                return $this->redirect(array('action'=>'add'));
            }
            if($this->request->data['Inspection']['product_category_id'])
                {
                    $option['Production.product_category_id'] = $this->request->data['Inspection']['product_category_id'];
                    $option_1['Inspection.product_category_id'] = $this->request->data['Inspection']['product_category_id'];
                }
           $planned_same_as_actual=trim($this->request->data['Inspection']['planned_same_as_actual']);
                
                $option['Production.contract_id'] =$contract_id;
                $option['Production.lot_id'] =(string)$lot_id;
                 $option['Production.actual_completion_date !='] ="0000-00-00";
                
                $option_1['Inspection.contract_id'] =$contract_id;
                $option_1['Inspection.lot_id'] =(string)$lot_id;
                //set default lot no
                $lots[$lot_id]=$lot_id;
                
                /*Actual date for product arrival from procurement option*/  
                $actaul_date_options=null;
                $actaul_date_result=null;
                $actual_column="actual_completion_date";
                $model="Production";
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
                    $this->set('actaul_date_info',$actaul_date_info); 
                }
            /* End Actual date for product arrival from procurement option*/
            
            if($FormType=='submit'):
                //$this->Inspection->recursive=-1;
                $pquantitys=$this->request->data['Inspection']['quantity'];
                $uom=$this->request->data['Inspection']['uom'];
                $unit_weight=$this->request->data['Inspection']['unit_weight'];
                $unit_weight_uom=$this->request->data['Inspection']['unit_weight_uom'];
                $product_category_id=$this->request->data['Inspection']['product_category_id'];
                $planned=$this->request->data['Inspection']['planned'];
                //$actual=$this->request->data['Inspection']['actual'];
               
                foreach ($pquantitys as $key => $quantity) {
                   /*****************of check lot qty and production qty ********************/ 
                    #if qty and date not set properly
                    if(!$quantity||$quantity<=0||!trim($planned[$key])||!$product_category_id[$key])
                    {
                        continue;
                    }
                    #check production qty with product id lot number
                    $production_option1=array(
                        'conditions'=>array(
                            'Production.lot_id'=>$lot_id,
                            'Production.product_id'=>$key
                        ),
                        'fields'=>array(
                            'SUM(Production.quantity) as quantity'
                        )
                    );
                    $this->loadModel('Production');
                    //$this->Production->recursive=-1;
                    $lot_qty=$this->Production->find('first',$production_option1);
                    $lot_qty=($lot_qty[0]['quantity']>0)?$lot_qty[0]['quantity']:0;
                    
                    #check inspection qty with product id lot number
                    $ins_option1=array(
                        'conditions'=>array(
                            'Inspection.lot_id'=>$lot_id,
                            'Inspection.product_id'=>$key
                        ),
                        'fields'=>array(
                            'SUM(Inspection.quantity) as quantity'
                        )
                    );
                    //$this->Inspection->recursive=-1;
                    $pro_qty=$this->Inspection->find('first',$ins_option1);
                    $pro_qty=($pro_qty[0]['quantity']>0)?$pro_qty[0]['quantity']:0;
                    $pro_qty+=$quantity;
                    #compare lot size with production size
                    if($pro_qty>$lot_qty):
                        continue;
                    endif;
                    /*****************end of check lot qty and production qty ********************/
                    
                    $user = $this->Session->read('UserAuth');
                    $UserID= $user['User']['username'];
                    
                    $quantity=trim($quantity);
                    
                    if (isset($planned[$key])) {
                    $planned_inspection_date = str_replace(array("\r", "\n", "\t"), '',date('Y-m-d', strtotime($planned[$key])));
                     if($planned_inspection_date=="1970-01-01"){
                            continue;
                        }
                    }
                    else{
                        continue;
                    }
                    $saveData[]=array(
                        'Inspection'=>array(
                                'contract_id'=>$contract_id,
                                'lot_id'=>$lot_id,
                                'product_category_id'=>$product_category_id[$key],
                                'product_id'=>$key,
                                'quantity'=>trim($quantity),
                                'uom'=>$uom[$key],
                                'planned_inspection_date'=>$planned_inspection_date,
                                'actual_inspection_date'=>($planned_same_as_actual)?$planned_inspection_date:'0000-00-00',
                                'unit_weight'=>$unit_weight[$key],
                                'unit_weight_uom'=>$unit_weight_uom[$key],
                                'added_by'=>$UserID
                        )
                    );                    
                }
                /***************save production data****************/
                $count_product= count($saveData);
                if($saveData>0){
                    $this->Inspection->create();
                    if($this->Inspection->saveMany($saveData))
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
                /***************end of save production data****************/
            endif;
               //get Lots products by contract and lot no
                App::uses('ProductionsController', 'Controller');  
                $production=new ProductionsController();
                $production_results=$production->__getProductionProductsforInspection($option);
                
                
               //lots by contract
                App::uses('LotsController', 'Controller');  
                $lots=new LotsController();
                $lots=$lots->__getLotNumberListBoxByContract($contract_id); 
                
                //previously production product by contract and lot wise
                $result=$this->__getInspectionProducts($option_1);
                $this->Inspection->unbindModel(array('belongsTo'=>array('Contract')));
                $actual_date_results=  $this->Inspection->find('all',array('conditions'=>$option_1,'order'=>array('Inspection.product_id'=>'ASC')));
                //echo '<pre>';print_r($actual_date_results);exit;
            
       }
       
            App::uses('ContractsController', 'Controller');  
            $contracts=new ContractsController();
            $contracts=$contracts->__getContractsListBox();
            
            #ProductCategory list box
            $this->loadModel('ProductCategory');
            $product_categories = $this->ProductCategory->find('list');
            
            $this->set(compact('date','date_type','contracts','lots','contract_id','lot_id','production_results','result','actual_date_results','product_categories'));
       
    }
    
    public function __getInspectionProducts(&$option)
    {  
        if(empty($option)){
            return '';
        }        
        $condition = array('conditions' => array($option), 'fields' => array('Inspection.product_id', 'SUM(Inspection.quantity) as quantity',/* 'MAX(Inspection.planned_completion_date) planned_completion_date', 'MAX(Inspection.actual_completion_date) actual_completion_date',*/'Inspection.lot_id'), 'group' => array('Inspection.contract_id', 'Inspection.lot_id', 'Inspection.product_id'),'order'=>array('Inspection.product_id'=>'ASC'));
        $pmt_products = $this->Inspection->find('all', $condition);
        $data = array();
        foreach ($pmt_products as $key => $value) {
            $data[$value['Inspection']['product_id']] = $value[0]['quantity'];
          /*  $data['pd_' . $value['Inspection']['product_id']] = $value[0]['planned_completion_date'];
            $data['ad_' . $value['Inspection']['product_id']] = $value[0]['actual_completion_date'];*/
        }
        return $data;
    }
  
    public function actual_inspection_date_editing(){
        $this->autoRender = FALSE;
        if ($this->request->data) {
            $user = $this->Session->read('UserAuth');
            $UserID =$user['User']['username'];
            $this->layout = 'ajax';
            $id = $this->request->data['id'];
            if (isset($this->request->data['actual_date_update'])) {
                $actual_date_update =str_replace(array("\r", "\n", "\t"), '', date('Y-m-d', strtotime($this->request->data['actual_date_update'])));
            }
            $app_conl=new AppController();
            $check=$app_conl->validateDate($actual_date_update);
             $message = "Wrong:Date Format!";
            if($check):
                // $actual_date_update=$this->request->data['actual_date_update'];
                $this->Inspection->id = $id;
                 $this->beforeRender();
                if ($this->Inspection->saveField('actual_inspection_date', $actual_date_update, false)) {
                    $this->Inspection->saveField('modified_by', $UserID, false);
                    $this->Inspection->saveField('modified_date', date('Y-m-d h:m:i'), false);
                    $message = "Record updated successfully.";
                } else {
                    $message = "Error:There is an error while record updating!";
                }
           endif;
            echo $message;
           
            // $this->set(compact('actual_date_update','message'));
        }
    }
    
     public function actual_inspection_date_editing_all()
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
                $sql.="UPDATE inspections SET actual_inspection_date='".$actual_date."', modified_by= '".$UserID."', modified_date= '".date('Y-m-d H:m:s')."' WHERE id =$id;";
            }
          }          
         if($this->Inspection->query($sql)){
              echo'1';
          }
          else{
              echo'2';
          }
      }
     $this->autoRender = FALSE;      
    }
    
    public function __getInspectionProductForDelivery(&$option)
    {
     if(empty($option)){
            return '';
        }
        $condition = array('conditions' => array($option), 'fields' => array('Inspection.product_id', 'Product.name', 'SUM(Inspection.quantity) as quantity','Inspection.unit_weight','Inspection.unit_weight_uom','Inspection.uom','Inspection.lot_id','ProductCategory.name'), 'group' => array('Inspection.contract_id', 'Inspection.lot_id', 'Inspection.product_id'));
        $pmt_products = $this->Inspection->find('all', $condition); 
        return $pmt_products;   
    }
     public function delete() {
        $this->layout = 'ajax';
        $this->autoRender=false;
        #find the product option
        $this->Inspection->id = $id=$this->request->data['id'];
        if (!$this->Inspection->exists()) {
            //throw new NotFoundException(__('Invalid production product'));
            echo "0";
            exit();
        }
        else{# valid id is found
            $this->Inspection->recursive=-1;
            $product=  $this->Inspection->findById($id);

            $product_id=$product['Inspection']['product_id'];
            $lot_id=$product['Inspection']['lot_id'];
            $actual_inspection_date=$product['Inspection']['actual_inspection_date'];
            if($actual_inspection_date=="0000-00-00")
            {
                $this->request->allowMethod('post', 'delete');
                if ($this->Inspection->delete()) {
                    echo "1";
                } else {
                     echo "0";
                }
            }
            else{
             $option1=array(
                'conditions'=>array(
                    'Delivery.product_id'=>$product_id,
                    'Delivery.lot_id'=>$lot_id
                )
            );
                $this->loadModel('Delivery');
                $this->Delivery->recursive=-1;

                if(!$this->Delivery->find('first',$option1)):#check the product of that lot is in delivery        
                    $this->request->allowMethod('post', 'delete');
                    if ($this->Inspection->delete()) {
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
