<?php

App::uses('AppController', 'Controller');

/**
 * OrderPayments Controller
 *
 * @property OrderPayment $OrderPayment
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class OrderPaymentsController extends AppController {

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
            if ($this->request->data['OrderPayment']['start_date'] && $this->request->data['OrderPayment']['end_date']) {
                $option['SUBSTRING(OrderPayment.added_date,1,10) BETWEEN ? AND ?'] = array(date('Y-m-d', strtotime($start_date = $this->request->data['OrderPayment']['start_date'])), date('Y-m-d', strtotime($end_date = $this->request->data['OrderPayment']['end_date'])));
            }
            if ($this->request->data['OrderPayment']['invoice_no']) {
                $option['OrderPayment.invoice_no'] = $this->request->data['OrderPayment']['invoice_no'];
            }
            if ($this->request->data['OrderPayment']['client_id']) {
                $option['OrderPayment.client_id'] = $this->request->data['OrderPayment']['client_id'];
            }
        } else {
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-t');
            $option['SUBSTRING(OrderPayment.received_date,1,10) BETWEEN ? AND ?'] = array($start_date, $end_date);
        }
        $conditions = array('conditions' => array($option), 'order' => array('OrderPayment.id' => "DESC"));
        $this->OrderPayment->recursive = -1;
        $orderPayments = $this->OrderPayment->find('all', $conditions);
        $clients = $this->OrderPayment->Client->find('list');
        #summation
        $conditions = array('conditions' => array($option), 'fields' => array(
                'SUM(OrderPayment.received_amount) received_amount',
                'SUM(OrderPayment.ait) ait',
                'SUM(OrderPayment.vat) vat',
                'SUM(OrderPayment.ld) ld',
                'SUM(OrderPayment.other_deduction) other_deduction',
        ));
        $this->OrderPayment->recursive = -1;
        $collection_sum = $this->OrderPayment->find('first', $conditions);
        $this->set(compact('orderPayments', 'start_date', 'end_date', 'clients', 'collection_sum'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->OrderPayment->exists($id)) {
            throw new NotFoundException(__('Invalid order payment'));
        }
        $options = array('conditions' => array('OrderPayment.' . $this->OrderPayment->primaryKey => $id));
        $this->set('orderPayment', $this->OrderPayment->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($id = null) {
        if ($this->request->is('post')) {
            $this->OrderPayment->create();
            $user = $this->Session->read('UserAuth');
            $this->request->data['OrderPayment']['added_by'] = $user['User']['username'];
            $this->request->data['OrderPayment']['added_date'] = date('Y-m-d h:i:s');
            $id = $this->request->data['OrderPayment']['order_id'];
            $amount = 0;
            $received_amount = trim($this->request->data['OrderPayment']['received_amount']);
            $ait = trim($this->request->data['OrderPayment']['ait']);
            $vat = trim($this->request->data['OrderPayment']['vat']);
            $ld = trim($this->request->data['OrderPayment']['ld']);
            $other_deduction = trim($this->request->data['OrderPayment']['other_deduction']);

            $amount = $received_amount + $ait + $vat + $ld + $other_deduction;

            $client_id = $this->request->data['OrderPayment']['client_id'];
            #get the datasource
            $datasource = $this->OrderPayment->getDataSource();
            try {
                //datatransact begin here..
                $datasource->begin();
                if ($this->OrderPayment->save($this->request->data)) {
                    $this->loadModel('Order');
                    $options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id), 'recursive' => -1);
                    $this->request->data = $this->Order->find('first', $options);

                    $this->request->data['Order']['received_amount']+=$received_amount;
                    $this->request->data['Order']['ait']+=$ait;
                    $this->request->data['Order']['vat']+=$vat;
                    $this->request->data['Order']['ld']+=$ld;
                    $this->request->data['Order']['other_deduction']+=$other_deduction;
                    $this->request->data['Order']['balance'] = $this->request->data['Order']['net_amount'] - ($this->request->data['Order']['received_amount'] + $this->request->data['Order']['ait'] + $this->request->data['Order']['vat'] + $this->request->data['Order']['ld'] + $this->request->data['Order']['other_deduction']);
                    $this->Order->id = $id;
                    if (!$this->Order->save($this->request->data['Order']))
                        throw new Exception();

                    $this->loadModel('ClientBalance');
                    $conditions = array(
                        'conditions' => array(
                            'ClientBalance.client_id' => $client_id
                        ),
                        'recursive' => -1// no relation with others table
                    );
                    //find the existing balece with client ID
                    $balance = $this->ClientBalance->find('first', $conditions);
                    $this->ClientBalance->id = $balance['ClientBalance']['id'];
                    $balance = $balance['ClientBalance']['balance'] - $amount;
                    if (!$this->ClientBalance->saveField('balance', $balance))
                        throw new Exception();
                } else {
                    $this->Session->setFlash(__('The payment could not be saved. Please, try again.'));
                    return $this->redirect(array('action' => 'add', $id));
                }
                $datasource->commit();
                $this->Session->setFlash(__('The payment has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } catch (Exception $e) {
                $datasource->rollback();
                $this->Session->setFlash(__('The payment could not be saved. Please, try again.'));
            }
        }
        $option = array('conditions' => array('Order.id' => $id), 'recursive' => -1);
        $orders = $this->OrderPayment->Order->find('first', $option);
        #echo '<pre>';print_r($orders);exit;
        #Client Payment 
        $this->loadModel('ClientBalance');
        $clientID = $orders['Order']['client_id'];
        $options = array('conditions' => array('ClientBalance.client_id' => $clientID), 'field' => array('ClientBalance.balance'));
        $clientBalance = $this->ClientBalance->find('first', $options);

        $this->loadModel('PaymentHistory');
        $payment_history = $this->PaymentHistory->find('first', array('conditions' => array('PaymentHistory.client_id' => $clientID), 'field' => array('PaymentHistory.payment_date', 'PaymentHistory.bank', 'PaymentHistory.branch'), 'recursive' => -1));
        #echo '<pre>';print_r($payment_history);exit;
        $clients = $this->OrderPayment->Client->find('list');
        $this->set(compact('orders', 'clients', 'id', 'clientBalance', 'payment_history'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->OrderPayment->exists($id)) {
            throw new NotFoundException(__('Invalid order payment'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->OrderPayment->save($this->request->data)) {
                $this->Session->setFlash(__('The order payment has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The order payment could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('OrderPayment.' . $this->OrderPayment->primaryKey => $id));
            $this->request->data = $this->OrderPayment->find('first', $options);
        }
        $orders = $this->OrderPayment->OrderPayment->find('list');
        $clients = $this->OrderPayment->Client->find('list');
        $this->set(compact('orders', 'clients'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->OrderPayment->id = $id;
        if (!$this->OrderPayment->exists()) {
            throw new NotFoundException(__('Invalid order payment'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->OrderPayment->delete()) {
            $this->Session->setFlash(__('The order payment has been deleted.'));
        } else {
            $this->Session->setFlash(__('The order payment could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
