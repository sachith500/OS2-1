<?php
namespace Album\Form;

use Zend\Form\Form;

class ContactForm extends Form{
    public function _construct($name = null){
        parent::_construct('contact');
        $this->setAttribute('method','post');

        $this->add(array(
            'name' => 'CID',
            'attributes' => array(
                'type' => 'hidden',
            ),
            'options' => array(
                'label' => 'Customer ID',
            ),
        ));

        $this->add(array(
            'name' => 'CID',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Customer ID',
            ),
        ));
    }
}