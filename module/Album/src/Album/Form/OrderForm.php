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
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Order Number',
            ),
        ));
        //Dropdown menu to select the order type
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'order_type',
            'attributes' => array(
                'id' => 'order_type',
                'class'=>'form-control'
            ),
            'options' => array(
                'label' => 'Order Type',
                'value_options' => array(
                    '0' => 'Large Order',
                    '1' => 'Mail Order',
                    '2' => 'VIP',
                ),
            )
        ));
        $this->add(array(
            'name' => 'date',
            'attributes' => array(
                'type'  => 'date',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Date',
            ),
        ));
        $this->add(array(
            'name' => 'cid',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'CID',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class'=>'btn btn-default'
            ),
        ));
    }
}