<?php

App::uses('AppController', 'Controller');

/**
 * Lots Controller
 *
 * @property Lot $Lot
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class LotsController extends AppController {
    /**
     * index method
     *
     * @return void
     */
    public function index() {
         
        if ($this->request->is('post')) {
            
            if ($this->request->data['Lot']['contract_id']) {
                $options['Lot.contract_id'] = $this->request->data['Lot']['contract_id'];
            }
            
            if ($this->request->data['Lot']['product_category_id']&&$this->request->data['Lot']['contract_id']) {
              
                $cond=array(
                    'conditions'=>array(
                        'LotProduct.product_category_id'=>$this->request->data['Lot']['product_category_id'],
                        'LotProduct.contract_id'=>$this->request->data['Lot']['contract_id']
                    ),
                    'fields'=>array('LotProduct.lot_id','LotProduct.lot_id')
                );
                
                $this->loadModel('LotProduct');                
                $lots=  $this->LotProduct->find('list',$cond); 
                $options['Lot.lot_no']=$lots;                 
            }
            if($options):
                $options = array('conditions' => $options, 'order' => array('Lot.id' => 'DESC'));

                $this->Lot->recursive = 0;
                $lots = $this->Lot->find('all', $options);
           endif;
        }         
        

        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $contracts = $this->Contract->find('list', $options);
        
        #ProductCategory list box
        $this->loadModel('ProductCategory');
        $product_categories = $this->ProductCategory->find('list');
        
        $this->set(compact('start_date', 'end_date', 'contracts', 'lots','product_categories'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($contract_id = null) {
        if ($this->request->is('post')) {

            $user = $this->Session->read('UserAuth');
            $this->request->data['Lot']['added_by'] = $user['User']['username'];

            $this->Lot->create();

            if ($this->Lot->save($this->request->data)) {
                $contract_id = $this->request->data['Lot']['contract_id'];
                $lot_id = $this->Lot->getLastInsertID();
                if ($contract_id && $lot_id) {
                    return $this->redirect(array('controller' => 'lot_products', 'action' => 'add/' . $lot_id));
                }
                $this->Session->setFlash(__('The Lot Number could not be saved. Please, try again.'));
            } else {
                $this->Session->setFlash(__('The Lot Number could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('Contract');
        $options = array('fields' => array('Contract.id', 'Contract.contract_no'), 'order' => array('Contract.id' => 'DESC'));
        $contracts = $this->Contract->find('list', $options);

        $this->set(compact('contract_id', 'contracts', 'start_date', 'end_date'));
    }

    public function generateLotNumberByContract($contract_id = null) {
        $this->layout = "ajax";
        $contract_id = $this->request->data['Lot']['contract_id'];        
        $option = array('conditions' => array('Lot.contract_id' => $contract_id), 'fields' => array('count(Lot.lot_no) as lot_no'));
        $lot_no = $this->Lot->find('first', $option);  
        //find the contract no
        $this->loadModel('Contract');
        $option = array('conditions' => array('Contract.id' => $contract_id), 'fields' => array('Contract.contract_no'));
        $contract=  $this->Contract->find('first',$option);
        if (isset($lot_no[0]['lot_no'])) {
            $lot_no = $contract['Contract']['contract_no'] . '/Lot-' . sprintf("%02d", $lot_no[0]['lot_no'] + 1);
        } else {
            $lot_no = $contract['Contract']['contract_no'] . '/Lot-01';
        }

        // $this->autoRender=false;            
        $this->set(compact('lot_no', 'contract_id'));
    }
    
    
    public function __getLotNumberListBoxByContract($contract_id=null)
    {
        $this->autoRender=false;
        if(empty($contract_id)){
            return ''; 
        }
        $cond=array('conditions'=>array('Lot.contract_id'=>$contract_id),'fields'=>array('Lot.lot_no'));
        $this->Lot->recursive=-1;
        $option=array();
        $lots=  $this->Lot->find('all',$cond);
        foreach ($lots as $key => $value) {
          $option[$value['Lot']['lot_no']]=$value['Lot']['lot_no'];  
        }
        return $option;
    }
    
    public function LotListBoxByContract($contract_id=null)
    {
        $this->autoRender=false;
        if(empty($contract_id)){
            return ''; 
        }
        $cond=array('conditions'=>array('Lot.contract_id'=>$contract_id),'fields'=>array('Lot.lot_no'));
        $this->Lot->recursive=-1;
        $option=array();
        $lots=  $this->Lot->find('all',$cond);
        foreach ($lots as $key => $value) {
          $option[$value['Lot']['lot_no']]=$value['Lot']['lot_no'];  
        }
        return $option;
    }
    
    public function getLotByContract()
    {
         $this->layout = 'ajax';
         $model = $this->request->params['named']['model'];
         $contract_id = $this->request->data[$model]['contract_id'];
         $options = array('conditions' => array('Lot.contract_id' => $contract_id),'fields'=>array('lot_no','lot_no'),'order' => array('Lot.id' => 'DESC'));
         $losts=  $this->Lot->find('list',$options);
         $this->set(compact('losts', 'contract_id'));
    }

}
