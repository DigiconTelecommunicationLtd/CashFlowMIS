<?php

App::uses('AppController', 'Controller');

/**
 * Products Controller
 *
 * @property Product $Product
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ProductsController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Product->recursive = 0;
        $option = array('order' => array('Product.product_category_id' => "ASC", 'Product.name' => "ASC"));
        $this->set('products', $this->Product->find('all', $option));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $user = $this->Session->read('UserAuth');
            $this->request->data['Product']['added_by'] = $user['User']['username'];
            $this->Product->create();
            if ($this->Product->save($this->request->data)) {
                $this->Session->setFlash(__('The product has been saved.'));
                return $this->redirect(array('controller' => 'products', 'action' => '/ '));
            } else {
                $this->Session->setFlash(__('The product could not be saved. Please, try again.'));
            }
        }
        $productCategories = $this->Product->ProductCategory->find('list');
        $this->set(compact('productCategories'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Product->exists($id)) {
            throw new NotFoundException(__('Invalid product'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $user = $this->Session->read('UserAuth');
            $this->request->data['Product']['modified_by'] = $user['User']['username'];
            $this->request->data['Product']['modified_date'] = date('Y-m-d h:i:s');
            if ($this->Product->save($this->request->data)) {
                $this->Session->setFlash(__('The product has been saved.'));
                return $this->redirect(array('action' => '/ '));
            } else {
                $this->Session->setFlash(__('The product could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
            $this->request->data = $this->Product->find('first', $options);
        }
        $productCategories = $this->Product->ProductCategory->find('list');
        $this->set(compact('productCategories'));
    }

    public function getByCategory() {
        $product_category_id = $this->request->data['ContractProduct']['product_category_id'];

        $product_categories = $this->Product->find('list', array(
            'conditions' => array('Product.product_category_id' => $product_category_id),
            'recursive' => -1
        ));

        $this->set('product_categories', $product_categories);
        $this->layout = 'ajax';
    }
    
    public function product_by_category()
    {
         $this->layout = 'ajax';
         
         $product_category_id = $this->request->data['product_category_id'];
         
         $product_categories = $this->Product->find('list', array(
            'conditions' => array('Product.product_category_id' => $product_category_id),
            'recursive' => -1
        ));
         
        $this->set('product_categories', $product_categories);
        $this->render('get_by_category'); 
         
    }

}
