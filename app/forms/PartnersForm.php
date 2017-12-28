<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;

Class PartnersForm extends Form
{
    public function initialize($entity = null, $options = []) {
        
        $name = new Text("name");
        $this->add($name);
        
        $description = new Text("description");
        $this->add($description);
        
        $NIP = new Text("NIP");
        $this->add($NIP);
        
        $webpage = new Text("webpage");
        $this->add($webpage);

    }
}
