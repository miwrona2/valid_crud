<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function indexAction() {
        $data = 'List of Products';
        $this->view->title = $data;  
    }
}
