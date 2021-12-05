<?php

namespace App\Http\Controllers\Panel;

use App\Events\Orders\OrderCompleted;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Option;
use App\OrderItem;
use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('view orders');
        $orders = Order::orderBy('created_at', 'desc');
        $products = Product::all();
        $provinces = collect(config('locality.provinces'));
        $cities = collect(config('locality.cities'));
        $options = Option::all();
        $shipping_option = $options->where('name', 'shipping')->first();
        $shippings = $shipping_option ? $shipping_option->getValue() : [];

        $expired_reserved_orders = Order::whereIn('status', ['reserve','processing'])
            ->where('created_at','<', Carbon::today()->addDays(-3))
            ->get();


        if ($request->search) {
            $orders = $orders->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', "%$request->search%")
                    ->orWhere('code', 'LIKE', "%$request->search%")
                    ->orWhere('mobile', 'LIKE', "%$request->search%")
                    ->orWhere('email', 'LIKE', "%$request->search%")
                    ->orWhereHas('user', function ($q) use ($request) {
                        $q->where('name', 'LIKE', "%$request->search%")
                            ->orWhere('mobile', 'LIKE', "%$request->search%")
                            ->orWhere('email', 'LIKE', "%$request->search%");
                    });
            });
        }

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

        if (is_array($request->get('statuses'))) {
            if(count($request->get('statuses')) > 0){
                $orders = $orders->whereIn('status', $request->get('statuses'));
            }
        }


        if (is_array($request->get('products'))) {
            if(count($request->get('products')) > 0) {
                $orders = $orders->whereHas('items',function($q) use($request) {
                    $q->whereIn('product_id',$request->get('products'));
                });
            }
        }


        if (is_array($request->get('provinces'))) {
            if(count($request->get('provinces')) > 0) {
                $config_provinces = collect(config('locality.provinces'));
                $selected_provinces = $config_provinces->whereIn('id',$request->get('provinces'));
                $orders = $orders->where(function($q) use ($selected_provinces){
                    $q->whereIn('province',$selected_provinces->pluck('id'))
                        ->orWhereIn('province',$selected_provinces->pluck('name'));
                });
            }
        }
        if (is_array($request->get('cities'))) {
            if(count($request->get('cities')) > 0) {
                $config_cities = collect(config('locality.cities'));
                $selected_cities = $config_cities->whereIn('id',$request->get('cities'));
                $orders = $orders->where(function($q) use ($selected_cities){
                    $q->whereIn('city',$selected_cities->pluck('id'))
                        ->orWhereIn('city',$selected_cities->pluck('name'));
                });
            }
        }

        if ($request->get('shipping')) {
            $orders = $orders->where('shipping', 'like', "%$request->shipping%");
        }
        if ($request->get('is_paid') == 'is_paid') {
            $orders = $orders->where('is_paid', true);
        }
        if ($request->get('is_paid') == 'not_paid') {
            $orders = $orders->where('is_paid', false);
        }

        if (!empty($request->number)) {
            $orders = $orders->paginate($request->number);
        } else {
            $orders = $orders->paginate();
        }

        $orders->appends($request->query());

        return view('panel.orders.index')->with([
            'expired_reserved_orders' => $expired_reserved_orders,
            'orders' => $orders,
            'products' => $products,
            'cities' => $cities,
            'provinces' => $provinces,
            'shippings' => $shippings,
        ]);
    }


    public function show(Order $order)
    {
        $this->authorize('view orders');
        return view('panel.orders.show')->with([
            'order' => $order
        ]);
    }


    public function edit(Order $order)
    {
        $this->authorize('edit order');
        $provinces = collect(config('locality.provinces'));
        if(is_numeric($order->city)) {
            $province = $provinces->where('id', $order->province)->first();
        } else {
            $province = $provinces->where('name', $order->province)->first();
        }
        $cities = collect(config('locality.cities'));
        $cities = $cities->where('province', $province['id']);
        return view('panel.orders.edit')->with([
            'order' => $order,
            'provinces' => $provinces,
            'cities' => $cities,
        ]);
    }


    public function update(Request $request, Order $order)
    {
        $this->authorize('edit order');
        $request->merge([
            'mobile' => convertNumbers($request->mobile, false)
        ]);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'mobile' => 'required|regex:/^09\d{9}$/',
            'province' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'nullable',
            'shipping' => 'required|string|max:255',
            'status' => ['required', Rule::in(array_keys(Order::statuses()))],
            'payment' => ['nullable', Rule::in(array_keys(Order::payments()))],
            'shipping_price' => 'required|numeric',
            'address' => 'required|string',
            'description' => 'nullable|string',
        ], [], [
            'name' => 'نام و نام خانوادگی',
            'email' => 'آدرس ایمیل',
            'mobile' => 'شماره موبایل',
            'province' => 'استان',
            'city' => 'شهر',
            'postal_code' => 'کد پستی',
            'shipping' => 'روش ارسال',
            'status' => 'وضعیت سفارش',
            'payment' => 'روش پرداخت',
            'shipping_price' => 'هزینه ارسال',
            'address' => 'آدرس',
            'description' => 'توضیحات',
        ]);

        foreach ($request->items as $item) {
            $validator = Validator::make($item, [
                'qty' => 'required|numeric|min:1',
                'price' => 'required|numeric|min:0'
            ], [], [
                'qty' => 'تعداد محصول',
                'price' => 'مبلغ محصول'
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }
        }
        if ($request->status == 'completed' && $order->status == 'processing') {
            event(new OrderCompleted($order));
        }
        if ($request->status == 'sent') {
            sendSms(['code' => (string)$order->code], 'order_sent', $order->user->mobile);
        }

        $order->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'province' => $request->province,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'shipping' => $request->shipping,
            'status' => $request->status,
            'payment' => $request->payment,
            'shipping_price' => $request->shipping_price,
            'address' => $request->address,
            'description' => $request->description,
            'is_approved' => $request->filled('is_approved'),
            'is_paid' => $request->filled('is_paid'),
        ]);

        foreach ($request->items as $key => $item) {
            $order->items()->where('id', $key)->update([
                'quantity' => $item['qty'],
                'price' => $item['price'],
                'total_price' => $item['price'] * $item['qty'],
            ]);
        }

        return redirect()->route('panel.orders.index')
            ->with('success', 'سفارش مورد نظر شما با موفقیت ویرایش شد');
    }


    public function destroy(Order $order)
    {
        $this->authorize('delete order');
        $order->items()->delete();
        $order->transactions()->delete();
        $order->delete();
        return redirect()->route('panel.orders.index')->with('success', 'صفحه مورد نظر شما با موفقیت حذف شد');
    }

    public function action(Request $request)
    {
        switch($request->action) {
            case 'mark_processing': {
                return $this->updateStatus($request, 'processing');
            }
            case 'mark_completed': {
                return $this->updateStatus($request, 'completed');
            }
            case 'check_orders': {
                return $this->checkOrderIsPaid();
            }
            case 'print_label': {
                return $this->labelPrint($request);
            }
            case 'print_factor': {
                return $this->factorPrint($request);
            }
            default: {
                return back()->withErrors('دستور انتخاب شده نامعتبر است');
            }
        }
    }

    public function updateStatus(Request $request, $status)
    {
        $selected_orders = explode(',', $request->orders);
        Order::whereIn('id', $selected_orders)->update([
            'status' => $status
        ]);
        return redirect()->route('panel.orders.index')->with([
            'success' => 'تغییر وضعیت سفارشات انتخاب شده با موفقیت انجام شد'
        ]);
    }
    public function labelPrint(Request $request)
    {
        $selected_orders = explode(',', $request->orders);
        $orders = Order::whereIn('id', $selected_orders)->orderBy('created_at','desc')->get();
        return view('panel.orders.print.label', compact('orders'));
    }
    public function factorPrint(Request $request)
    {
        $selected_orders = explode(',', $request->orders);
        $orders = Order::whereIn('id', $selected_orders)->orderBy('created_at','desc')->get();
        return view('panel.orders.print.factor', compact('orders'));
    }


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
        return redirect()->route('panel.orders.index')->with([
            'success' => 'بررسی سفارشات با موفقیت انجام شد'
        ]);
    }

}
