@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) . ' | ' . 'جستجو',
        'description' => getOption('site_information.description',config('settings.meta_description')),
        'url' => route('search')
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) . ' | ' . 'جستجو' }}</title>
@endsection
@section('content')
    <div class="container">
        {{ Breadcrumbs::render('search',request()->get('q')) }}
        @include('components.messages')
        <div class="bg-white border border-gray-200">
            @if($products)
                <div class="d-flex justify-content-between p-3 border-bottom border-gray-200" style="font-size:13px;">
                    <div class="">
                    <span class="text-gray-600">
                        <i class="far fa-sort text-gray-500"></i>
                        مرتب سازی بر اساس :
                    </span>
                        <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'latest']) }}" class="products-order-btn btn btn-sm btn-light {{ request('orderBy') ? (request('orderBy') == 'latest' ? 'active' : '') : 'active'  }}">جدیدترین</a>
                        <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'oldest']) }}" class="products-order-btn btn btn-sm btn-light {{ request('orderBy') ? (request('orderBy') == 'oldest' ? 'active' : '') : ''  }}">قدیمی ترین</a>
                        <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'lcost']) }}" class="products-order-btn btn btn-sm btn-light {{ request('orderBy') ? (request('orderBy') == 'lcost' ? 'active' : '') : ''  }}">ارزان ترین</a>
                        <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'hcost']) }}" class="products-order-btn btn btn-sm btn-light {{ request('orderBy') ? (request('orderBy') == 'hcost' ? 'active' : '') : ''  }}">گران ترین</a>
                    </div>
                    <span class="fa-num text-gray-500">
                    {{ number_format($products->total()) }} محصول
                </span>
                </div>
                @if($products->count())
                    <div class="products-container p-0">
                        <div class="row no-gutters" style="margin-left: -1px;">
                            @foreach($products as $product)
                                <div class="col-12 col-lg-3 col-md-4 col-sm-6 d-flex">
                                    @include('components.productCard2',[
                                        'product' => $product
                                    ])
                                </div>
                            @endforeach
                        </div>
                    </div>
                <div class="pt-3 px-3 pb-0 overflow-auto">
                    {{ $products->links() }}
                </div>
                @else
                    @include('components.empty')
                @endif
            @else
                <div class="px-3 px-lg-4 py-5">
                    <form action="{{ route('search') }}">
                        <div class="row">
                            <div class="col-12 col-lg-8 offset-lg-2">
                                <div class="mb-5 overflow-hidden shadow-sm border bg-primary text-white d-flex rounded border-primary">
                                    <div class="p-3 d-flex align-items-center">
                                        <i class="fal fa-info-circle fa-2x"></i>
                                    </div>
                                    <div class="p-2 bg-white text-primary flex-grow-1">
                                        <h4>جستجو</h4>
                                        <p class="m-0">لطفا عنوان محصول مورد نظر خود را در قسمت مشخص شده وارد کنید و روی دکمه جستجو کلیک نمایید</p>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <input type="text" name="q" placeholder="متن جستجو را وارد کنید ..." class="form-control">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-success">
                                            جستجو
                                            <i class="fal fa-search mr-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
