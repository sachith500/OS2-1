<?php
namespace Album\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Validator\Db\RecordExists;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;
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

        $sql = new Sql($this->tableGateway->adapter);
        $select = $sql->select();
        $select->from('customers');
        $select->where(array('CID' => $id));
        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet;
        $resultSet->initialize($results);
        $size = $results->count();
        //$size2 = $resultSet->count();
        //$state = false;

        /*foreach($resultSet as $row){
            $state = true;
            error_log ( $row->brn . PHP_EOL );
        }*/

        error_log("brn test "."results->count=".$size);
        //error_log("brn test "."resultSet->count=".$size2);
        //error_log("brn test "."state".$state);
        error_log("MyDebug"." Success");


        if ($size == 0) {
            $this->tableGateway->insert($data);
            error_log("CID test ". "Add Customer");
        } else {
            if ($this->getCustomer($id)) {
                $this->tableGateway->update($data, array('CID' => $id));

            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteCustomer($id)
    {
        $this->tableGateway->delete(array('CID' => $id));
    }
}