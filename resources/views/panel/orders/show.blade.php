@extends('panel.layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <h1 class="text-secondary m-0">مشاهده سفارش</h1>
                <a class="btn btn-secondary" href="{{ route('panel.orders.index') }}">
                    بازگشت
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="bg-white shadow-sm rounded mb-4 p-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                            <span>هزینه سفارش :</span>
                            <span class="fa-num">{{ number_format($order->items()->sum('total_price')) }} تومان</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                            <span>هزینه ارسال :</span>
                            <span class="fa-num">{{ number_format($order->shipping_price) }} تومان</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                            <span>تخفیف :</span>
                            <span class="fa-num">{{number_format($order->getTotalDiscount())}} تومان </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                            <span>مبلغ پرداخت شده :</span>
                            <span class="fa-num">{{number_format($order->received_money)}} تومان </span>
                        </div>
                        <hr />
                        <div class="d-flex justify-content-between align-items-center flex-wrap text-dark">
                            <strong>مبلغ قابل پرداخت :</strong>
                            <strong class="fa-num">{{ number_format($order->getPayablePrice()) }} تومان</strong>
                        </div>
                    </div>
                    <div class="bg-white shadow-sm rounded mb-4 p-1">
                        @foreach($order->transactions()->orderBy('created_at','desc')->get() as $transaction)
                        @if($transaction->message)
                        <div class="p-2 {{ $transaction->is_paid ? 'alert-success' : 'alert-warning' }} m-3">
                            <p>{{ $transaction->message }}</p>
                            @if($transaction->is_paid)
                            <p class="text-break">شماره تراکنش : {{ $transaction->transaction_id }}</p>
                            <p class="text-break">شماره پیگیری : {{ $transaction->reference_id}}</p>
                            <p class="text-break">شماره پیگیری بانک : {{ $transaction->inner_reference_id}}</p>
                            <p class="text-break">مبلغ : {{ number_format($transaction->price/10) }} تومان</p>
                            @endif
                            <div class="d-flex flex-row justify-content-between border-top {{ $transaction->is_paid ? 'border-success' : 'border-warning' }} pt-2">
                                <small>{{ \App\Order::payments($transaction->port)['title'] ?? 'نامشخص' }}</small>
                                <small>{{ jd($transaction->created_at) }}</small>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="bg-white mb-4 shadow-sm rounded">
                        <div class="table-responsive">
                            <table class="table fa-num table-borderless m-0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <span class="text-secondary">کد سفارش :</span>
                                            <strong class="fa-num">{{ $order->code }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-secondary">وضعیت :</span>
                                            <strong>{{ $order->getStatusTitle() }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-secondary">تاریخ :</span>
                                            <strong>{{ jd($order->created_at) }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-secondary">وضعیت تایید :</span>
                                            @if($order->is_approved)
                                            <strong class="badge badge-success">تایید شده</strong>
                                            @else
                                            <strong class="badge badge-danger">تایید نشده</strong>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-secondary">وضعیت پرداخت :</span>
                                            @if($order->is_paid)
                                            <strong class="badge badge-success">پرداخت شده</strong>
                                            @else
                                            <strong class="badge badge-danger">پرداخت نشده</strong>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-secondary">روش پرداخت :</span>
                                            <strong>{{ $order->getPaymentTitle() ?: '---' }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-secondary">نام و نام خانوادگی :</span>
                                            <strong>{{ $order->name }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-secondary">آدرس ایمیل :</span>
                                            <strong>{{ $order->email ?: '---' }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-secondary">شماره موبایل :</span>
                                            <strong>{{ $order->mobile ?: '---' }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-secondary">استان :</span>
                                            <strong>{{ $order->getProvince()['name'] }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-secondary">شهر :</span>
                                            <strong>{{ $order->getCity()['name'] }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-secondary">کد پستی :</span>
                                            <strong>{{ $order->postal_code ?: '---' }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <span class="text-secondary">آدرس :</span>
                                            <strong>{{ $order->address }}</strong>
                                        </td>
                                    </tr>
                                    @if($order->description)
                                    <tr>
                                        <td colspan="3">
                                            <span class="text-secondary">توضیحات :</span>
                                            <strong>{{ $order->description }}</strong>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan="3">
                                            <span class="text-secondary">روش ارسال :</span>
                                            <strong>{{ $order->shipping }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="row">
                            @foreach($order->items as $cart_item)
                            <div class="col-12 col-lg-6">
                                <div class="p-2 bg-white d-flex shadow-sm border rounded border-gray-200 mb-3">
                                    <a href="{{ $cart_item->product->getRoute() }}" target="_blank">
                                        <img src="{{ getImageSrc($cart_item->product->getImage(),'product_card') }}" class="img-fluid ml-2" style="width: 60px;" />
                                    </a>
                                    <div class="d-flex flex-grow-1 flex-column justify-content-between">
                                        <div>
                                            <p class="m-0">
                                                <a href="{{ $cart_item->product->getRoute() }}" class="text-decoration-none text-secondary" target="_blank">
                                                    {{ $cart_item->product->title }}
                                            </p>
                                            </a>
                                            <div class="my-1 text-muted">
                                                <small>{{ $cart_item->sub_title }}</small>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center text-gray-500 fa-num">
                                            <small>{{ $cart_item->quantity }} عدد</small>
                                            <small>{{ number_format($cart_item->total_price) }} تومان</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection