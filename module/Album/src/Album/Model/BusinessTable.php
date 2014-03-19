<?php
namespace Album\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Validator\Db\RecordExists;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;

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

        error_log("MyDebug ".$id);

        $sql = new Sql($this->tableGateway->adapter);
        $select = $sql->select();
        $select->from('businesses');
        $select->where(array('brn' => $id));
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
            error_log("brn test ". "Add Business");
        } else {
            if ($this->getBusiness($id)) {
                $this->tableGateway->update($data, array('brn' => $id));
                error_log("brn test ". "Edit Business");
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteBusiness($id)
    {
        $this->tableGateway->delete(array('brn' => $id));
    }
}
