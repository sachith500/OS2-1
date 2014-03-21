<?php
/**
 * Created by PhpStorm.
 * User: vipula
 * Date: 3/18/14
 * Time: 6:06 PM
 */

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ChartController extends AbstractActionController
{
    public function indexAction()
    {


    }

    public function orderDistAction()
    {
        $type = "PieChart";
        $data = array(
            array('type' => 'Mail Order', 'amount' => 2),
            array('type' => 'Large Order', 'amount' => 1),
            array('type' => 'Retail Order', 'amount' => 4)
        );

        return array(
            'type' => $type,
            'data' => $data,
        );
    }

    public function customerDistAction()
    {
        $type = "PieChart";
        $data = array(
            array('type' => 'Mail Order Customers', 'amount' => 2),
            array('type' => 'Large Order Customers', 'amount' => 1),
            array('type' => 'VIP Customers', 'amount' => 4)
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
            'type'=>$type,
            'data'=>$data,
        );
    }

    public function orderTimelineAction()
    {

    }
}