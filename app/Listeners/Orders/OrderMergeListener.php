<?php

namespace App\Listeners\Orders;

use App\Events\Orders\OrderMerged;
use App\Events\Orders\OrderPaid;
use App\Jobs\CheckOrderIsPaid;
use App\OrderItem;
use App\Variation;

class OrderMergeListener
{

    public function handle(OrderMerged $event)
    {
        $order = $event->order;
        $items = OrderItem::where('order_id',$order->id)
            ->with(['product','variation'])
            ->where(function ($q) {
                $q->where('is_paid',false)->orWhereNull('is_paid');
            })
            ->get();

        if($items->count()) {
            $order->update([
                'is_paid' => false
            ]);
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
                ->where(function ($q) {
                    $q->where('is_paid',false)->orWhereNull('is_paid');
                })
                ->update([
                    'status' => 'submitted'
                ]);
        }
    }
}
