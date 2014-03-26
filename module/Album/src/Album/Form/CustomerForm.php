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
                'class' =>'form-control'
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
                'class' =>'form-control',
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
                'class' =>'form-control',
            ),
            'options' => array(
                'label' => 'First Name',
            ),
        ));

        $this->add(array(
            'name' => 'middle_name',
            'attributes' => array(
                'type'  => 'text',
                'class' =>'form-control',
            ),
            'options' => array(
                'label' => 'Middle Name',
            ),
        ));

        $this->add(array(
            'name' => 'last_name',
            'attributes' => array(
                'type'  => 'text',
                'class' =>'form-control',
            ),
            'options' => array(
                'label' => 'Last Name',
            ),
        ));

        $this->add(array(
            'name' => 'po_box',
            'attributes' => array(
                'type'  => 'text',
                'class' =>'form-control',
            ),
            'options' => array(
                'label' => 'PO Box',
            ),
        ));

        $this->add(array(
            'name' => 'street',
            'attributes' => array(
                'type'  => 'text',
                'class' =>'form-control',
            ),
            'options' => array(
                'label' => 'Street',
            ),
        ));

        $this->add(array(
            'name' => 'city',
            'attributes' => array(
                'type'  => 'text',
                'class' =>'form-control',
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
                'class' =>'btn btn-default  ',
            ),
        ));

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'text',
                'class' =>'form-control',
                //'class' => 'largeorder'
            ),
            'options' => array(
                'label' => 'ID',
                'label_attributes' => array(

                    //'class'  => 'largeorder'
                ),
            ),
        ));


        //Large order fields
        $this->add(array(
            'name' => 'credit_limit',
            'attributes' => array(
                'type'  => 'text',
                'class'  => 'largeordervip form-control'
            ),
            'options' => array(
                'label' => 'Credit Limit',
                'label_attributes' => array(
                    'class'  => 'largeordervip'
                ),
            ),
        ));
        $this->add(array(
            'name' => 'credit_balance',
            'attributes' => array(
                'type'  => 'text',
                'class'  => 'largeordervip form-control'
            ),
            'options' => array(
                'label' => 'Credit Balance',
                'label_attributes' => array(
                    'class'  => 'largeordervip'
                ),
            ),
        ));
        $this->add(array(
            'name' => 'brn',
            'attributes' => array(
                'type'  => 'text',
                'class'  => 'largeorder form-control'
            ),
            'options' => array(
                'label' => 'Business Registration Number',
                'label_attributes' => array(
                    'class'  => 'largeorder'
                ),
            ),
        ));
        $this->add(array(
            'name' => 'emp_id',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'largeorder form-control'
            ),
            'options' => array(
                'label' => 'Employee ID',
                'label_attributes' => array(
                    'class'  => 'largeorder'
                ),
            ),
        ));

        //Mail order fields
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
                'class'  => 'mailorder form-control'
            ),
            'options' => array(
                'label' => 'Email Address',
                'label_attributes' => array(
                    'class'  => 'mailorder'
                ),
            ),
        ));

        $this->add(array(
            'name' => 'trn',
            'attributes' => array(
                'type'  => 'text',
                'class'  => 'mailordervip form-control'
            ),
            'options' => array(
                'label' => 'Transaction Registration Number',
                'label_attributes' => array(
                    'class'  => 'mailordervip'
                ),
            ),
        ));
    }
}