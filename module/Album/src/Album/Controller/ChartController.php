<?php
/**
 * Created by PhpStorm.
 * User: vipula
 * Date: 3/18/14
 * Time: 6:06 PM
 */

namespace Album\Controller;

use Zend\Db\ResultSet\ResultSet;
use Zend\Mvc\Controller\AbstractActionController;

class ChartController extends AbstractActionController
{
    public function indexAction()
    {


    }

    public function orderDistAction()
    {

        $sm = $this->getServiceLocator();
        $testCon = new TestController();
        $query = 'select * from large_orders;';
        $resultSet = $testCon->runSql($query, $sm);
        $nlo= $resultSet->count();

        $query = 'select * from mail_orders;';
        $resultSet = $testCon->runSql($query, $sm);
        $nmo= $resultSet->count();

        $query = 'select * from vip_orders;';
        $resultSet = $testCon->runSql($query, $sm);
        $nvo= $resultSet->count();
        $type = "PieChart";


        $data = array(
            array('type' => 'Mail Order', 'amount' => $nmo),
            array('type' => 'Large Order', 'amount' => $nlo),
            array('type' => 'VIP Order', 'amount' => $nvo)
        );

        return array(
            'type' => $type,
            'data' => $data,
        );
    }

    public function customerDistAction()
    {
        $sm = $this->getServiceLocator();
        $testCon = new TestController();
        $query = 'select * from l_o_customers;';
        $resultSet = $testCon->runSql($query, $sm);
        $nlo= $resultSet->count();

        $query = 'select * from mo_customers;';
        $resultSet = $testCon->runSql($query, $sm);
        $nmo= $resultSet->count();

        $query = 'select * from vip_customers;';
        $resultSet = $testCon->runSql($query, $sm);
        $nvo= $resultSet->count();
        $type = "PieChart";

        $data = array(
            array('type' => 'Mail Order Customers', 'amount' => $nmo),
            array('type' => 'Large Order Customers', 'amount' => $nlo),
            array('type' => 'VIP Customers', 'amount' => $nvo)
        );

        return array(
            'type' => $type,
            'data' => $data,
        );

    }

    public function priceVariationAction()
    {
        $type = "LineChart";
        $data = array(
            array('date' => '2014-1-1', 'Price' => 30),
            array('date' => '2014-2-2', 'Price' => 14045),
            array('date' => '2013-9-3', 'Price' => 55022),
            array('date' => '2014-1-4', 'Price' => 75284),
            array('date' => '2015-1-5', 'Price' => 41476),
            array('date' => '2014-1-6', 'Price' => 33322),
        );

        return array(
            'type' => $type,
            'data' => $data,
        );
    }

    public function orderTimelineAction()
    {

    }
}