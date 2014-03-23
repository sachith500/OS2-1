<?php
namespace Album\Form;

use Zend\Form\Form;

class CustomerForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('customer');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'CID',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Customer ID',
            ),
        ));
        //Dropdown menu to select the customer type
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'customer_type',
            'attributes' => array(
                'id' => 'customer_type',
            ),
            'options' => array(
            'label' => 'Customer Type',
            'value_options' => array(
                '0' => 'Large Order',
                '1' => 'Mail Order',
                '2' => 'VIP',
                ),
            )
        ));

        $this->add(array(
            'name' => 'first_name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'First Name',
            ),
        ));

        $this->add(array(
            'name' => 'middle_name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Middle Name',
            ),
        ));

        $this->add(array(
            'name' => 'last_name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Last Name',
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


        //Large order fields
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'largeorder'
            ),
            'options' => array(
                'label' => 'ID',
            ),
        ));
        $this->add(array(
            'name' => 'credit_Limit',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'largeorder'
            ),
            'options' => array(
                'label' => 'Credit Limit',
            ),
        ));
        $this->add(array(
            'name' => 'credit_Balance',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'largeorder'
            ),
            'options' => array(
                'label' => 'Credit Balance',
            ),
        ));
        $this->add(array(
            'name' => 'brn',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'largeorder'
            ),
            'options' => array(
                'label' => 'BusinessRegistration Number',
            ),
        ));
        $this->add(array(
            'name' => 'emp_id',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'largeorder'
            ),
            'options' => array(
                'label' => 'Employee ID',
            ),
        ));
    }
}