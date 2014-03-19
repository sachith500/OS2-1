<?php
namespace Album\Form;

use Zend\Form\Form;

class PsrForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('psr');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'emp_id',
            'attributes' => array(
                'type'  => 'text',
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
            'name' => 'po_box',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'PO Box',
            ),
        ));
        $this->add(array(
            'name' => 'street',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Street',
            ),
        ));
        $this->add(array(
            'name' => 'city',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'City',
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