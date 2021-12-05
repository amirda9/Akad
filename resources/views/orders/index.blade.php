@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'جستجو سفارش',
        'description' => getOption('site_information.description',config('settings.description')),
        'image' => getImageSrc(getOption('site_information.logo'))
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'جستجو سفارش' }}</title>
@endsection
@section('content')
    <div class="container">
        {{ Breadcrumbs::render('orders.index') }}
        <div class="bg-white rounded shadow-sm p-3">
            @include('components.messages')
            <h4 class="text-secondary pb-3 border-bottom mb-4">جستجو سفارش</h4>
            <p class="mb-4">در صورتی که قبلا از این وبسایت خرید کرده اید، برای مشاهده سفارش خود لطفا کد سفارش خود را وارد کنید:</p>
            <form class="form-inline" method="get" action="{{ route('orders.index') }}">
                <input type="text" class="form-control" name="code" value="{{ old('code') }}"
                       id="code" placeholder="کد سفارش خود را وارد کنید" />
                <button type="submit" class="btn btn-primary mr-3">مشاهده سفارش</button>
            </form>
        </div>
    </div>
@endsection
