<?php

namespace App\Listeners\Orders;

use App\Events\Orders\OrderCompleted;
use App\Events\Orders\OrderPaid;
use App\Notifications\OrderNotification;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class SendOrderCompletedNotification
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
     * @param  OrderCompleted  $event
     * @return void
     */
    public function handle(OrderCompleted $event)
    {
        $order = $event->order;
        $user = $order->user;
        if ($user) {
            Notification::send(
                $order->user,
                new OrderNotification(
                    $order,
                    'تکمیل سفارش',
                    'مشتری گرامی سفارش شما ارسال شد و تا چند روز آینده به شما تحویل داده خواهد شد.',
                    route('user.orders.show', $order)
                )
            );
        }

        if (!empty($order->mobile) && !empty(config('smsirlaravel.templates.order_paid'))) {
            // Smsirlaravel::ultraFastSend(['code'=>$order->code],config('smsirlaravel.templates.order_completed'),$order->mobile);
            sendSms(['order' => (string)$order->code], 'order_paid', $order->mobile);
        }
    }
}
