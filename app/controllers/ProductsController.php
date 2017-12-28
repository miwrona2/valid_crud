<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function indexAction() {
        $data = 'List of Products';
        $this->view->title = $data;  
        $products = Products::find(['order' => 'id']);
        $this->view->products = $products;
    }
    
    /**
     * just a view for creating new proudcts
     * real action happens in createAction() below
     */
    public function formCreateAction() {
        $this->view->form = new ProductsForm();
    }
    
    /*
     * view in formCreateAction() above
     */
    public function createAction() {
        
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "products",
                    "action"     => "index",
                ]
            );
        }
        
        $form = new ProductsForm();
        $product = new Products();
        $data = $this->request->getPost();

        if (!$form->isValid($data, $product)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(
                [
                    "controller" => "product",
                    "action"     => "formCreate",
                ]
            );
        }
        
        if ($product->save() == false) {
            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(
                [
                    "controller" => "products",
                    "action"     => "formCreate",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Product was created successfully");


        return $this->dispatcher->forward(
            [
                "controller" => "products",
                "action"     => "index",
            ]
        );
        
    }
}
