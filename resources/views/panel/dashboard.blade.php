@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
            <h1 class="m-0 text-dark">پیشخوان</h1>
            </div>
        </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">

                @can('view users')
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner fa-num">
                                <h3>{{ $user_count }}</h3>
                                <p>کاربران 30 روز اخیر</p>
                            </div>
                            <div class="icon">
                                <i class="fal fa-users"></i>
                            </div>
                            <a href="{{ route('panel.users.index') }}" class="small-box-footer">
                            مشاهده بیشتر <i class="fad fa-arrow-circle-left"></i>
                            </a>
                        </div>
                    </div>
                @endcan

                @can('view orders')
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner fa-num">
                                <h3>{{ $orders_count }}</h3>
                                <p>سفارشات 30 روز اخیر</p>
                            </div>
                            <div class="icon">
                                <i class="fal fa-shopping-basket"></i>
                            </div>
                            <a href="{{ route('panel.orders.index') }}" class="small-box-footer">
                            مشاهده بیشتر <i class="fad fa-arrow-circle-left"></i>
                            </a>
                        </div>
                    </div>
                @endcan

                @can('view contacts')
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner fa-num">
                                <h3>{{ $contacts_count }}</h3>
                                <p>پیام های 30 روز اخیر</p>
                            </div>
                            <div class="icon">
                                <i class="fal fa-envelope"></i>
                            </div>
                            <a href="{{ route('panel.contacts.index') }}" class="small-box-footer">
                            مشاهده بیشتر <i class="fad fa-arrow-circle-left"></i>
                            </a>
                        </div>
                    </div>
                @endcan

                @can('view products')
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-purple">
                            <div class="inner fa-num">
                                <h3>{{ $views_count }}</h3>
                                <p>بازدید 30 روز اخیر</p>
                            </div>
                            <div class="icon">
                                <i class="fal fa-box"></i>
                            </div>
                            <a href="{{ route('panel.products.index') }}" class="small-box-footer">
                            مشاهده بیشتر <i class="fad fa-arrow-circle-left"></i>
                            </a>
                        </div>
                    </div>
                @endcan

            </div>

            <div class="row">
                @can('view orders')
                    <div class="col-12 col-lg-6">
                        @include('components.panel.dashboard.latestOrders',[
                            'latest_orders' => $latest_orders
                        ])
                    </div>
                @endcan
                @can('view contacts')
                    <div class="col-12 col-lg-6">
                        @include('components.panel.dashboard.latestContacts',[
                            'latest_contacts' => $latest_contacts
                        ])
                    </div>
                @endcan


                <div class="col-12 col-lg-6">
             
                    @include('components.panel.dashboard.latestProduct',[
                        'latest_products' => $latest_products
                    ])
                  
                </div>
            </div>

        </div>
    </div>

    </div>

@endsection
