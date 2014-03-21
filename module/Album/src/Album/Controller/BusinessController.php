<?php
namespace Album\Controller;

use Album\Model\BusinessTable;
use Album\Model\Business;
use Album\Form\BusinessForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Controller\TestController;

class BusinessController extends AbstractActionController
{
    protected $businessTable;
    protected $testController;

    public function indexAction()
    {
        return new ViewModel(array(
            'businesses' => $this->getBusinessTable()->fetchAll(),
        ));
    }

    public function addAction()
    {

        $form = new BusinessForm();
        $form->get('submit')->setValue('Add');
        echo 'submit button name changed to Add';
        $request = $this->getRequest();
       // echo 'getRequest()';
        if ($request->isPost()) {
            echo 'inside if';

            $business = new Business();
            $form->setInputFilter($business->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                //echo 'inside isvalid';
                $business->exchangeArray($form->getData());
                $this->getBusinessTable()->saveBusiness($business, 0);

                // Redirect to list of albums
                return $this->redirect()->toRoute('business');
            }
         }
        //echo 'outside if';
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        //echo $id;

        if (!$id) {
            echo '!ID';
            return $this->redirect()->toRoute('business', array(
                'action' => 'add'
            ));
        }
        $business = $this->getBusinessTable()->getBusiness($id);

        $form  = new BusinessForm();
        $form->bind($business);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($business->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getBusinessTable()->saveBusiness($form->getData(), 1);

                // Redirect to list of albums
                return $this->redirect()->toRoute('business');
            }
        }

        $testController = new TestController();

        if($_POST["saveClicked"] == 'Save'){
            $stash = $testController->runSql('INSERT INTO business_contacts VALUES('.$id.','.$_POST["contact"].')', $this->getServiceLocator());
        }

        //echo $_POST["selectedNum"];

        if($_POST["clickedDel"] == 'YES'){
        $stash = $testController->runSql('DELETE FROM business_contacts WHERE( contact_no='.$_POST["selectedNum"].')', $this->getServiceLocator());
        }

        return array(
            'brn' => $id,
            'form' => $form,
            'contacts' => $testController->runSql('SELECT * FROM business_contacts WHERE brn ='.$id, $this->getServiceLocator()),
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        //echo $id;
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
                $this->getBusinessTable()->deleteBusiness($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('business');
        }

        return array(
            'brn'    => $id,
            'business' => $this->getBusinessTable()->getBusiness($id)
        );
    }

    public function getBusinessTable()
    {
        if (!$this->businessTable) {
            $sm = $this->getServiceLocator();
            $this->businessTable = $sm->get('Album\Model\BusinessTable');
        }
        return $this->businessTable;
    }
}