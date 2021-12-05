@extends('panel.layouts.master')

@section('head')
    <link href="{{ asset('css/persian-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <h1 class="text-secondary m-0">مدیریت سفارشات</h1>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">

                @include('components.messages')

                <div class="card">
                    <div class="card-body">
                        <form method="get">
                            <div class="row">
                                <div class="col-12 col-lg-3 form-group">
                                    <input id="search" name="search"
                                           value="{{ request('search') }}"
                                           class="form-control" autocomplete="off"
                                           placeholder="کد سفارش، شماره، ایمیل و یا نام کاربر">
                                </div>
                                <div class="col-12 col-lg-3 form-group">
                                    <div class="row no-gutters">
                                        <div class="col-6 pl-1">
                                            <input id="start_datepicker" type="text" class="form-control" autocomplete="off" placeholder="تاریخ شروع">
                                            <input id="start_date" value="{{ request('start_date') }}" type="hidden" name="start_date">
                                        </div>
                                        <div class="col-6 pr-1">
                                            <input id="end_datepicker" type="text" class="form-control" autocomplete="off" placeholder="تاریخ پایان">
                                            <input id="end_date" value="{{ request('end_date') }}" type="hidden" name="end_date">
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $selected_products = [];
                                    if(is_array(request('products'))) {
                                        $selected_products = request('products');
                                    }
                                @endphp
                                <div class="col-12 col-lg-3 form-group">
                                    <select id="products" multiple data-actions-box="true" data-selected-text-format="count" name="products[]" data-live-search="true" multiple class="form-control selectpicker" title="انتخاب محصول">
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}"  {{ in_array($product->id, $selected_products) ? 'selected' : '' }}>{{ $product->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @php
                                    $selected_provinces = [];
                                    if(is_array(request('provinces'))) {
                                        $selected_provinces = request('provinces');
                                    }
                                @endphp
                                <div class="col-12 col-lg-3 form-group">
                                    <select name="provinces[]" id="provinces" data-actions-box="true" data-selected-text-format="count" multiple data-live-search="true" title="انتخاب استان" class="form-control selectpicker">
                                        @foreach($provinces as $province)
                                            <option value="{{ $province['id'] }}" {{ in_array($province['id'], $selected_provinces)  ? 'selected' : ''}}>{{ $province['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @php
                                    $selected_cities = [];
                                    if(is_array(request('cities'))) {
                                        $selected_cities = request('cities');
                                    }
                                @endphp
                                <div class="col-12 col-lg-3 form-group">
                                    <select name="cities[]" id="cities" data-actions-box="true" data-selected-text-format="count" multiple data-live-search="true" title="انتخاب شهرستان" class="form-control selectpicker">
                                        @foreach($cities as $city)
                                            <option value="{{ $city['id'] }}" {{ in_array($city['id'], $selected_cities) ? 'selected' : '' }}>{{ $city['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-3 form-group">
                                    <select name="shipping" id="shipping" data-live-search="true" title="نوع ارسال" class="form-control selectpicker">
                                        <option value="">نمایش همه</option>
                                        @if($shippings)
                                            @foreach($shippings as $shipping)
                                                <option value="{{ $shipping['title'] }}" {{ request('shipping') == $shipping['title'] ? 'selected' : '' }}>{{ $shipping['title'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>


                                @php
                                    $selected_statuses = [];
                                    if(is_array(request('statuses'))) {
                                        $selected_statuses = request('statuses');
                                    }
                                @endphp

                                <div class="col-12 col-lg-3 form-group">
                                    <select id="statuses" multiple data-selected-text-format="count" name="statuses[]" multiple class="form-control selectpicker" title="انتخاب وضعیت سفارش">
                                        @foreach(\App\Order::statuses() as $key => $status)
                                            <option value="{{ $key }}" {{ in_array($key, $selected_statuses) ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-3 form-group">
                                    <select id="number" name="number" class="form-control selectpicker" title="تعداد در صفحه">
                                        <option value="25"  {{ request('number') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('number') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('number') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-3 form-group">
                                    <select id="is_paid" name="is_paid" class="form-control selectpicker" title="وضعیت پرداخت">
                                        <option value="">مشاهده همه</option>
                                        <option value="is_paid" {{ request('is_paid') == 'is_paid' ? 'selected' : '' }}>پرداخت شده</option>
                                        <option value="not_paid" {{ request('is_paid') == 'not_paid' ? 'selected' : '' }}>پرداخت نشده</option>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-3 form-group">
                                    <button class="btn btn-success" type="submit">جستجو</button>
                                    <a class="btn btn-gray-200" href="{{ route('panel.orders.index') }}">
                                        مشاهده همه
                                    </a>
                                </div>

                            </div>
                        </form>
                        <hr>

                        <form id="actionForm" class="mb-3" action="{{route('panel.orders.action')}}" method="post">
                                @csrf
                                <input type="hidden" name="orders">
                                <select class="selectpicker" name="action">
                                    <option value="-1">کارهای دسته جمعی</option>
                                    <option value="print_label">پرینت برچسب</option>
                                    <option value="print_factor">پرینت فاکتور</option>
                                    <option value="check_orders">بررسی سفارشات پرداخت نشده</option>
                                    <option value="mark_processing">تغییر وضعیت به درحال انجام</option>
                                    <option value="mark_completed">تغییر وضعیت به تکمیل شده </option>
                                </select>
                                <button type="submit" class="btn btn-outline-primary">اجرا</button>
                            </form>

                            <div class="table-responsive">
                                @if($expired_reserved_orders->count())
                                    <table class="table table-sm table-hover table-striped text-center">
                                        <thead>
                                        <tr>
                                            <th><input type="checkbox"  id="checkall"></th>
                                            <th class="text-center">کد</th>
                                            <th class="text-center">کاربر</th>
                                            <th class="text-center">تاریخ</th>
                                            <th class="text-center">مبلغ</th>
                                            <th class="text-center">وضعیت</th>
                                            <th class="text-center">پرداخت</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($expired_reserved_orders as $expired_reserved_order)
                                            <tr>
                                                <td><input type="checkbox"  class="checkbox" name="item" value="{{$expired_reserved_order->id}}"></td>
                                                <td class="align-middle fa-num">
                                                    {{ $expired_reserved_order->code }}
                                                </td>
                                                <td class="align-middle">
                                                    <div>{{ $expired_reserved_order->name }}</div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ jd($expired_reserved_order->created_at) }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    <strong class="fa-num">{{ number_format($expired_reserved_order->getFinalPrice()) }} تومان</strong>
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ $expired_reserved_order->getStatusTitle() }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    @if($expired_reserved_order->is_paid)
                                                        <span class="badge badge-success">پرداخت شده</span>
                                                    @else
                                                        <span class="badge badge-danger">پرداخت نشده</span>
                                                    @endif
                                                </td>
                                                <td class="text-left align-middle">
                                                    <a href="{{route('panel.orders.show',$expired_reserved_order)}}" class="btn btn-sm btn-success">
                                                        مشاهده
                                                    </a>
                                                    <a href="{{route('panel.orders.edit',$expired_reserved_order)}}" class="btn btn-sm btn-primary">
                                                        ویرایش
                                                    </a>
                                                    <form class="d-inline" method="post" action="{{ route('panel.orders.destroy',$expired_reserved_order) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('آیا مطمئن هستید؟')">
                                                            حذف
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                <table class="table table-sm table-hover table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox"  id="checkall"></th>
                                        <th class="text-center">کد</th>
                                        <th class="text-center">کاربر</th>
                                        <th class="text-center">تاریخ</th>
                                        <th class="text-center">مبلغ</th>
                                        <th class="text-center">وضعیت</th>
                                        <th class="text-center">پرداخت</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td><input type="checkbox"  class="checkbox" name="item" value="{{$order->id}}"></td>
                                            <td class="align-middle fa-num">
                                                {{ $order->code }}
                                            </td>
                                            <td class="align-middle">
                                                <div>{{ $order->name }}</div>
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ jd($order->created_at) }}
                                            </td>
                                            <td class="text-center align-middle">
                                                <strong class="fa-num">{{ number_format($order->getFinalPrice()) }} تومان</strong>
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $order->getStatusTitle() }}
                                            </td>
                                            <td class="text-center align-middle">
                                                @if($order->is_paid)
                                                    <span class="badge badge-success">پرداخت شده</span>
                                                @else
                                                    <span class="badge badge-danger">پرداخت نشده</span>
                                                @endif
                                            </td>
                                            <td class="text-left align-middle">
                                                <a href="{{route('panel.orders.show',$order)}}" class="btn btn-sm btn-success">
                                                    مشاهده
                                                </a>
                                                <a href="{{route('panel.orders.edit',$order)}}" class="btn btn-sm btn-primary">
                                                    ویرایش
                                                </a>
                                                <form class="d-inline" method="post" action="{{ route('panel.orders.destroy',$order) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('آیا مطمئن هستید؟')">
                                                        حذف
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $orders->links() }}
                            </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/persian-datepicker.min.js') }}"></script>

    <script>
        var start_datepicker;
        var end_datepicker;
        $('body').on('change','#start_datepicker',function() {
            if($(this).val() == '') {
                $('#start_date').val('');
            }
        });
        $('body').on('change','#end_datepicker',function() {
            if($(this).val() == '') {
                $('#end_date').val('');
            }
        });
        $(document).ready(function () {
            start_datepicker = $('#start_datepicker').persianDatepicker({
                format: 'YYYY/MM/DD',
                initialValue: false,
                onSelect: startDateSelect
            });
            end_datepicker = $('#end_datepicker').persianDatepicker({
                format: 'YYYY/MM/DD',
                initialValue: false,
                onSelect: endDateSelect
            });
            const selected_start_date = $('#start_date').val();
            if(selected_start_date) {
                start_datepicker.setDate(parseFloat(selected_start_date));
            }
            const selected_end_date = $('#end_date').val();
            if(selected_end_date) {
                end_datepicker.setDate(parseFloat(selected_end_date));
            }
        });

        function startDateSelect(unix) {
            $('#start_date').val(unix);
            start_datepicker.setDate(unix);
            start_datepicker.hide();
        }
        function endDateSelect(unix) {
            $('#end_date').val(unix);
            end_datepicker.setDate(unix);
            end_datepicker.hide();
        }

    </script>

    <script>
        var selected = [];
        $('body').on('change','#checkall',function() {
            if($(this).is(':checked')){
                $(".checkbox").prop("checked",true);
            } else {
                $(".checkbox").prop("checked",false);
            }
        }).on('submit','#actionForm', function(e) {
            let form = this;
            let action = $('select[name="action"]').val();
            if(action == '-1') {
                e.preventDefault();
            }
            if(action == 'trash' || action == 'mark_processing' || action == 'mark_completed') {
                if(!confirm('آیا مطمئن هستید؟')) {
                    e.preventDefault();
                }
            }
            let values = [];
            $('.checkbox:checked').each((index, item) => {
                values.push(item.value);
            });
            $('input[name="orders"]').val(values);
            if(action == 'print_label' || action == 'print_factor') {
                window.open('', 'formpopup', 'width=500,resizeable');
                form.target = 'formpopup';
            }
        });
    </script>
@endsection
