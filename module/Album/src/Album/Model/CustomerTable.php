<?php
namespace Album\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Validator\Db\RecordExists;
class CustomerTable
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

    public function getCustomer($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('CID' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveCustomer(Customer $customer)
    {
        $data = array(
            'CID' => $customer->CID,
            'first_name' => $customer->first_name,
            'middle_name' => $customer->middle_name,
            'last_name' => $customer->last_name,
            'po_box' => $customer->po_box,
            'street' => $customer->street,
            'city' => $customer->city,
        );

        $id = (int)$customer->CID;

        echo $customer->CID;
        echo $customer->city;

        $this->tableGateway->insert($data);
        /*
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCustomer($id)) {
                $this->tableGateway->update($data, array('CID' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }*/
    }

    public function deleteCustomer($id)
    {
        $this->tableGateway->delete(array('CID' => $id));
    }
}