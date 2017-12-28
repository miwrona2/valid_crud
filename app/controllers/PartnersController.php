<?php

use Phalcon\Mvc\Controller;

class PartnersController extends Controller
{
    public function indexAction() {
        $partners_title = "List of Partners";
        $this->view->title = $partners_title;
    }
}
