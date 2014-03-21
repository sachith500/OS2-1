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

        /*testing DB Code*/



        /*End testing DB Code*/
        $form = new CustomerForm();
        $form->get('submit')->setValue('Add');
        //echo 'submit button name changed to Add';
        $request = $this->getRequest();
        // echo 'getRequest()';
        if ($request->isPost()) {
            echo 'inside if';

            $customer = new Customer();
            $form->setInputFilter($customer->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                //echo 'inside isvalid';
                $customer->exchangeArray($form->getData());
                $this->getCustomerTable()->saveCustomer($customer);

                // Redirect to list of albums
                return $this->redirect()->toRoute('customer');
            }
        }
        //echo 'outside if';
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        echo $id;

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

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($customer->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getCustomerTable()->saveCustomer($form->getData());

                // Redirect to list of albums
                return $this->redirect()->toRoute('customer');
            }
        }

        $testController = new TestController();

        if($_POST["saveClicked"] == 'Save'){
            $stash = $testController->runSql('INSERT INTO customer_contacts VALUES('.$id.','.$_POST["contact"].')', $this->getServiceLocator());
        }

        //echo $_POST["selectedNum"];

        if($_POST["clickedDel"] == 'YES'){
            $stash = $testController->runSql('DELETE FROM customer_contacts WHERE( contact_no='.$_POST["selectedNum"].')', $this->getServiceLocator());
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