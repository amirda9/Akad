@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'مشاهده سفارش',
        'description' => getOption('site_information.description',config('settings.description')),
        'image' => getImageSrc(getOption('site_information.logo'))
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'مشاهده سفارش' }}</title>
@endsection

@section('content')
    <div class="container">
        @include('components.cart.steps',['step' => $order->is_paid ? 4 : 3])
        @include('components.messages')
        <div class="row">
            <div class="col-12">
                <div class="row text-gray-500">
                    <div class="col-4 mb-3">
                        <div class="d-flex flex-wrap align-items-center justify-content-center">
                            <span>کد سفارش:</span>
                            <h4 class="mb-0 mr-2 fa-num">{{ $order->code }}</h4>
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="d-flex flex-wrap align-items-center justify-content-center">
                            <span>وضعیت:</span>
                            <h4 class="mb-0 mr-2 fa-num">{{ $order->getStatusTitle() }}</h4>
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="d-flex flex-wrap align-items-center justify-content-center">
                            <span>تاریخ:</span>
                            <h4 class="mb-0 mr-2 fa-num">{{ jd($order->created_at,'Y/m/d') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-5">
                <div class="bg-white shadow-sm rounded p-3 text-secondary border-right border-5 border-danger">
                    <h4>سفارش ناموفق!</h4>
                    <p class="m-0">سفارش شما منقضی شده است، لطفا جهت خرید مجدد اقدام کنید.</p>
                </div>
            </div>
            <div class="col-12 mb-5">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <h5 class="text-secondary mb-2">اطلاعات ارسال :</h5>
                        <div class="bg-white shadow-sm rounded">
                            <div class="table-responsive">
                                <table class="table fa-num table-borderless m-0">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <span class="text-secondary">نام و نام خانوادگی :</span>
                                            <strong>{{ $order->name }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-secondary">آدرس ایمیل :</span>
                                            <strong>{{ $order->email ?: '---' }}</strong>
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
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-secondary">شماره موبایل :</span>
                                            <strong>{{ $order->mobile ?: '---' }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-secondary">کد پستی :</span>
                                            <strong>{{ $order->postal_code ?: '---' }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <span class="text-secondary">آدرس :</span>
                                            <strong>{{ $order->address }}</strong>
                                        </td>
                                    </tr>
                                    @if($order->description)
                                        <tr>
                                            <td colspan="2">
                                                <span class="text-secondary">توضیحات :</span>
                                                <strong>{{ $order->description }}</strong>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="2">
                                            <span class="text-secondary">روش ارسال :</span>
                                            <strong>{{ $order->shipping }}</strong>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <h5 class="text-secondary mb-2">خلاصه سفارش :</h5>
                        <div class="bg-white rounded shadow-sm p-3 text-secondary mb-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <span>هزینه سفارش :</span>
                                <span class="fa-num">{{ number_format($order->items()->sum('total_price')) }} تومان</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <span>هزینه ارسال :</span>
                                <span class="fa-num">{{$order->getShippingPrice(true)}}</span>
                            </div>
                            @if($order->discount)
                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                    <span>تخفیف :</span>
                                    <span class="fa-num">{{ number_format($order->discount) }} تومان</span>
                                </div>
                            @endif
                            <hr/>
                            <div class="d-flex justify-content-between align-items-center flex-wrap text-dark">
                                <strong>مبلغ کل :</strong>
                                <strong class="fa-num">{{ $order->getPayablePrice(true) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-5">
                <h5 class="text-secondary mb-2">لیست محصولات :</h5>
                <div class="row">
                    @foreach($order->items as $cart_item)
                        <div class="col-12 col-lg-4">
                            @include('components.orders.item',['cart_item' => $cart_item])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
