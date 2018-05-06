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
        
    /**
     * just a view for creating new products
     * real action happens in createAction() below
     */
    public function formCreateAction() {
        $this->view->form = new PartnersForm();
    }
    
    /*
     * view in formCreateAction() above
     */
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

        $this->flash->success("Partner has been created successfully");


        return $this->dispatcher->forward(
            [
                "controller" => "partners",
                "action"     => "index",
            ]
        );
    }
    
    public function deleteAction($id) {
        
        $partner = Partners::findFirstById($id);
        
        if(!$partner) {
            $this->flash->error("Couldn't find a partner with this id");
            return $this->dispatcher->forward([
                "controller" => "partners",
                "action" => "index",
            ]);
        }
        
        if (!$partner->delete()) {
            foreach ($partner->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(
                [
                    "controller" => "partner",
                    "action"     => "index",
                ]
            );
        }
        
        $this->flash->success("Partner has been deleted");
        
        return $this->dispatcher->forward(
            [
                "controller" => "partners",
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
            $partner = Partners::findFirstById($id);

            if (!$partner) {
                $this->flash->error(
                    "Partner was not found"
                );

                return $this->dispatcher->forward(
                    [
                        "controller" => "partners",
                        "action"     => "index",
                    ]
                );
            }

            $this->view->form = new PartnersForm(
                $partner,
                [
                    "edit" => true,
                ]
            );
        }
    }
    
    /**
     * Updates a partner based on the data entered in the editAction()
     */
    public function saveAction(){
       
        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                [
                    "controller" => "partners",
                    "action"     => "index",
                ]
            );
        }
        
        $id = $this->request->getPost("id", "int");
        $partner = Partners::findFirstById($id);
        if (!$partner) {
            $this->flash->error("Partner does not exist");
            return $this->dispatcher->forward(
                [
                    "controller" => "partners",
                    "action"     => "index",
                ]
            );
        }
        
        $form = new PartnersForm;
        $this->view->form = $form;
        $data = $this->request->getPost();
        
        if (!$form->isValid($data, $partner)) {
            $messages = $form->getMessages();

            foreach ($messages as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                [
                    "controller" => "partners",
                    "action"     => "edit",
                    "params"     => [$id]
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
                    "action"     => "edit",
                    "params"     => [$id]
                ]
            );
        }
        $form->clear();
        $this->flash->success("Partner has been updated successfully");
 
        return $this->dispatcher->forward(
            [
                "controller" => "partners",
                "action"     => "index",
            ]
        );
        
    }

    public function descriptionAction()
    {
        $partners = Partners::find();

        foreach ($partners as $partner) {
            $this->view->pId = $partner->id;
        }

        $description = Partners::findFirst()->description;
        $this->view->description = $description;
    }
}
