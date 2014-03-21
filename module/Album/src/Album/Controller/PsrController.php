<?php
namespace Album\Controller;

use Album\Model\PsrTable;
use Album\Model\Psr;
use Album\Form\PsrForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Controller\TestController;

class PsrController extends AbstractActionController
{
    protected $psrTable;
    protected $testController;

    public function indexAction()
    {
        return new ViewModel(array(
            'psrs' => $this->getPsrTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new PsrForm();
        $form->get('submit')->setValue('Add');
        //echo 'submit button name changed to Add';
        $request = $this->getRequest();
        // echo 'getRequest()';
        if ($request->isPost()) {
           // echo 'inside if';

            $psr = new Psr();
            $form->setInputFilter($psr->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                //echo 'inside isvalid';
                $psr->exchangeArray($form->getData());
                $this->getPsrTable()->savePsr($psr);

                // Redirect to list of albums
                return $this->redirect()->toRoute('psr');
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
            echo 'ID';
            return $this->redirect()->toRoute('psr', array(
                'action' => 'add'
            ));
        }

        $psr = $this->getPsrTable()->getPsr($id);

        //echo 'asdas';
        $form  = new PsrForm();
        $form->bind($psr);

        $form->get('submit')->setAttribute('value', 'Edit');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($psr->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getPsrTable()->savePsr($form->getData());

                // Redirect to list of albums
                return $this->redirect()->toRoute('psr');
            }
        }
        $testController = new TestController();

        if($_POST["saveClicked"] == 'Save'){
            $stash = $testController->runSql('INSERT INTO psr_contacts VALUES('.$id.','.$_POST["contact"].')', $this->getServiceLocator());
        }

        //echo $_POST["selectedNum"];

        if($_POST["clickedDel"] == 'YES'){
            $stash = $testController->runSql('DELETE FROM psr_contacts WHERE( contact_no='.$_POST["selectedNum"].')', $this->getServiceLocator());
        }

        return array(
            'emp_id' => $id,
            'form' => $form,
            'contacts' => $testController->runSql('SELECT * FROM psr_contacts WHERE emp_id ='.$id, $this->getServiceLocator()),
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
            //echo 'isPOST';
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                //$id = (int) $request->getPost('id');
                //echo $id;
                $this->getPsrTable()->deletePsr($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('psr');
        }

        return array(
            'emp_id'    => $id,
            'psr' => $this->getPsrTable()->getPsr($id)
        );
    }

    public function getPsrTable()
    {
        if (!$this->psrTable) {
            $sm = $this->getServiceLocator();
            $this->psrTable = $sm->get('Album\Model\PsrTable');
        }
        return $this->psrTable;
    }
}