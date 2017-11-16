<?php

App::uses('AppController', 'Controller');

/**
 * PaymentHistories Controller
 *
 * @property PaymentHistory $PaymentHistory
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class PaymentHistoriesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
  

    /**
     * index method
     *
     * @return void
     */
    public function index() {
      $this->Paginator->settings = array( 
          'order'=>array('PaymentHistory.payment_date'=>"DESC"),
        'limit' => 10
    );
        $this->PaymentHistory->recursive = 0;
        $this->set('paymentHistories', $this->Paginator->paginate());
    }
    public function payment_receive_history(){
         if ($this->request->is('post')) {
            if ($this->request->data['PaymentHistory']['start_date'] && $this->request->data['PaymentHistory']['end_date']) {
                $option['SUBSTRING(PaymentHistory.added_date,1,10) BETWEEN ? AND ?'] = array(date('Y-m-d', strtotime($start_date = $this->request->data['PaymentHistory']['start_date'])), date('Y-m-d', strtotime($end_date = $this->request->data['PaymentHistory']['end_date'])));
            }
           
            if ($this->request->data['PaymentHistory']['client_id']) {
                $option['PaymentHistory.client_id'] = $this->request->data['PaymentHistory']['client_id'];
            }
        } else {
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-t');
            $option['SUBSTRING(PaymentHistory.payment_date,1,10) BETWEEN ? AND ?'] = array($start_date, $end_date);
        }
        $conditions = array('conditions' => array($option), 'order' => array('PaymentHistory.id' => "DESC"));
        $this->PaymentHistory->recursive = 0;
        $paymentHistories= $this->PaymentHistory->find('all',$conditions);
        $clients = $this->PaymentHistory->Client->find('list');
        $this->set(compact('start_date','end_date','paymentHistories','clients'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     *//*
      public function view($id = null) {
      if (!$this->PaymentHistory->exists($id)) {
      throw new NotFoundException(__('Invalid payment history'));
      }
      $options = array('conditions' => array('PaymentHistory.' . $this->PaymentHistory->primaryKey => $id));
      $this->set('paymentHistory', $this->PaymentHistory->find('first', $options));
      }
     */

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->PaymentHistory->create();
            #client ID
            $client_id = $this->request->data['PaymentHistory']['client_id'];

            $new_amount = trim($this->request->data['PaymentHistory']['amount']);
            $new_amount = ($new_amount) ? $new_amount : 0.00;
            #get the datasource
            $datasource = $this->PaymentHistory->getDataSource();
            try {
                //datatransact begin here..
                $datasource->begin();
                //check the payment saved in payment history table
                $user = $this->Session->read('UserAuth');
                $UserID = $user['User']['username'];
                $this->request->data['PaymentHistory']['added_by'] = $UserID;
                $this->request->data['PaymentHistory']['added_date'] = date('Y-m-d');
                $this->request->data['PaymentHistory']['payment_date'] = date('Y-m-d', strtotime($this->request->data['PaymentHistory']['payment_date']));

                if ($this->PaymentHistory->save($this->request->data)) {
                    //load the client balance model
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

                    if ($balance && $balance['ClientBalance']['client_id']) { //if balance exist with client ID then update otherwise insert into table
                        $this->ClientBalance->id = $balance['ClientBalance']['id'];
                        $balance = $balance['ClientBalance']['balance'] + $new_amount;
                        if (!$this->ClientBalance->saveField('balance', $balance))
                            throw new Exception();
                    }
                    else {
                        //insert data
                        $this->request->data['ClientBalance']['client_id'] = $client_id;
                        $this->request->data['ClientBalance']['balance'] = $new_amount;
                        if (!$this->ClientBalance->save($this->request->data['ClientBalance']))
                            throw new Exception();
                    }
                }
                $datasource->commit();
                $this->Session->setFlash(__('The payment history has been saved.'));
                return $this->redirect(array('action' => ' /'));
            } catch (Exception $e) {
                $datasource->rollback();
                $this->Session->setFlash(__('The payment history could not be saved. Please, try again.'));
            }
        }
        $clients = $this->PaymentHistory->Client->find('list');
        $this->set(compact('clients'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    /*
      public function edit($id = null) {
      if (!$this->PaymentHistory->exists($id)) {
      throw new NotFoundException(__('Invalid payment history'));
      }
      if ($this->request->is(array('post', 'put'))) {
      #client ID
      $client_id = $this->request->data['PaymentHistory']['client_id'];
      #editing payment history id
      $id = $this->request->data['PaymentHistory']['id'];
      $existing_payment_history = $this->PaymentHistory->find('first', array('conditions' => array('PaymentHistory.id' => $id), 'recursive' => -1));
      $old_client_id = $existing_payment_history['PaymentHistory']['client_id'];

      $new_amount = trim($this->request->data['PaymentHistory']['amount']);
      $new_amount = ($new_amount) ? $new_amount : 0.00;
      #get the datasource
      $datasource = $this->PaymentHistory->getDataSource();
      try {
      //datatransact begin here..
      $datasource->begin();
      $user = $this->Session->read('UserAuth');
      $UserID = $user['User']['username'];
      $this->request->data['PaymentHistory']['modified_by'] = $UserID;
      $this->request->data['PaymentHistory']['modified_date'] = date('Y-m-d');
      $this->request->data['PaymentHistory']['payment_date'] = date('Y-m-d', strtotime($this->request->data['PaymentHistory']['payment_date']));
      if ($this->PaymentHistory->save($this->request->data)) {
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
      $balance = $balance['ClientBalance']['balance'] + $new_amount - $existing_payment_history['PaymentHistory']['amount'];
      if (!$this->ClientBalance->saveField('balance', $balance))
      throw new Exception();
      } else {
      $this->Session->setFlash(__('The payment history could not be saved. Please, try again.'));
      }
      $datasource->commit();
      $this->Session->setFlash(__('The payment history has been saved.'));
      return $this->redirect(array('action' => ' /'));
      } catch (Exception $e) {
      $datasource->rollback();
      $this->Session->setFlash(__('The payment history could not be saved. Please, try again.'));
      }
      } else {
      $options = array('conditions' => array('PaymentHistory.' . $this->PaymentHistory->primaryKey => $id));
      $this->request->data = $this->PaymentHistory->find('first', $options);
      }
      $clients = $this->PaymentHistory->Client->find('list');
      $this->set(compact('clients'));
      }
     */

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->PaymentHistory->id = $id;
        if (!$this->PaymentHistory->exists()) {
            throw new NotFoundException(__('Invalid payment history'));
        }
        $this->request->allowMethod('post', 'delete');
        $existing_payment_history = $this->PaymentHistory->find('first', array('conditions' => array('PaymentHistory.id' => $id), 'recursive' => -1));
        $client_id = $existing_payment_history['PaymentHistory']['client_id'];
        $datasource = $this->PaymentHistory->getDataSource();
        try {
            //datatransact begin here..
            $datasource->begin();
            if ($this->PaymentHistory->delete()) {
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
                $balance = $balance['ClientBalance']['balance'] - $existing_payment_history['PaymentHistory']['amount'];
                if (!$this->ClientBalance->saveField('balance', $balance))
                    throw new Exception();
                $this->Session->setFlash(__('The payment history has been deleted.'));
            } else {
                $this->Session->setFlash(__('The payment history could not be deleted. Please, try again.'));
            }

            $datasource->commit();
            $this->Session->setFlash(__('The payment history has been deleted and balance has been adjusted'));
            return $this->redirect(array('action' => ' /'));
        } catch (Exception $e) {
            $datasource->rollback();
            $this->Session->setFlash(__('The payment history could not be saved. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
