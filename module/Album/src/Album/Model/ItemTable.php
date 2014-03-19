<?php
namespace Album\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Validator\Db\RecordExists;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;
class ItemTable
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

    public function getItem($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('item_no' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveItem(Item $item)
    {
        $data = array(
            'item_no' => $item->item_no,
            'name'  => $item->name,
            'description' => $item->description,
        );

        $id = (int)$item->item_no;

        $sql = new Sql($this->tableGateway->adapter);
        $select = $sql->select();
        $select->from('items');
        $select->where(array('item_no' => $id));
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
            error_log("item_no test ". "Add item");
        } else {
            if ($this->getItem($id)) {
                $this->tableGateway->update($data, array('item_no' => $id));

            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteItem($id)
    {
        $this->tableGateway->delete(array('item_no' => $id));
    }
}