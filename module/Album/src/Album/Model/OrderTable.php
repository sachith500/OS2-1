<?php
namespace Album\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Validator\Db\RecordExists;
class OrderTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getOrder($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('order_no' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveOrder(Order $order)
    {
        $data = array(
            'order_no' => $order->order_no,
            'date'  => $order->date,
        );

        $id = (int)$order->order_no;
        echo $id;
        $this->tableGateway->insert($data);
        //check for primary key constraints here ********************************
        /*if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getBusiness($id)) {
                $this->tableGateway->update($data, array('brn' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
        /*
        if ($id == 0) {
            $this->tableGateway->insert($data);
        }
        else{
            $this->tableGateway->update($data, array('brn' => $id));
        }*/

    }

    public function deleteOrder($id)
    {
        $this->tableGateway->delete(array('order_no' => $id));
    }
}