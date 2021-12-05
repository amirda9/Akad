<?php

namespace App\Listeners\Orders;

use App\Events\Orders\OrderPaid;
use App\Notifications\OrderNotification;
use App\User;
use Illuminate\Support\Facades\Notification;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class SendOrderPaidNotification
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
        $user = $order->user;
        if ($user) {
            Notification::send(
                $order->user,
                new OrderNotification(
                    $order,
                    'پرداخت سفارش',
                    'سفارش شما با موفقیت پرداخت شد و در اسرع وقت برای شما ارسال خواهد شد',
                    route('user.orders.show', $order)
                )
            );
        }

        Notification::send(
            User::permission('view orders')->get(),
            new OrderNotification(
                $order,
                'پرداخت سفارش',
                "سفارش مشتری به شماره $order->code پرداخت شده است.",
                route('panel.orders.show', $order)
            )
        );
        if (!empty(getOption('site_information.shop_mobile')) && !empty(config('smsirlaravel.templates.order_submitted'))) {
            sendSms(['order' => (string)$order->code], 'send_order_to_admin', getOption('site_information.shop_mobile'));
            sendSms(['order' => (string)$order->code], 'order_paid', $order->mobile);
        }
    }
}
