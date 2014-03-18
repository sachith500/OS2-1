<?php
namespace Album\Form;

use Zend\Form\Form;

class OrderForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('order');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'order_no',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Order Number',
            ),
        ));
        $this->add(array(
            'name' => 'date',
            'attributes' => array(
                'type'  => 'date',
            ),
            'options' => array(
                'label' => 'Date',
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