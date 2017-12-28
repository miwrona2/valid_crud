<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;

use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Uniqueness;

Class ProductsForm extends Form
{
    public function initialize($entity = null, $options = []) {
        
        $partner_id = new Select("partner_id", Partners::find(),
            [
                'using' => ['id', 'name']
            ]);
        $this->add($partner_id);
        
        $name = new Text("name");
               $name->addValidators(
            [
                new Uniqueness(
                    [
                        'message' => 'This name already exists'
                    ]
                )
            ]
        );
        $this->add($name);
        
        $description = new Text("description");
        $this->add($description);
        
        $price = new Text("price");
        $price->addValidators([
            new PresenceOf([
                'message' => 'Price is required'
            ]),
            new Numericality([
                'message' => 'Price must be a number'
            ])
        ]);
        $this->add($price);
        
        $currency = new Select("currency",[
            "PLN" => 'zł',
            "EUR" => '&#128',
            "USD" => '&#36',
            "GBP" => '&pound'
        ]);
        $this->add($currency);
        
        $availability = new Select("availability", ['y'=>'tak','n'=>'nie']);
        $this->add($availability);

    }
}
