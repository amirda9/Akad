<?php

namespace App\Events\Orders;

use App\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPaid
{
    use Dispatchable, SerializesModels;

    public $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
