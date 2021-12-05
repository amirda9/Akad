<?php


namespace App\Logs;


class VariationLog
{
    public $title;
    public $conditions;
    public $regular_price;
    public $sale_price;
    public $stock;
    public $stock_status;
    public function __construct($title, $conditions, $regular_price, $sale_price, $stock, $stock_status)
    {
        $this->title = $title;
        $this->conditions = $conditions;
        $this->regular_price = $regular_price;
        $this->sale_price = $sale_price;
        $this->stock = $stock;
        $this->stock_status = $stock_status;
    }
}
