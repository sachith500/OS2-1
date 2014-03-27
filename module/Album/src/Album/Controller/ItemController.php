<?php
namespace Album\Controller;

use Album\Model\ItemTable;
use Album\Model\Item;
use Album\Form\ItemForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ItemController extends AbstractActionController
{
    protected $itemTable;

    public function indexAction()
    {
        return new ViewModel(array(
            'items' => $this->getItemTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new ItemForm();
        $form->get('submit')->setValue('Add');
        //echo 'submit button name changed to Add';
        $request = $this->getRequest();
        // echo 'getRequest()';
        if ($request->isPost()) {
           // echo 'inside if';

            $item = new Item();
            $form->setInputFilter($item->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                //echo 'inside isvalid';
                $item->exchangeArray($form->getData());
                $this->getItemTable()->saveItem($item);

                // Redirect to list of albums
                return $this->redirect()->toRoute('item');
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
            return $this->redirect()->toRoute('item', array(
                'action' => 'add'
            ));
        }
        $item = $this->getItemTable()->getItem($id);

        $form  = new ItemForm();
        $form->bind($item);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($item->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getItemTable()->saveItem($form->getData());

                // Redirect to list of albums
                return $this->redirect()->toRoute('item');
            }
        }

        $testController = new TestController();


        $date = date("Y-m-d");
        //echo $date;
        $date2 =  $_POST["endDate"];
        //echo $date2;
        //echo 'INSERT INTO item_prices VALUES('.$id.','.$date.','.$date2.','.$_POST["price"].')';
        if($_POST["saveClicked"] == 'Save'){
            $stash = $testController->runSql('INSERT INTO item_prices VALUES('.$id.',"'.$date.'","'.$date2.'",'.$_POST["price"].')', $this->getServiceLocator());
        }

        return array(
            'item_no' => $id,
            'form' => $form,
            'prices' => $testController->runSql('SELECT * FROM item_prices WHERE item_no ='.$id, $this->getServiceLocator()),
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
                $this->getItemTable()->deleteItem($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('item');
        }

        return array(
            'item_no'    => $id,
            'item' => $this->getItemTable()->getItem($id)
        );
    }

    public function getItemTable()
    {
        if (!$this->itemTable) {
            $sm = $this->getServiceLocator();
            $this->itemTable = $sm->get('Album\Model\ItemTable');
        }
        return $this->itemTable;
    }
}