<?php

namespace App\Listeners\Orders;

use App\Events\Orders\OrderMerged;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Notification;

class SendOrderMergedNotification
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

    public function handle(OrderMerged $event)
    {
        $order = $event->order;
        Notification::send(
            $order->user,
            new OrderNotification(
                $order,
                'ادغام سفارش',
                'سفارش شما با موفقیت ادغام شد و پس از بررسی و پرداخت برای شما ارسال خواهد شد'
            )
        );
    }
}
