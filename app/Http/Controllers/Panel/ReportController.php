<?php

namespace App\Http\Controllers\Panel;

use App\Order;
use App\ProductCategory;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Option;
use App\Product;

class ReportController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('view orders');
        $products = Product::all();
        $categories = ProductCategory::all();
        $provinces = collect(config('locality.provinces'));
        $cities = collect(config('locality.cities'));

        return view('panel.reports.index')->with([
            'products' => $products,
            'categories' => $categories,
            'provinces' => $provinces,
            'cities' => $cities,
        ]);
    }

    public function chart(Request $request)
    {
        $this->authorize('view orders');
        $transactions = Transaction::with('order')->where('is_paid',true);

        if ($request->start_date) {
            $start_date = Carbon::createFromFormat('Y-m-d', Date('Y-m-d', str_limit(request('start_date'), 10, '')));
            $start_date->startOfDay();
            $transactions = $transactions->where('updated_at', '>=', $start_date);
        }

        if ($request->end_date) {
            $end_date = Carbon::createFromFormat('Y-m-d', Date('Y-m-d', str_limit(request('end_date'), 10, '')));
            $end_date->endOfDay();
            $transactions = $transactions->where('updated_at', '<=', $end_date);
        }

        if (is_array($request->get('products'))) {
            if(count($request->get('products')) > 0) {
                $transactions = $transactions->whereHas('order',function($q) use($request) {
                    $q->whereHas('items',function($q) use($request) {
                        $q->whereIn('product_id',$request->get('products'));
                    });
                });
            }
        }

        if (is_array($request->get('categories'))) {
            if(count($request->get('categories')) > 0) {
                $transactions = $transactions->whereHas('order',function ($q) use($request){
                    $q->whereHas('items',function($q) use($request) {
                        $q->whereHas('product',function($q2) use($request) {
                            $q2->whereHas('categories',function ($q3) use($request) {
                                $q3->whereIn('id',$request->get('categories'));
                            });
                        });
                    });
                });
            }
        }

        if (is_array($request->get('provinces'))) {
            if(count($request->get('provinces')) > 0) {
                $transactions = $transactions->whereHas('order',function($q) use ($request) {
                    $q->whereIn('province', $request->get('provinces'));
                });
            }
        }
        if (is_array($request->get('cities'))) {
            if(count($request->get('cities')) > 0) {
                $transactions = $transactions->whereHas('order',function($q) use($request) {
                    $q->whereIn('city', $request->get('cities'));
                });
            }
        }


        $transactions = $transactions->orderBy('updated_at','asc')->get();
        $grouped = $transactions->groupBy(function ($transaction) {
            return jd($transaction->updated_at,'Y/m/d');
        });
        $labels = array_keys($grouped->toArray());

        $order_price_dataset = [
            'label' =>  'مبلغ سفارش',
            'data' =>  [],
            'backgroundColor' =>  [
                'rgba(255, 99, 132, 0.2)',
            ],
            'borderColor' =>  [
                'rgba(255, 99, 132, 1)',
            ],
            'tension' => 0.1,
            'borderWidth' =>  1
        ];
        $discount_price_dataset = [
            'label' =>  'تخفیف',
            'data' =>  [],
            'backgroundColor' =>  [
                'rgba(255, 206, 86, 0.2)',
            ],
            'borderColor' =>  [
                'rgba(255, 206, 86, 1)',
            ],
            'tension' => 0.1,
            'borderWidth' =>  1
        ];
        $shipping_price_dataset = [
            'label' =>  'هزینه ارسال',
            'data' =>  [],
            'backgroundColor' =>  [
                'rgba(75, 192, 192, 0.2)',
            ],
            'borderColor' =>  [
                'rgba(75, 192, 192, 1)',
            ],
            'tension' => 0.1,
            'borderWidth' =>  1
        ];
        $paid_dataset = [
            'label' =>  'پرداخت شده',
            'data' =>  [],
            'backgroundColor' =>  [
                'rgba(153, 102, 255, 0.2)',
            ],
            'borderColor' =>  [
                'rgba(153, 102, 255, 1)',
            ],
            'tension' => 0.1,
            'borderWidth' =>  1
        ];
        $net_amount_dataset = [
            'label' =>  'خالص درآمد',
            'data' =>  [],
            'backgroundColor' =>  [
                'rgba(255, 159, 64, 0.2)',
            ],
            'borderColor' =>  [
                'rgba(255, 159, 64, 1)',
            ],
            'tension' => 0.1,
            'borderWidth' =>  1
        ];

        foreach($grouped as $transactions) {
            $order_price = 0;
            $order_discount = 0;
            $order_shipping_price = 0;
            $paid_price = 0;
            $calculated_orders = [];
            foreach($transactions as $transaction) {
                if(!in_array($transaction->order_id,$calculated_orders)) {
                    $order = $transaction->order;
                    if($order) {
                        $order_price += $order->getOrderPrice();
                        $order_discount += ($order->discount + $order->shipping_discount);
                        $order_shipping_price += $order->shipping_price;
                    }
                    $calculated_orders[] = $transaction->order_id;
                }
                $paid_price += ($transaction->port == 'idpay' ? $transaction->price/10 : $transaction->price);
            }
            $order_price_dataset['data'][] = $order_price;
            $discount_price_dataset['data'][] = $order_discount;
            $shipping_price_dataset['data'][] = $order_shipping_price;
            $paid_dataset['data'][] = $paid_price;
            $net_amount_dataset['data'][] = $paid_price - $order_shipping_price;
        }

        $datasets = [$order_price_dataset, $discount_price_dataset, $shipping_price_dataset, $paid_dataset, $net_amount_dataset];

        return response([
            'labels' => $labels,
            'datasets' => $datasets,
            'general' => [
                'order_price' => number_format(array_sum($order_price_dataset['data'])) . ' تومان',
                'discount_price' => number_format(array_sum($discount_price_dataset['data'])) . ' تومان',
                'shipping_price' => number_format(array_sum($shipping_price_dataset['data'])) . ' تومان',
                'paid_price' => number_format(array_sum($paid_dataset['data'])) . ' تومان',
                'net_price' => number_format(array_sum($net_amount_dataset['data'])) . ' تومان',
            ]
        ]);

    }


}
