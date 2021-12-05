@extends('panel.layouts.master')

@section('head')
    <link href="{{ asset('css/persian-datepicker.min.css') }}" rel="stylesheet">
    <style>
        .chart-info-box {
            margin: 5px;
            flex-grow: 1;
        }
    </style>
@endsection

@section('content')

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <h1 class="text-secondary m-0">گزارشات</h1>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                @include('components.messages')
                <div class="card">
                    <div class="card-body">
                        <form id="chartForm" method="post" action="{{ route('panel.reports.chart') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-3 form-group">
                                    <div class="row no-gutters">
                                        <div class="col-6 pl-1">
                                            <input id="start_datepicker" type="text" class="form-control" autocomplete="off" placeholder="تاریخ شروع">
                                            <input id="start_date" value="{{ \Carbon\Carbon::today()->addDays(-30)->timestamp . '000' }}" type="hidden" name="start_date">
                                        </div>
                                        <div class="col-6 pr-1">
                                            <input id="end_datepicker" type="text" class="form-control" autocomplete="off" placeholder="تاریخ پایان">
                                            <input id="end_date" value="{{ \Carbon\Carbon::today()->timestamp . '000' }}" type="hidden" name="end_date">
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
                                    $selected_categories = [];
                                    if(is_array(request('categories'))) {
                                        $selected_categories = request('categories');
                                    }
                                @endphp
                                <div class="col-12 col-lg-3 form-group">
                                    <select id="categories" multiple data-actions-box="true" data-selected-text-format="count"
                                            name="categories[]" data-live-search="true" multiple class="form-control selectpicker" title="انتخاب دسته بندی">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"  {{ in_array($category->id, $selected_categories) ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                    <button class="btn btn-success" type="submit">فیلتر</button>
                                    <button type="reset" id="resetButton" class="btn btn-gray-200">
                                        ریست
                                    </button>
                                </div>

                            </div>
                        </form>
                        <div class="mt-4">
                            <div id="info-box" class="mb-3 d-flex flex-row flex-wrap">
                                <div class="chart-info-box fa-num">
                                    <div class="rounded bg-gray p-3 text-white text-center">
                                        <p>مبلغ سفارش:</p>
                                        <h2 id="orderPriceHolder"></h2>
                                    </div>
                                </div>
                                <div class="chart-info-box fa-num">
                                    <div class="rounded bg-orange p-3 text-white text-center">
                                        <p>مبلغ تخفیف:</p>
                                        <h2 id="discountPriceHolder"></h2>
                                    </div>
                                </div>
                                <div class="chart-info-box fa-num">
                                    <div class="rounded bg-info p-3 text-white text-center">
                                        <p>هزینه ارسال:</p>
                                        <h2 id="shippingPriceHolder"></h2>
                                    </div>
                                </div>
                                <div class="chart-info-box fa-num">
                                    <div class="rounded bg-success p-3 text-white text-center">
                                        <p>پرداخت شده:</p>
                                        <h2 id="paidPriceHolder"></h2>
                                    </div>
                                </div>
                                <div class="chart-info-box fa-num">
                                    <div class="rounded bg-purple p-3 text-white text-center">
                                        <p>خالص دریافتی:</p>
                                        <h2 id="netPriceHolder"></h2>
                                    </div>
                                </div>
                            </div>
                            <canvas id="chart" width="200" height="100"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>


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
        }).on('reset','#chartForm',function () {
            setTimeout(() => {
                $('.selectpicker').selectpicker('refresh');
                startDateSelect(parseFloat("{{ \Carbon\Carbon::today()->addDays(-30)->timestamp . '000' }}"));
                endDateSelect(parseFloat("{{ \Carbon\Carbon::today()->timestamp . '000' }}"));
            },10);
        });
        $(document).ready(function () {
            start_datepicker = $('#start_datepicker').persianDatepicker({
                format: 'YYYY/MM/DD',
                onSelect: startDateSelect
            });
            end_datepicker = $('#end_datepicker').persianDatepicker({
                format: 'YYYY/MM/DD',
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

            var options = {
                beforeSubmit:  beforeSubmit,  // pre-submit callback
                success:       showResults  // post-submit callback
            };
            $('#chartForm').ajaxForm(options).submit();
        });

        function showResults(res, statusText, xhr, $form)  {
            console.log(res);
            chart.data.labels = res.labels;
            chart.data.datasets = res.datasets;
            chart.update();
            $('#orderPriceHolder').text(res.general.order_price);
            $('#discountPriceHolder').text(res.general.discount_price);
            $('#shippingPriceHolder').text(res.general.shipping_price);
            $('#paidPriceHolder').text(res.general.paid_price);
            $('#netPriceHolder').text(res.general.net_price);
        }
        function beforeSubmit(formData, jqForm, options) {
            $('#orderPriceHolder').text('');
            $('#discountPriceHolder').text('');
            $('#shippingPriceHolder').text('');
            $('#paidPriceHolder').text('');
            $('#netPriceHolder').text('');
            return true;
        }

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

        var chart = new Chart('chart', {
            type: 'line',
            data: {
                labels: [],
                datasets: []
            },
            options: {
                cubicInterpolationMode: 'default'
            }
        });

    </script>

@endsection
