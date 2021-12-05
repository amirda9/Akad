<?php

namespace App\Listeners\Orders;

use App\Events\Orders\OrderSubmitted;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Notification;

class SendOrderSubmittedNotification
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
     * @param  OrderSubmitted  $event
     * @return void
     */
    public function handle(OrderSubmitted $event)
    {
        $order = $event->order;
        Notification::send(
            $order->user,
            new OrderNotification(
                $order,
                'ثبت سفارش',
                'سفارش شما با موفقیت ثبت شد و پس از بررسی و پرداخت برای شما ارسال خواهد شد'
            )
        );
    }
}
