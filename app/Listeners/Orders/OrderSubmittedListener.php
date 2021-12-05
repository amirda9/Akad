<?php

namespace App\Listeners\Orders;

use App\Events\Orders\OrderSubmitted;
use App\OrderItem;

class OrderSubmittedListener
{

    public function handle(OrderSubmitted $event)
    {
        $order = $event->order;
        $items = OrderItem::where('order_id',$order->id)->with(['product','variation'])->get();
        foreach ($items as $item)
        {
            if($item->variation != null) {
                $item->variation->update([
                    'stock' => $item->variation->stock - $item->quantity
                ]);
            } else {
                if($item->product != null) {
                    $item->product->update([
                        'stock' => $item->product->stock - $item->quantity
                    ]);
                }
            }
        }
        OrderItem::where('order_id',$order->id)
            ->with(['product','variation'])
            ->update([
                'status' => 'submitted'
            ]);
    }
}
