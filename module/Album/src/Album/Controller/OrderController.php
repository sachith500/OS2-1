<?php
namespace Album\Controller;

use Album\Model\OrderTable;
use Album\Model\Order;
use Album\Form\OrderForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OrderController extends AbstractActionController
{
    protected $orderTable;

    public function indexAction()
    {
        return new ViewModel(array(
            'orders' => $this->getOrderTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new OrderForm();
        $form->get('submit')->setValue('Add');
        //echo 'submit button name changed to Add';
        $request = $this->getRequest();
        // echo 'getRequest()';
        if ($request->isPost()) {
            //echo 'inside if';

            $order = new Order();
            $form->setInputFilter($order->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                //echo 'inside isvalid';
                $order->exchangeArray($form->getData());
                $this->getOrderTable()->saveOrder($order);

                // Redirect to list of albums
                return $this->redirect()->toRoute('order');
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