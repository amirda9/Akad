<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Events\Orders\OrderPaid;
use App\Order;
use App\Transaction;
use Illuminate\Http\Request;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Exceptions\PurchaseFailedException;
use Shetabit\Multipay\Invoice;
use Shetabit\Multipay\Payment;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('user.orders.index');
        }
        if ($request->code) {
            $order = Order::where('code', $request->code)->first();
            if ($order) {
                return redirect()->route('orders.show', $order->code);
            } else {
                return redirect()->route('orders.index')
                    ->withErrors('سفارش شما یافت نشد');
            }
        }
        return view('orders.index');
    }

    public function show(Request $request, $code)
    {
        $order = Order::where('code', $code)->firstOrFail();
        $user = auth()->user();
        if ($user) {
            if ($order->user_id == $user->id) {
                return redirect()->route('user.orders.show', $order->code);
            } else {
                return redirect()->route('user.orders.index');
            }
        }
        switch ($order->status) {
            case 'failed': {
                    return view('orders.failed')->with([
                        'order' => $order
                    ]);
                }
            default: {
                    return view('orders.show')->with([
                        'order' => $order
                    ]);
                }
        }
    }

    public function pay(Request $request, $code)
    {
        $order = Order::where('code', $code)->firstOrFail();
        if ($order->is_paid) {
            return view('orders.verify')
                ->with([
                    'order' => $order,
                    'message' => 'سفارش مورد نظر شما قبلا پرداخت شده است',
                    'success' => true,
                ]);
        }
        if ($order->status != 'pending') {
            return back()->withErrors('سفارش شما قابل پرداخت نمی باشد')->with([
                'toast' => true
            ]);
        }
        if (!$order->isValid()) {
            if ($order->received_money > 0) {
                $order->items()->where(function ($q) {
                    $q->where('is_paid', false)->orWhereNull('is_paid');
                })->delete();
                $is_paid = $order->getPayablePrice() == 0;
                $order->update([
                    'status' => $is_paid ? 'processing' : 'pending',
                    'is_paid' => $is_paid
                ]);
                return back()->withErrors('محصولات ناموجود از سفارش شما حذف شد، لطفا برای رزرو مجدد تلاش کنید.')->with([
                    'toast' => true
                ]);
            } else {
                $order->update([
                    'status' => 'failed'
                ]);
                return back()->withErrors('سفارش شما منقضی شده است، لطفا مجدد خرید خود را انجام دهید')->with([
                    'toast' => true
                ]);
            }
        }
        if (!in_array($request->payment, array_keys(Order::payments()))) {
            return back()->withErrors('روش پرداخت انتخاب شده نامعتبر می باشد')->with([
                'toast' => true
            ]);
        }
        if (!$order->is_approved) {
            return back()->withErrors('سفارش شما نیاز به تایید مدیریت دارد')->with([
                'toast' => true
            ]);
        }

        $order->update([
            'payment' => $request->payment
        ]);

        $invoice = new Invoice();
        $invoice->amount((int)$order->getPayablePrice() * ($request->payment == 'pasargad' ? 10 : 1));
        $invoice->detail([
            'order_id' => $order->code,
            'name' => $order->name,
            'phone' => $order->mobile,
            'mail' => $order->email,
        ]);

        $transaction = Transaction::create([
            'price' => $order->getPayablePrice() * ($request->payment == 'pasargad' ? 10 : 1),
            'uuid' => $invoice->getUuid(),
            'port' => $request->payment,
            'order_id' => $order->id,
        ]);

        try {
            $payment = new Payment();
            return $payment->via($request->payment)
                ->config(config('payment.drivers')[$request->payment])
                ->callbackUrl(route('orders.verify', $invoice->getUuid()))
                ->purchase(
                    $invoice,
                    function ($driver, $transactionId) use ($order, $transaction) {
                        $transaction->update([
                            'transaction_id' => $transactionId,
                        ]);
                    }
                )->pay()->render();
        } catch (PurchaseFailedException $exception) {
            $transaction->update([
                'message' => $exception->getMessage()
            ]);
            return view('orders.verify')
                ->with([
                    'order' => $order,
                    'transaction' => $transaction,
                    'message' => 'خطا در اتصال به درگاه پرداخت، لطفا از قسمت مشاهده سفارش روش پرداخت دیگری را انتخاب کنید و یا با پشتیبانی تماس بگیرید.',
                    'success' => false,
                ]);
        } catch (\Exception $e) {
            $transaction->update([
                'message' => $e->getMessage()
            ]);
            return view('orders.verify')
                ->with([
                    'order' => $order,
                    'transaction' => $transaction,
                    'message' => 'خطا در اتصال به درگاه پرداخت، لطفا از قسمت مشاهده سفارش روش پرداخت دیگری را انتخاب کنید و یا با پشتیبانی تماس بگیرید.',
                    'success' => false,
                ]);
        }
    }


    public function verify(Request $request, $uuid)
    {
        $transaction = Transaction::where('uuid', $uuid)->firstOrFail();
        $order = $transaction->order;
        if (!$order) {
            return view('orders.verify')
                ->with([
                    'transaction' => $transaction,
                    'message' => 'سفارش شما یافت نشد! در صورتی که مبلغ پرداختی طی 48 ساعت آینده برگشت نخورد، با پشتیبانی تماس بگیرید.',
                    'success' => false,
                ]);
        }
        if ($order->is_paid) {
            return view('orders.verify')
                ->with([
                    'order' => $order,
                    'transaction' => $transaction,
                    'success' => true,
                ]);
        }
        try {
            $payment = new Payment();
            $receipt = $payment->via($transaction->port)
                ->config(config('payment.drivers')[$transaction->port])
                ->amount((int)$transaction->price)
                ->transactionId($transaction->transaction_id)->verify();
            $refId =  ($request->payment == 'pasargad') ? $receipt->getDetail('TraceNumber') : $receipt->getReferenceId();

            $transaction->update([
                'reference_id' => $receipt->getReferenceId(),
                'inner_reference_id' => $receipt->getDetail('TraceNumber'),
                'is_paid' => true,
                'message' => 'پرداخت با موفقیت انجام شد'
            ]);

            event(new OrderPaid($order));

            return view('orders.verify')
                ->with([
                    'order' => $order,
                    'transaction' => $transaction,
                    'success' => true,
                ]);
        } catch (InvalidPaymentException $exception) {
            $transaction->update([
                'message' => $exception->getMessage(),
                'is_paid' => false
            ]);
            return view('orders.verify')
                ->with([
                    'order' => $order,
                    'transaction' => $transaction,
                    'success' => false,
                ]);
        }
    }

    public function SubmitCoupon(Request $request, $code)
    {
        $order = Order::where('code', $code)->firstOrFail();
        $coupon = Coupon::where('code', $request->code)->first();
        if (!$coupon) {
            return back()->withErrors([
                'کد تخفیف وارد شده صحیح نیست',
            ])->with([
                'toast' => true
            ]);
        }

        $validation = $coupon->isValid($order);
        if (!$validation['isValid']) {
            return back()->withErrors([
                $validation['message'],
            ])->with([
                'toast' => true
            ]);
        }

        $coupon->use($order);

        return back()->with([
            'success' => "کد تخیفیف با موفقیت اعمال شد",
            'toast' => true
        ]);
    }
}
