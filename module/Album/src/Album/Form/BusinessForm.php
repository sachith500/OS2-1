<?php
namespace Album\Form;

use Zend\Form\Form;

class BusinessForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('business');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'brn',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Business Registration No',
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Name',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}