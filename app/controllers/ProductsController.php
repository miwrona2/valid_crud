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
}
