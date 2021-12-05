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
            @if($order->is_approved)
                @if(!$order->is_paid)
                    <div class="col-12 mb-5">
                        <div class="bg-white shadow-sm rounded p-3 text-secondary border-right border-5 border-primary">
                            <h4>در انتظار پرداخت</h4>
                            <p class="m-0">سفارش شما مورد تایید می باشد، لطفا جهت ادامه روند پردازش سفارش نسبت به پرداخت مبلغ سفارش خود اقدام نمایید.</p>
                        </div>
                    </div>
                @endif
            @else
                <div class="col-12 mb-5">
                    <div class="bg-white shadow-sm rounded p-3 text-secondary border-right border-5 border-primary">
                        <h4>در انتظار تایید</h4>
                        <p class="m-0">سفارش شما نیاز به تایید مدیریت دارد، برای ادامه لطفا منتظر تایید سفارش خود از طرف مدیریت باشید.</p>
                    </div>
                </div>
            @endif
            <div class="col-12 mb-5">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <h5 class="text-secondary mb-2">پرداخت :</h5>
                        @if($order->is_approved)
                            @if($order->is_paid)
                                <div class="bg-white rounded shadow-sm p-3 text-secondary mb-3">
                                    <h4 class="text-success">
                                        <i class="far fa-check-circle"></i>
                                        پرداخت موفق !
                                    </h4>
                                    <p class="m-0">
                                        مبلغ این سفارش با موفقیت پرداخت شده است.
                                    </p>
                                </div>
                            @else
                                <div class="bg-white rounded shadow-sm p-3 text-secondary mb-3">
                                    <form method="post" action="{{ route('orders.pay',$order->code) }}">
                                        @csrf
                                        @foreach(\App\Order::payments() as $key => $payment)
                                            <label id="payment-{{$key}}" class="d-flex align-items-center border rounded mb-3 p-2 shadow-md-hover cursor-pointer">
                                                <input type="radio" id="payment-{{$key}}" name="payment" value="{{$key}}">
                                                <div class="mr-2">
                                                    <strong>{{ $payment['title'] }}</strong>
                                                    <p class="m-0">{{ $payment['description'] }}</p>
                                                </div>
                                            </label>
                                        @endforeach
                                        <button class="btn btn-success btn-block btn-lg" type="submit">
                                            پرداخت
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <div class="bg-white rounded shadow-sm p-3 text-secondary mb-3">
                                <h4 class="text-tomato">
                                    <i class="far fa-info-circle"></i>
                                    در انتظار تایید !
                                </h4>
                                <p class="m-0">
                                    سفارش شما نیاز به تایید مدیریت دارد، برای پرداخت لطفا منتظر تایید سفارش خود از طرف مدیریت باشید.
                                </p>
                            </div>
                        @endif
                    </div>
                    <div class="col-12 col-lg-6">
                        <h5 class="text-secondary mb-2">خلاصه سفارش :</h5>
                        <div class="bg-white rounded shadow-sm p-3 text-secondary mb-3" style="font-size: 18px;">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <span>هزینه سفارش :</span>
                                <span class="fa-num">{{ number_format($order->items()->sum('total_price')) }} تومان</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <span>هزینه ارسال :</span>
                                <span class="fa-num">{{$order->getShippingPrice(true)}}</span>
                            </div>
                            @if($order->discount > 0)
                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                    <span>تخفیف :</span>
                                    <span class="fa-num">{{ number_format($order->discount) }} تومان</span>
                                </div>
                            @endif
                            <hr/>
                            @if($order->is_paid == false)
                                <div class="d-flex justify-content-between align-items-center flex-wrap text-dark">
                                    <strong>مبلغ قابل پرداخت :</strong>
                                    <strong class="fa-num">{{ $order->getPayablePrice(true) }}</strong>
                                </div>
                            @endif
                            @if($order->is_paid == true)
                                <div class="d-flex justify-content-between align-items-center flex-wrap text-dark">
                                    <strong>مبلغ  پرداخت شده :</strong>
                                    <strong class="fa-num">{{ number_format($order->received_money) }} تومان</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-5">
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
