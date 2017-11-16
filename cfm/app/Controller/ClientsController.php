<?php

App::uses('AppController', 'Controller');

/**
 * Clients Controller
 *
 * @property Client $Client
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ClientsController extends AppController {
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
        $this->Client->recursive = 0;
        $option=array('order'=>array('Client.name'=>"ASC"));
        $this->set('clients', $this->Client->find('all',$option));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $user = $this->Session->read('UserAuth');
            $this->request->data['Client']['added_by'] = $user['User']['username'];            
            $this->Client->create();
            if ($this->Client->save($this->request->data)) {
                $this->Session->setFlash(__('The client has been saved.'));
                return $this->redirect(array('action' => '/ '));
            } else {
                $this->Session->setFlash(__('The client could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Client->exists($id)) {
            throw new NotFoundException(__('Invalid client'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $user = $this->Session->read('UserAuth');
            $this->request->data['Client']['modified_by'] = $user['User']['username'];
            $this->request->data['Client']['modified_date'] = date('Y-m-d h:i:s');

            if ($this->Client->save($this->request->data)) {
                $this->Session->setFlash(__('The client has been saved.'));
                return $this->redirect(array('action' => '/ '));
            } else {
                $this->Session->setFlash(__('The client could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Client.' . $this->Client->primaryKey => $id));
            $this->request->data = $this->Client->find('first', $options);
        }
    }

}
