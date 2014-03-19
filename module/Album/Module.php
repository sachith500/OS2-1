<?php
namespace Album;
use Album\Model\Album;
use Album\Model\AlbumTable;
use Album\Model\Business;
use Album\Model\BusinessTable;
use Album\Model\Customer;
use Album\Model\CustomerTable;
use Album\Model\Item;
use Album\Model\ItemTable;
use Album\Model\Order;
use Album\Model\OrderTable;
use Album\Model\Psr;
use Album\Model\PsrTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Album\Model\AlbumTable' =>  function($sm) {
                        $tableGateway = $sm->get('AlbumTableGateway');
                        $table = new AlbumTable($tableGateway);
                        return $table;
                    },
                'AlbumTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Album());
                        return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                    },
                'Album\Model\BusinessTable' =>  function($sm) {
                        $tableGateway = $sm->get('BusinessTableGateway');
                        $table = new BusinessTable($tableGateway);
                        return $table;
                    },
                'BusinessTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Business());
                        return new TableGateway('businesses', $dbAdapter, null, $resultSetPrototype);
                    },
                'Album\Model\CustomerTable' =>  function($sm) {
                        $tableGateway = $sm->get('CustomerTableGateway');
                        $table = new CustomerTable($tableGateway);
                        return $table;
                    },
                'CustomerTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Customer());
                        return new TableGateway('customers', $dbAdapter, null, $resultSetPrototype);
                    },
                'Album\Model\ItemTable' =>  function($sm) {
                        $tableGateway = $sm->get('ItemTableGateway');
                        $table = new ItemTable($tableGateway);
                        return $table;
                    },
                'ItemTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Item());
                        return new TableGateway('items', $dbAdapter, null, $resultSetPrototype);
                    },
                'Album\Model\OrderTable' =>  function($sm) {
                        $tableGateway = $sm->get('OrderTableGateway');
                        $table = new OrderTable($tableGateway);
                        return $table;
                    },
                'OrderTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Order());
                        return new TableGateway('orders', $dbAdapter, null, $resultSetPrototype);
                    },
                'Album\Model\PsrTable' =>  function($sm) {
                        $tableGateway = $sm->get('PsrTableGateway');
                        $table = new PsrTable($tableGateway);
                        return $table;
                    },
                'PsrTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Psr());
                        return new TableGateway('psrs', $dbAdapter, null, $resultSetPrototype);
                    },
            ),
        );
    }

}