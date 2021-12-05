<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $orders = $user->orders()->with(['items' => function ($q) {
            $q->with('product');
        }])->orderBy('created_at', 'desc');

        if ($request->start_date) {
            $start_date = Carbon::createFromFormat('Y-m-d', Date('Y-m-d', str_limit(request('start_date'), 10, '')));
            $start_date->startOfDay();
            $orders = $orders->where('created_at', '>=', $start_date);
        }
        if ($request->end_date) {
            $end_date = Carbon::createFromFormat('Y-m-d', Date('Y-m-d', str_limit(request('end_date'), 10, '')));
            $end_date->endOfDay();
            $orders = $orders->where('created_at', '<=', $end_date);
        }

        if ($request->search) {
            $orders = $orders->where('code', 'like', "%$request->search%");
        }
        if ($request->status) {
            $orders = $orders->where('status', $request->status);
        }

        $orders = $orders->paginate(10);
        $orders->appends($request->query());

        return view('user.orders.index')->with([
            'orders' => $orders
        ]);
    }

    public function show($code)
    {
        $user = Auth::user();
        $order = $user->orders()->code($code)->firstOrFail();
        switch ($order->status) {
            case 'failed' :{
                return view('user.orders.failed')->with([
                    'order' => $order
                ]);
            }
            default: {
                return view('user.orders.show')->with([
                    'order' => $order
                ]);
            }
        }
    }

    public function reserve($code)
    {
        $user = Auth::user();
        $order = $user->orders()->where('code', $code)->firstOrFail();
        if ($order->canReserve()) {
            $order->update([
                'status' => 'reserve',
            ]);
        } else {
            return back()->withErrors('متاسفانه سفارش شما قابل رزرو کردن نمی باشد');
        }

        return back()->with([
            'toast' => true,
            'success' => 'سفارش مورد نظر شما با موفقیت رزرو شد'
        ]);
    }

    public function done($code)
    {
        $user = Auth::user();
        $order = $user->orders()->where('code', $code)->firstOrFail();
        if ($order->isReserved()) {
            $order->update([
                'status' => $order->is_paid ? 'processing' : 'pending'
            ]);
        } else {
            return back()->withErrors('متاسفانه سفارش شما قابل رزرو کردن نمی باشد');
        }

        return back()->with([
            'toast' => true,
            'success' => 'تکمیل خرید انجام شد و سفارش شما بعد از پرداخت در اسرع وقت ارسال خواهد شد'
        ]);
    }
}
