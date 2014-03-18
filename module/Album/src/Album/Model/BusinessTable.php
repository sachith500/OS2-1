<?php
namespace Album\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Validator\Db\RecordExists;
class BusinessTable
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

    public function getBusiness($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('brn' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveBusiness(Business $business)
    {
        $data = array(
            'brn' => $business->brn,
            'name'  => $business->name,
        );

        $id = (int)$business->brn;
        echo $id;
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

    public function deleteBusiness($id)
    {
        $this->tableGateway->delete(array('brn' => $id));
    }
}