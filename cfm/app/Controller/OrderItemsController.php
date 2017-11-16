<?php

App::uses('AppController', 'Controller');

/**
 * OrderItems Controller
 *
 * @property OrderItem $OrderItem
 * @property PaginatorComponent $Paginator
 */
class OrderItemsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * index method
     *
     * @return void
     */
    public function index() {        
         if ($this->request->is('post')) {
            if ($this->request->data['OrderItem']['start_date'] && $this->request->data['OrderItem']['end_date']) {
                $option['SUBSTRING(OrderItem.added_date,1,10) BETWEEN ? AND ?'] = array(date('Y-m-d', strtotime($start_date = $this->request->data['OrderItem']['start_date'])), date('Y-m-d', strtotime($end_date = $this->request->data['OrderItem']['end_date'])));
            }
            if ($this->request->data['OrderItem']['invoice_no']) {
                $option['OrderItem.invoice_no'] = $this->request->data['OrderItem']['invoice_no'];
            }
            if ($this->request->data['OrderItem']['client_id']) {
                $option['OrderItem.client_id'] = $this->request->data['OrderItem']['client_id'];
            }
        } else {
            $start_date = $end_date = date('Y-m-d');
            $option['SUBSTRING(OrderItem.added_date,1,10) BETWEEN ? AND ?'] = array($start_date, $end_date);
        }
        $conditions = array('conditions' => array($option),'order'=>array('OrderItem.id'=>"ASC"));
        $this->OrderItem->recursive = -1;
        $orderItems = $this->OrderItem->find('all', $conditions); 
        $clients = $this->OrderItem->Client->find('list');
        $this->set(compact('start_date', 'end_date','clients','orderItems'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
   /* public function view($id = null) {
        if (!$this->OrderItem->exists($id)) {
            throw new NotFoundException(__('Invalid order item'));
        }
        $options = array('conditions' => array('OrderItem.' . $this->OrderItem->primaryKey => $id));
        $this->set('orderItem', $this->OrderItem->find('first', $options));
    }
*/
    /**
     * add method
     *
     * @return void
     */
    public function add($input_id = null) {
        $user = $this->Session->read('UserAuth');
        $products = $this->Session->read('products');
        if (!$products):
            $option = array('conditions' => array(
                    'Product.product_category_id' => 7
                ),
                'order' => array(
                    'Product.name' => "ASC"
            ));
            $products = $this->OrderItem->Product->find('list', $option);
            $this->Session->write('products', $products);
        endif;

        //$clients = $this->Session->read('clients');
        //if (!$clients):
            $clients = $this->OrderItem->Client->find('list');
           // $this->Session->write('clients', $clients);
       // endif;

        if ($this->request->is('post')) {
            $this->OrderItem->create();
            $this->request->data['OrderItem']['added_by'] = $user['User']['username'];
            $this->request->data['OrderItem']['added_date'] = date('Y-m-d h:i:s');
            $this->request->data['OrderItem']['product_name'] = $products[$this->request->data['OrderItem']['product_id']];
            if ($this->OrderItem->save($this->request->data)) {
                $this->Session->setFlash(__('The order item has been saved.'));
                return $this->redirect(array('action' => 'add'));
            } else {
                $this->Session->setFlash(__('The order item could not be saved. Please, try again.'));
            }
        }
        $option = array(
            'conditions' => array('OrderItem.added_by' => $user['User']['username'], 'OrderItem.status' => 1, 'SUBSTRING(OrderItem.added_date,1,10) BETWEEN ? AND ?' => array(date('Y-m-d'), date('Y-m-d'))),
            'order' => array('OrderItem.id' => "DESC")
        );


        $order_products = $this->OrderItem->find('all', $option);
        $this->loadModel('Order');
        $fields=array(
            'fields'=>array(
                'COUNT(*) as order_no'
            )
        );
        $order_no=$this->Order->find('first',$fields);  
        $order_no=$order_no[0]['order_no']+1;
        $order_no=str_pad($order_no, 2, '0', STR_PAD_LEFT); 
        $this->set(compact('orders', 'products', 'clients', 'order_products', 'input_id','order_no'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->OrderItem->exists($id)) {
            throw new NotFoundException(__('Invalid order item'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->OrderItem->id = $id;

            if ($this->OrderItem->save($this->request->data)) {
                $this->Session->setFlash(__('The order item has been saved.'));
            } else {
                $this->Session->setFlash(__('The order item could not be saved. Please, try again.'));
            }
        }
        if ($this->request->data['OrderItem']['unit_price'])
            $input_id = 'quantity_' . $id;
        else if ($this->request->data['OrderItem']['quantity'])
            $input_id = 'discount_percent_' . $id;
        else if ($this->request->data['OrderItem']['discount_percent'])
        {
             $id=$id-1;
            $input_id = 'unit_price_' . $id;
        }

        return $this->redirect(array('action' => 'add', $input_id));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->OrderItem->id = $id;
        if (!$this->OrderItem->exists()) {
            throw new NotFoundException(__('Invalid order item'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->OrderItem->delete()) {
            $this->Session->setFlash(__('The order item has been deleted.'));
        } else {
            $this->Session->setFlash(__('The order item could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'add'));
    }

}
