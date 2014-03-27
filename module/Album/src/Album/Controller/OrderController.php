<?php
namespace Album\Controller;

use Album\Model\OrderTable;
use Album\Model\Order;
use Album\Form\OrderForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Controller\TestController;

class OrderController extends AbstractActionController
{
    protected $orderTable;
    protected $testController;

    public function indexAction()
    {
        return new ViewModel(array(
            'orders' => $this->getOrderTable()->fetchAll(),
        ));
    }

    public function viewAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        $testController = new TestController();
        $sql = 'SELECT * from items';
        $sql2 = 'SELECT * from items natural join item_orders where item_orders.order_no = '.$id;
        $current = $testController->runSql($sql2, $this->getServiceLocator());
        $items = $testController->runSql($sql, $this->getServiceLocator());

        if($_POST["done"] == 'Done'){
            return $this->redirect()->toRoute('order');
        }

        return array(
            'id' => $id,
            'items' => $items,
            'current' => $testController->runSql($sql2, $this->getServiceLocator()),
        );
    }

    public function itemsAction(){
        $id = (int) $this->params()->fromRoute('id', 0);
        $testController = new TestController();
        $sql = 'SELECT * from items';
        $sql2 = 'SELECT * from items natural join item_orders where item_orders.order_no = '.$id;
        $current = $testController->runSql($sql2, $this->getServiceLocator());
        $items = $testController->runSql($sql, $this->getServiceLocator());

        if($_POST["saveClicked"] == 'Save'){
            $stash = $testController->runSql('INSERT INTO item_orders (order_no, item_no, quantity) VALUES('.$id.','.$_POST["item"].','.$_POST["quantity"].')', $this->getServiceLocator());
        }

        if($_POST["done"] == 'Done'){
            return $this->redirect()->toRoute('order');
        }

        return array(
            'id' => $id,
            'items' => $items,
            'current' => $testController->runSql($sql2, $this->getServiceLocator()),
        );
    }

    public function addAction()
    {
        $testController = new TestController();
        $form = new OrderForm();
        $form->get('submit')->setValue('Add Items');
        //echo 'submit button name changed to Add';
        $request = $this->getRequest();
        // echo 'getRequest()';
        if ($request->isPost()) {
            //echo 'inside if';

            $order = new Order();
            $form->setInputFilter($order->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $dropdown = $form->get('order_type');
                $selection = $dropdown->getValue();
                $sm = $this->getServiceLocator();
                $testCon = new TestController();
                $query1 = 'insert into orders values(';
                $query1 .= $form->get('order_no')->getValue() . ',';
                $query1 .= $form->get('date')->getValue().')';
                $query = 'insert into ';
                switch ($selection){
                    case 0:
                        $query .= 'large_orders ';
                        break;
                    case 1:
                        $query .= 'mail_orders ';
                        break;
                    case 2:
                        $query .= 'vip_orders ';
                        break;
                }
                $query .= 'values(';
                $query .= $form->get('order_no')->getValue() . ',';
                $query .= $form->get('cid')->getValue()      . ')';
                $testCon->runSql($query1, $sm);
                $testCon->runSql($query,$sm);
                $order->exchangeArray($form->getData());
                $this->getOrderTable()->saveOrder($order);

                // Redirect to list of orders
                return $this->redirect()->toRoute('order', array('action' => 'items', 'id' => $order->order_no));
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
            return $this->redirect()->toRoute('order', array(
                'action' => 'add'
            ));
        }
        $order = $this->getOrderTable()->getOrder($id);

        $form  = new OrderForm();
        $form->bind($order);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($order->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getOrderTable()->saveOrder($form->getData());

                // Redirect to list of albums
                return $this->redirect()->toRoute('order');
            }
        }

        return array(
            'order_no' => $id,
            'form' => $form,
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
                $this->getOrderTable()->deleteOrder($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('order');
        }

        return array(
            'order_no'    => $id,
            'order' => $this->getOrderTable()->getOrder($id)
        );
    }

    public function getOrderTable()
    {
        if (!$this->orderTable) {
            $sm = $this->getServiceLocator();
            $this->orderTable = $sm->get('Album\Model\OrderTable');
        }
        return $this->orderTable;
    }
}