<?php
namespace Album\Controller;

use Album\Model\CustomerTable;
use Album\Model\Customer;
use Album\Form\CustomerForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Controller\TestController;

class CustomerController extends AbstractActionController
{
    protected $customerTable;
    protected $testController;

    public function indexAction()
    {
        return new ViewModel(array(
            'customers' => $this->getCustomerTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new CustomerForm();
        $form->get('submit')->setValue('Add');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $customer = new Customer();
            $form->setInputFilter($customer->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $customer->exchangeArray($form->getData());
                $dropdown = $form->get('customer_type');
                $selection = $dropdown->getValue();
                $sm = $this->getServiceLocator();
                $testCon = new TestController();
                switch ($selection){
                    case 0:
                        //large order
                        $testCon->runSql(
                            'insert into '
                            . 'l_o_customers '
                            . 'values ("'
                            . $form->get('id')->getValue()              . '","'
                            . $form->get('CID')->getValue()             . '","'
                            . $form->get('credit_limit')->getValue()    . '","'
                            . $form->get('credit_balance')->getValue()  . '","'
                            . $form->get('brn')->getValue()             . '","'
                            . $form->get('emp_id')->getValue()
                            . '")',$sm);
                        break;
                    case 1:
                        //mail order
                        $testCon->runSql(
                            'insert into '
                            . 'mo_customers '
                            . 'values ("'
                            . $form->get('id')->getValue()    . '","'
                            . $form->get('CID')->getValue()   . '","'
                            . $form->get('email')->getValue() . '","'
                            . $form->get('trn')->getValue()
                            . '")',$sm);
                        break;
                    case 2:
                        //vip
                        $testCon->runSql(
                            'insert into '
                            . 'vip_customers '
                            . 'values ("'
                            . $form->get('id')->getValue()              . '","'
                            . $form->get('CID')->getValue()             . '","'
                            . $form->get('credit_limit')->getValue()    . '","'
                            . $form->get('credit_balance')->getValue()  . '","'
                            . $form->get('trn')->getValue()
                            . '")',$sm);
                        break;
                }

                $this->getCustomerTable()->saveCustomer($customer);
                // Redirect to list of customers
                return $this->redirect()->toRoute('customer');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            echo '!ID';
            return $this->redirect()->toRoute('customer', array(
                'action' => 'add'
            ));
        }
        $customer = $this->getCustomerTable()->getCustomer($id);

        $form  = new CustomerForm();
        $form->bind($customer);
        $form->get('submit')->setAttribute('value', 'Edit');
        $sm = $this->getServiceLocator();
        $testController = new TestController();
        $cid = $form->get('CID')->getValue();
        $query0 = 'select * from l_o_customers where cid = '. $cid;
        $resultSet0 = $testController->runSql($query0, $sm);
        $nlo= $resultSet0->count();
        $query1 = 'select * from mo_customers where cid = '. $cid;
        $resultSet1 = $testController->runSql($query1, $sm);
        $nmo= $resultSet1->count();
        $query2 = 'select * from vip_customers where cid = '. $cid;
        $resultSet2 = $testController->runSql($query2, $sm);
        $nvo= $resultSet2->count();

        $selection = 0;
        if ($nlo == 1)$selection = 0;
        if ($nmo == 1)$selection = 1;
        if ($nvo == 1)$selection = 2;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($customer->getInputFilter());
            $form->setData($request->getPost());


            $testController->runSql(
                'update '
                . 'customers '
                . 'set '
                . 'first_name = "' .$form->get('first_name')->getValue()              . '", '
                . 'middle_name = "' .$form->get('middle_name')->getValue()              . '", '
                . 'last_name = "' .$form->get('last_name')->getValue()              . '", '
                . 'street = "' .$form->get('street')->getValue()              . '", '
                . 'city = "' .$form->get('city')->getValue()              . '", '
                . 'CID = "' .$form->get('CID')->getValue()             . '", '
                . 'po_box = "' .$form->get('po_box')->getValue()
                .'" where CID = ' . $form->get('CID')->getValue()
                ,$sm);


                switch ($selection){
                    case 0:
                        //large order
                        $testController->runSql(
                            'update '
                            . 'l_o_customers '
                            . 'set '
                            . 'id = ' .$form->get('id')->getValue()              . ', '
                            . 'CID = ' .$form->get('CID')->getValue()             . ', '
                            . 'credit_limit = ' .$form->get('credit_limit')->getValue()    . ', '
                            . 'credit_balance = ' .$form->get('credit_balance')->getValue()  . ', '
                            . 'brn = ' .$form->get('brn')->getValue()             . ', '
                            . 'emp_id = ' .$form->get('emp_id')->getValue()
                            .' where CID = ' . $form->get('CID')->getValue()
                            ,$sm);
                        break;
                    case 1:
                        //large order
                        $testController->runSql(
                            'update '
                            . 'mo_customers '
                            . 'set '
                            . 'id = ' .$form->get('id')->getValue()              . ', '
                            . 'CID = ' .$form->get('CID')->getValue()             . ', '
                            . 'email = "' .$form->get('email')->getValue()    . '", '
                            . 'trn = ' .$form->get('trn')->getValue()
                            .' where CID = ' . $form->get('CID')->getValue()
                            ,$sm);
                        break;
                    case 2:
                        //large order
                        $testController->runSql(
                            'update '
                            . 'vip_customers '
                            . 'set '
                            . 'id = ' .$form->get('id')->getValue()              . ', '
                            . 'CID = ' .$form->get('CID')->getValue()             . ', '
                            . 'credit_limit = ' .$form->get('credit_limit')->getValue()    . ', '
                            . 'credit_balance = ' .$form->get('credit_balance')->getValue()  . ', '
                            . 'trn = ' .$form->get('trn')->getValue()
                            .' where CID = ' . $form->get('CID')->getValue()
                            ,$sm);
                        break;
                }
                // Redirect to list of albums
                return $this->redirect()->toRoute('customer');
        }



        if($_POST["saveClicked"] == 'Save'){
            $stash = $testController->runSql('INSERT INTO customer_contacts VALUES('.$id.','.$_POST["contact"].')', $this->getServiceLocator());
        }

        //echo $_POST["selectedNum"];

        if($_POST["clickedDel"] == 'YES'){
            $stash = $testController->runSql('DELETE FROM customer_contacts WHERE( contact_no='.$_POST["selectedNum"].')', $this->getServiceLocator());
        }
        if ($selection == 0)
            foreach ($resultSet0 as $row){// only one anyway
                $form->get('credit_limit')->setValue($row->credit_limit);
                $form->get('id')->setValue($row->id);
                $form->get('credit_balance')->setValue($row->credit_balance);
                $form->setAttribute('trn','NONE');
                $form->setAttribute('email','NONE');
                $form->get('brn')->setValue($row->brn);
                $form->get('emp_id')->setValue($row->emp_id);
            }
        if ($selection == 1)
            foreach ($resultSet1 as $row){// only one anyway
                $form->setAttribute('credit_limit','NONE');
                $form->get('id')->setValue($row->id);
                $form->setAttribute('credit_balance','NONE');
                $form->get('trn')->setValue($row->trn);
                $form->setAttribute('brn','NONE');
                $form->get('email')->setValue($row->email);
                $form->setAttribute('emp_id','NONE');
            }
        if ($selection == 2)
            foreach ($resultSet2 as $row){// only one anyway
                $form->get('credit_limit')->setValue($row->credit_limit);
                $form->get('id')->setValue($row->id);
                $form->get('trn')->setValue($row->TRN);
                $form->get('credit_balance')->setValue($row->credit_balance);
                $form->setAttribute('brn','NONE');
                $form->setAttribute('email','NONE');
                $form->setAttribute('emp_id','NONE');
            }


        return array(
            'CID' => $id,
            'form' => $form,
            'contacts' => $testController->runSql('SELECT * FROM customer_contacts WHERE CID ='.$id, $this->getServiceLocator()),
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        echo $id;
        if (!$id) {
            //return $this->redirect()->toRoute('business');
        }
        /*echo $business->brn;
        echo $business->name;*/

        $request = $this->getRequest();
        if ($request->isPost()) {
            echo 'isPOST';
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                //$id = (int) $request->getPost('id');
                echo $id;
                $this->getCustomerTable()->deleteCustomer($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('customer');
        }

        return array(
            'CID'    => $id,
            'customer' => $this->getCustomerTable()->getCustomer($id)
        );
    }

    public function getCustomerTable()
    {
        if (!$this->customerTable) {
            $sm = $this->getServiceLocator();
            $this->customerTable = $sm->get('Album\Model\CustomerTable');
        }
        return $this->customerTable;
    }
}
