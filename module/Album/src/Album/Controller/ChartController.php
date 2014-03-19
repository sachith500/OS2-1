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

    }

    public function priceVariationAction()
    {

    }

    public function orderTimelineAction()
    {

    }
}