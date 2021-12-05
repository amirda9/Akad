<?php

namespace App\Listeners\Orders;

use App\Events\Orders\OrderPaid;
use App\OrderItem;
use App\Variation;

class OrderPaidListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderPaid  $event
     * @return void
     */
    public function handle(OrderPaid $event)
    {
        $order = $event->order;
        $items = OrderItem::where('order_id',$order->id)->with(['product','variation'])
            ->where(function ($q) {
                $q->where('is_paid',false)
                    ->whereNull('status');
            })
            ->get();

        foreach ($items as $item) {
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
        OrderItem::where('order_id',$order->id)->update([
            'is_paid' => true,
            'status' => 'done'
        ]);

        $order->update([
            'received_money' => $order->getFinalPrice(),
            'is_paid' => true,
            'status' => 'processing'
        ]);
    }
}
