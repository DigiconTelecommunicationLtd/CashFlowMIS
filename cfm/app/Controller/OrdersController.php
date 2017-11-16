<?php

App::uses('AppController', 'Controller');

/**
 * Orders Controller
 *
 * @property Order $Order
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class OrdersController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        if ($this->request->is('post')) {
            if ($this->request->data['Order']['start_date'] && $this->request->data['Order']['end_date']) {
                $option['SUBSTRING(Order.added_date,1,10) BETWEEN ? AND ?'] = array(date('Y-m-d', strtotime($start_date = $this->request->data['Order']['start_date'])), date('Y-m-d', strtotime($end_date = $this->request->data['Order']['end_date'])));
            }
            if ($this->request->data['Order']['invoice_no']) {
                $option['Order.invoice_no'] = $this->request->data['Order']['invoice_no'];
            }
            if ($this->request->data['Order']['client_id']) {
                $option['Order.client_id'] = $this->request->data['Order']['client_id'];
            }
        } else {
            $start_date = $end_date = date('Y-m-d');
            $option['SUBSTRING(Order.added_date,1,10) BETWEEN ? AND ?'] = array($start_date, $end_date);
        }
        $conditions = array('conditions' => array($option), 'order' => array('Order.id' => 'DESC'));
        $this->Order->recursive = -1;
        $orders = $this->Order->find('all', $conditions);
        $clients = $this->Order->Client->find('list');
        #summation
        $conditions = array('conditions' => array($option), 'fields' => array(
                'SUM(Order.total_bill) total_bill',
                'SUM(Order.discount) discount',
                'SUM(Order.net_amount) net_amount',
                'SUM(Order.received_amount) received_amount',
                'SUM(Order.ait) ait',
                'SUM(Order.vat) vat',
                'SUM(Order.ld) ld',
                'SUM(Order.other_deduction) other_deduction',
                'SUM(Order.balance) balance',
            ), 'order' => array('Order.id' => 'DESC'));
        $this->Order->recursive = -1;
        $order_sum = $this->Order->find('first', $conditions);
        $this->set(compact('orders', 'start_date', 'end_date', 'clients', 'order_sum'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Order->exists($id)) {
            throw new NotFoundException(__('Invalid order'));
        }
        $options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
        $this->set('order', $this->Order->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            #echo '<pre>';print_r($this->request->data['Order']);exit;
            $user = $this->Session->read('UserAuth');

            $this->Order->create();
            if ($this->Order->find('first', array('conditions' => array('Order.invoice_no' => trim($this->request->data['Order']['invoice_no'])), 'recursive' => -1))):
                $this->Session->setFlash(__('Duplicate Invoice found. Please, try again with another Invoice No.'));
                $this->redirect($this->referer());
            endif;
            $this->request->data['Order']['added_by'] = $user['User']['username'];
            $this->request->data['Order']['added_date'] = date('Y-m-d h:i:s');
            $invoice_no = trim($this->request->data['Order']['invoice_no']);
            $received_amount = trim($this->request->data['Order']['received_amount']);
            $received_amount = ($received_amount > 0) ? $received_amount : 0;
            $this->request->data['Order']['balance'] = $this->request->data['Order']['net_amount'] - $this->request->data['Order']['received_amount'];
            $client_id = $this->request->data['Order']['client_id'];
            $option = array('conditions' => array('Client.id' => $client_id), 'fields' => array('Client.name'));
            $client = $this->Order->Client->find('first', $option);
            $this->request->data['Order']['client_name'] = $client['Client']['name'];
            $datasource = $this->Order->getDataSource();
            try {
                //datatransact begin here..
                $datasource->begin();
                if ($this->Order->save($this->request->data)) {
                    #Get Last insert ID from Order
                    $order_id = $this->Order->getLastInsertID();
                    $this->loadModel('OrderItem');
                    #update the recently added order item which order id is 0,invoice is null,and order status is 1 and login user
                    $this->OrderItem->recursive = -1;
                    if (!$this->OrderItem->updateAll(array('OrderItem.order_id' => $order_id, 'OrderItem.invoice_no' => '"' . $invoice_no . '"', 'OrderItem.status' => 2, 'OrderItem.client_id' => $client_id, 'OrderItem.client_name' => "'" . $client['Client']['name'] . "'"), array('OrderItem.added_by' => $user['User']['username'],'OrderItem.order_id' => 0, 'OrderItem.invoice_no' => NULL, 'OrderItem.status' => 1, 'SUBSTRING(OrderItem.added_date,1,10)' => array(date('Y-m-d'), date('Y-m-d')))))
                        throw new Exception();
                    #update advance payment if amount is exist
                    if ($received_amount > 0) {
                        $this->loadModel('OrderPayment');
                        $this->request->data['OrderPayment']['added_by'] = $user['User']['username'];
                        $this->request->data['OrderPayment']['added_date'] = date('Y-m-d h:i:s');
                        $this->request->data['OrderPayment']['order_id'] = $order_id;
                        $this->request->data['OrderPayment']['invoice_no'] = $invoice_no;
                        $this->request->data['OrderPayment']['client_id'] = $client_id;
                        $this->request->data['OrderPayment']['client_name'] = $client['Client']['name'];
                        $this->request->data['OrderPayment']['bank_name'] = $this->request->data['Order']['bank_name'];
                        $this->request->data['OrderPayment']['payment_type'] = "Advance";
                        $this->request->data['OrderPayment']['branch_name'] = $this->request->data['Order']['branch_name'];
                        $this->request->data['OrderPayment']['received_amount'] = $received_amount;
                        $this->request->data['OrderPayment']['received_date'] = ($this->request->data['Order']['payment_date']) ? $this->request->data['Order']['payment_date'] : date('Y-m-d');
                        $this->request->data['OrderPayment']['remarks'] = $this->request->data['Order']['remarks'];
                        $this->OrderPayment->create();
                        if (!$this->OrderPayment->save($this->request->data['OrderPayment']))
                            throw new Exception();
                        
                        $this->loadModel('ClientBalance');
                        //conditions to find the existing client balance
                        $conditions = array(
                            'conditions' => array(
                                'ClientBalance.client_id' => $client_id
                            ),
                            'recursive' => -1// no relation with others table
                        );
                        //find the existing balece with client ID
                        $balance = $this->ClientBalance->find('first', $conditions);

                        
                            $this->ClientBalance->id = $balance['ClientBalance']['id'];
                            $balance = $balance['ClientBalance']['balance'] - $received_amount;
                            if (!$this->ClientBalance->saveField('balance', $balance))
                                throw new Exception();
                        
                    }

                    
                }
                $datasource->commit();
                $this->Session->setFlash(__('The payment history has been saved.'));
                return $this->redirect(array('action' => 'index'));
                
            } catch (Exception $e) {
                $datasource->rollback();
                $this->Session->setFlash(__('There was proble while saving your data. Please, try again.'));
            }
        }
        return $this->redirect(array('controller' => 'order_items', 'action' => 'add'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Order->exists($id)) {
            throw new NotFoundException(__('Invalid order'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Order->save($this->request->data)) {
                $this->Session->setFlash(__('The order has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The order could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
            $this->request->data = $this->Order->find('first', $options);
        }
        $clients = $this->Order->Client->find('list');
        $this->set(compact('clients'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException(__('Invalid order'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Order->delete()) {
            #delete all item against this order ID
            $this->loadModel('OrderItem');
            $this->OrderItem->deleteAll(array('OrderItem.order_id' => $id));
            #delete all payment against this order ID
            $this->loadModel('OrderPayment');
            $this->OrderPayment->deleteAll(array('OrderPayment.order_id' => $id));
            $this->Session->setFlash(__('The order has been deleted.'));
        } else {
            $this->Session->setFlash(__('The order could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
