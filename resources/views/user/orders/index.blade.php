@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'لیست سفارشات',
        'description' => getOption('site_information.description',config('settings.description')),
        'image' => getImageSrc(getOption('site_information.logo'))
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'لیست سفارشات' }}</title>
@endsection

@section('head')
    <link href="{{ asset('css/persian-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-3 mb-lg-0">
                @include('user.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="bg-white p-4 mb-3 rounded shadow-sm text-secondary">
                    @include('components.messages')
                    <h3 class="text-secondary m-0">لیست سفارشات</h3>
                    <hr/>
                    <form method="get" class="mb-4">
                        <div class="row">
                            <div class="col-12 col-lg-4 mb-3">
                                <label for="search">کد سفارش</label>
                                <input id="search" name="search"
                                       value="{{ request('search') }}"
                                       class="form-control" autocomplete="off"
                                       placeholder="کد سفارش ...">
                            </div>
                            <div class="col-12 col-lg-4 mb-3">
                                <label for="start_date">بازه زمانی</label>
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
                            <div class="col-12 col-lg-4 mb-3">
                                <label for="statuses">وضعیت سفارش</label>
                                <select id="status" name="status" class="form-control selectpicker" title="انتخاب وضعیت سفارش">
                                    <option value="">نمایش همه</option>
                                    @foreach(\App\Order::statuses() as $key => $status)
                                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{$status}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-success" type="submit">جستجو</button>
                        <a class="btn btn-gray-200" href="{{ route('user.orders.index') }}">
                            مشاهده همه
                        </a>
                    </form>

                </div>
                @if($orders->count())
                    <div class="row">
                        @foreach($orders as $order)
                            <div class="col-12 col-lg-6">
                                @include('components.orders.card',['order' => $order])
                            </div>
                        @endforeach
                    </div>
                    <div class="overflow-auto">
                        {{ $orders->links() }}
                    </div>

                @else
                    <div class="bg-white p-3 rounded shadow-sm p-5 text-center">
                        @include('components.empty')
                    </div>
                @endif

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

@endsection
