<?php

use Phalcon\Mvc\Controller;

class PartnersController extends Controller
{
    public function indexAction() {
        
        $partners_title = "List of Partners";
        $this->view->title = $partners_title;
        
        $partners = Partners::find(['order' => 'id']);
        $this->view->partners = $partners;
    }
    
    public function formCreateAction() {
        $this->view->form = new PartnersForm();
    }
    
    public function createAction() {
        
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "partners",
                    "action"     => "index",
                ]
            );
        }
        
        $form = new PartnersForm();

        $partner = new Partners();

        $data = $this->request->getPost();
    
        if (!$form->isValid($data, $partner)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(
                [
                    "controller" => "partners",
                    "action"     => "formCreate",
                ]
            );
        }
        
        if ($partner->save() == false) {
            foreach ($partner->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(
                [
                    "controller" => "partners",
                    "action"     => "formCreate",
                ]
            );
        }

        $form->clear();

        $this->flash->success("Partner was created successfully");


        return $this->dispatcher->forward(
            [
                "controller" => "partners",
                "action"     => "index",
            ]
        );
    }
}
