<?php
namespace Album\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Module;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;

class TestController extends AbstractActionController{

    public function indexAction()
    {

        $sm = $this->getServiceLocator();
        $adapter = $sm->get('Zend\Db\Adapter\Adapter');

        $sql = new Sql($adapter);
        $select = $sql->select();
        $select->from('businesses');
        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet;
        $resultSet->initialize($results);

        $resultSet2 = $this->runSql('SELECT * from customers');

        return new viewModel(array(
            "test" => "Hi",
            "results" => $resultSet,
            "results2" => $resultSet2,
        ));
    }

    public function getAdapter()
    {
        $sm = $this->getServiceLocator();
        $adapter = $sm->get('Zend\Db\Adapter\Adapter');
        return $adapter;
    }

    public function runSql($sql)
    {
        $adapter = $this->getAdapter();
        $resultSet = $adapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
        return $resultSet;
    }
}

?>