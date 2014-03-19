<?php
namespace Album\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Validator\Db\RecordExists;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;
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
        //echo $id;

        $sql = new Sql($this->tableGateway->adapter);
        $select = $sql->select();
        $select->from('orders');
        $select->where(array('order_no' => $id));
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
            //error_log("brn test ". "Add Business");
        } else {
            if ($this->getOrder($id)) {
                $this->tableGateway->update($data, array('order_no' => $id));
                //error_log("brn test ". "Edit Business");
            } else {
                throw new \Exception('Form id does not exist');
            }
        }

    }

    public function deleteOrder($id)
    {
        $this->tableGateway->delete(array('order_no' => $id));
    }
}