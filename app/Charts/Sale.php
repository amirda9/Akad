<?php


namespace App\Charts;


use App\Order;

class Sale
{
    public $orders = [];

    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }

    public function getDataSet()
    {

    }

}
