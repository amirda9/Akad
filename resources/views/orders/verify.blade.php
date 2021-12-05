@extends('layouts.app')

@section('meta')
@include('components.meta',[
'title' => getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'نتیجه پرداخت',
'description' => getOption('site_information.description',config('settings.description')),
'image' => getImageSrc(getOption('site_information.logo'))
])
@endsection
@section('title')
<title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'نتیجه پرداخت' }}</title>
@endsection

@section('content')
<div class="container py-5">
    <div class="card card-body py-5">
        @if($success ?? false)
        <div class="text-center">
            <h1 class="text-success mb-4">پرداخت موفق!</h1>
            <p class="mb-4">
                {{ ($message ?? false) ? $message : 'پرداخت شما با موفقیت در سیستم ثبت شد و سفارش شما در حال انجام می باشد.' }}
            </p>
            @if($transaction ?? false)
            <p class="mb-4">
                <strong>کد پیگیری داخلی : {{ $transaction->reference_id }}</strong>
                <strong>کد پیگیری بانک: {{ $transaction->inner_reference_id }}</strong>
            </p>
            @endif
            @if($order ?? false)
            <a class="btn btn-primary" href="{{ route('orders.show',$order->code) }}">
                مشاهده سفارش
            </a>
            @endif
        </div>
        @else
        <div class="text-center">
            <h1 class="text-danger mb-4">پرداخت ناموفق!</h1>
            <p class="mb-4">
                {{ ($message ?? false) ? $message : 'پرداخت شما با خطا مواجه شد لطفا دوباره پرداخت را انجام دهید و یا با پشتیبانی تماس بگیرید.' }}
            </p>

            <div>
                @if($order ?? false)
                <form class="d-inline" method="post" action="{{ route('orders.pay',$order->code) }}">
                    @if($transaction ?? false)
                    <input type="hidden" name="payment" value="{{ $transaction->port }}">
                    @endif
                    <button type="submit" class="btn btn-success">تلاش مجدد برای پرداخت</button>
                </form>
                <a class="btn btn-primary" href="{{ route('orders.show',$order->code) }}">
                    مشاهده سفارش
                </a>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection