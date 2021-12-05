@extends('panel.layouts.master')

@section('head')
    <link href="{{ asset('css/persian-datepicker.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="m-0 text-secondary">مدیریت کوپن های تخفیف</h1>
                <a class="btn btn-primary" href="{{ route('panel.coupons.create') }}">
                    ثبت کوپن جدید
                </a>
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
                                       placeholder="کد کوپن ، عنوان کوپن">
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
                            <div class="col-12 col-lg-3 form-group">
                                <select id="status" name="status" class="form-control selectpicker" title="انتخاب وضعیت سفارش">
                                    <option> وضعیت </option>
                                    @foreach(\App\Coupon::$statuses as $key => $status)
                                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-3 form-group">
                                <button class="btn btn-success" type="submit">جستجو</button>
                                <a class="btn btn-gray-200" href="{{ route('panel.coupons.index') }}">
                                    مشاهده همه
                                </a>
                            </div>
                        </div>
                    </form>


                    @if ($coupons->count())
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-striped text-center">
                            <thead >
                            <tr>
                                <th class="text-center"># </th>
                                <th class="text-center">کد</th>
                                <th class="text-center">عنوان </th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">میزان تخفیف</th>
                                <th class="text-center">تاریخ شروع </th>
                                <th class="text-center">تاریخ انقضا </th>
                                <th class="text-center">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                    <tr>
                                        <td class="align-middle fa-num">{{$coupon->id}}</td>
                                        <td class="text-center align-middle">{{$coupon->code}}</td>
                                        <td class="text-center align-middle">{{$coupon->title}}</td>
                                        <td class="text-center align-middle">{{$coupon->getStatusTitle()}}</td>
                                        <td class="text-center align-middle">{{$coupon->amount}} <strong>{{$coupon->getTypeTitle()}}</strong></td>
                                        <td class="text-center align-middle">
                                            <small>
                                                {{$coupon->start_date == null ? '---' : jd($coupon->start_date,'Y/m/d') }} 
                                            </small>
                                        </td>
                                        <td class="text-center align-middle">
                                            <small>{{ $coupon->end_date == null ? '---' : jd($coupon->end_date,'Y/m/d') ?: '---' }}</small>
                                        </td>
                                        <td>
                                            <form action="{{route('panel.coupons.destroy' , $coupon )}}" method="post">
                                                @csrf
                                                @method('delete')
                    
                                                <a href="{{route('panel.coupons.show' , $coupon->id )}}"  class="btn btn-sm btn-light" >مشاهده</a>
                                                <a href="{{route('panel.coupons.edit' , $coupon->id )}}" class="btn btn-sm btn-success " >ویرایش</a>
                                                <button type="submit" onclick="confirm('ایا از حذف اطمینان دارید؟')"   class="btn btn-sm btn-danger" >حذف</button>
                                            </form>  
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    @include('components.empty')
                @endif
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

@endsection
