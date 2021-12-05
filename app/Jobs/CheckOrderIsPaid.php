<?php

namespace App\Jobs;

use App\Order;
use App\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckOrderIsPaid implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = $this->order;
        OrderItem::where('order_id',$order->id)->where('is_paid',true)->update([
            'status' => 'done'
        ]);
        $items = OrderItem::where('order_id',$order->id)
            ->where(function ($q) {
                $q->where('is_paid',false)->orWhereNull('is_paid');
            })
            ->get();
        foreach($items as $item) {
            if($item->status == 'submitted') {
                if($item->variation != null) {
                    $item->variation->update([
                        'stock' => $item->variation->stock + $item->quantity
                    ]);
                } else {
                    if($item->product != null) {
                        $item->product->update([
                            'stock' => $item->product->stock + $item->quantity
                        ]);
                    }
                }
            }
        }
        OrderItem::where('order_id',$order->id)
            ->where(function ($q) {
                $q->where('is_paid',false)->orWhereNull('is_paid');
            })
            ->update([
                'status' => null
            ]);
    }
}
