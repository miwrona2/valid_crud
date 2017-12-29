<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;

use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\Uniqueness;

Class PartnersForm extends Form
{
    public function initialize($entity = null, $options = []) {
        
        if (!isset($options["edit"])) {
            $element = new Text("id");

            $element->setLabel("Id");

            $this->add(
                $element
            );
        } else {
            $this->add(
                new Hidden("id")
            );
        }
        
        $name = new Text("name");
        $name->setFilters(
            [
                'string',
                'striptags',
            ]
        );
        $this->add($name);
        
        $description = new Text("description");
        $description->setFilters(
            [
                'string',
                'striptags',
            ]
        );
        $this->add($description);
        
        $NIP = new Text("NIP");
        $NIP->addValidators(
            [
                new StringLength(
                    [
                        "min" => 10,
                        "max" => 10,
                            "messageMaximum" => "Please type in valid NIP (exactly 10 digits)",
                            "messageMinimum" => "Please type in valid NIP (exactly 10 digits)",
                    ]
                ),
                new Numericality(
                    [
                        'message' => "Accurate NIP contains only numerals"
                    ]
                ),
                new Uniqueness(
                    [
                        'message' => 'This NIP already exist'
                    ]
                )
            ]
        );
        $this->add($NIP);
        
        $webpage = new Text("webpage");
        $webpage->setFilters(
            [
                'string',
                'striptags',
            ]
        );
        $this->add($webpage);

    }
}
