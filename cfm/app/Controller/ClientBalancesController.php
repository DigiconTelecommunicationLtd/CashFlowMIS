<?php
App::uses('AppController', 'Controller');
/**
 * ClientBalances Controller
 *
 * @property ClientBalance $ClientBalance
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ClientBalancesController extends AppController {

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
		$this->ClientBalance->recursive = 0;
		$this->set('clientBalances', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            $this->autoRender=FALSE;
            $this->layout="ajax";
           $clientID=  $this->request->data['id'];
		$options = array('conditions' => array('ClientBalance.client_id'=>$clientID),'field'=>array('ClientBalance.balance'));
		$clientBalance= $this->ClientBalance->find('first', $options);
                
                $this->loadModel('PaymentHistory');
                $payment_history=  $this->PaymentHistory->find('first',array('conditions'=>array('PaymentHistory.client_id'=>$clientID),'field'=>array('PaymentHistory.payment_date','PaymentHistory.bank','PaymentHistory.branch'),'recursive'=>-1));
                
               echo $clientBalance['ClientBalance']['balance'].'#'.$payment_history['PaymentHistory']['payment_date'].'#'.$payment_history['PaymentHistory']['bank'].'#'.$payment_history['PaymentHistory']['branch'];
                
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ClientBalance->create();
			if ($this->ClientBalance->save($this->request->data)) {
				$this->Session->setFlash(__('The client balance has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client balance could not be saved. Please, try again.'));
			}
		}
		$clients = $this->ClientBalance->Client->find('list');
		$this->set(compact('clients'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ClientBalance->exists($id)) {
			throw new NotFoundException(__('Invalid client balance'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ClientBalance->save($this->request->data)) {
				$this->Session->setFlash(__('The client balance has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client balance could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ClientBalance.' . $this->ClientBalance->primaryKey => $id));
			$this->request->data = $this->ClientBalance->find('first', $options);
		}
		$clients = $this->ClientBalance->Client->find('list');
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
		$this->ClientBalance->id = $id;
		if (!$this->ClientBalance->exists()) {
			throw new NotFoundException(__('Invalid client balance'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ClientBalance->delete()) {
			$this->Session->setFlash(__('The client balance has been deleted.'));
		} else {
			$this->Session->setFlash(__('The client balance could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
