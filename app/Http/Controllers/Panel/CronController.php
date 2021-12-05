<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderItem;

class CronController extends Controller
{
    public function checkOrderIsPaid()
    {
        OrderItem::where('is_paid',true)->where(function($q) {
            $q->where('status','!=','done')->whereNull('status');
        })->update([
            'status' => 'done'
        ]);

        $items = OrderItem::where(function($q) {
                $q->where('is_paid',false)->orWhereNull('is_paid');
            })
            ->where('status','submitted')
            ->where('created_at','<',now()->addMinutes(-15))
            ->with(['variation','product'])
            ->get();

        foreach($items as $item) {
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
        OrderItem::where(function($q) {
                $q->where('is_paid',false)->orWhereNull('is_paid');
            })
            ->where('status','submitted')
            ->where('created_at','<',now()->addMinutes(-15))
            ->with(['variation','product'])
            ->update([
                'status' => null
            ]);
    }
}
