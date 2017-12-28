<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;

Class ProductsForm extends Form
{
    public function initialize($entity = null, $options = []) {
        
        $partner_id = new Text("partner_id");
        $this->add($partner_id);
        
        $name = new Text("name");
        $this->add($name);
        
        $description = new Text("description");
        $this->add($description);
        
        $price = new Text("price");
        $this->add($price);
        
        $currency = new Text("currency");
        $this->add($currency);
        
        $availability = new Select("availability", ['y'=>'tak','n'=>'nie']);
        $this->add($availability);

    }
}
