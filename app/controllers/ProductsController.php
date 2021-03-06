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
     * just a view for creating new products
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
                    "controller" => "products",
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

        $this->flash->success("Product has been created successfully");


        return $this->dispatcher->forward(
            [
                "controller" => "products",
                "action"     => "index",
            ]
        );
        
    }
    
    public function deleteAction($id) {
        
        $product = Products::findFirstById($id);
        
        if(!$product) {
            $this->flash->error("Couldn't find a product with this id");
            return $this->dispatcher->forward([
                "controller" => "products",
                "action" => "index",
            ]);
        }
        
        if (!$product->delete()) {
            foreach ($product->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(
                [
                    "controller" => "product",
                    "action"     => "index",
                ]
            );
        }
        
        $this->flash->success("Product has been deleted");
        
        return $this->dispatcher->forward(
            [
                "controller" => "products",
                "action"     => "index",
            ]
        );
        
    }
    
    /**
     * this function is only first step of editing
     * saving edited date into database handles function: saveAction() below
     */
    public function editAction($id) {
        if (!$this->request->isPost()) {
            $product = Products::findFirstById($id);

            if (!$product) {
                $this->flash->error(
                    "Product was not found"
                );

                return $this->dispatcher->forward(
                    [
                        "controller" => "products",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new ProductsForm(
                $product,
                [
                    "edit" => true,
                ]
            );
        }
    }   
    
    /**
     * Updates a product based on the data entered in the editAction() above
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "products",
                    "action"     => "index",
                ]
            );
        }

        $id = $this->request->getPost("id", "int");

        $product = Products::findFirstById($id);

        if (!$product) {
            $this->flash->error(
                "Product does not exist"
            );

            return $this->dispatcher->forward(
                [
                    "controller" => "products",
                    "action"     => "index",
                ]
            );
        }

        $form = new ProductsForm();

        $data = $this->request->getPost();

        if (!$form->isValid($data, $product)) {
            $messages = $form->getMessages();

            foreach ($messages as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "product",
                    "action"     => "create",
                ]
            );
        }

        if ($product->save() === false) {
            $messages = $product->getMessages();

            foreach ($messages as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "products",
                    "action"     => "create",
                ]
            );
        }

        $form->clear();

        $this->flash->success(
            "Product has been updated successfully"
        );

        return $this->dispatcher->forward(
            [
                "controller" => "products",
                "action"     => "index",
            ]
        );
    }
}
