<?php
namespace Album\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Validator\Db\RecordExists;
class PsrTable
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

    public function getPsr($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('emp_id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function savePsr(Psr $psr)
    {
        $data = array(
            'emp_id' => $psr->emp_id,
            'name'  => $psr->name,
            'po_box' => $psr->po_box,
            'street' => $psr->street,
            'city' => $psr->city
        );

        $id = (int)$psr->emp_id;
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

    public function deletePsr($id)
    {
        $this->tableGateway->delete(array('emp_id' => $id));
    }
}