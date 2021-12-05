@extends('panel.layouts.master')

@section('head')
    <link href="{{ asset('css/persian-datepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                @include('panel.products.edit.tab')
                <div class="d-flex flex-row align-items-center justify-content-between">
                    <h1 class="m-0">تاریخچه تغییرات</h1>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                @include('components.messages')
                <div class="card card-body">
                    <div class="mb-3">
                        <form method="get">
                            <div class="row">
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
                                    <button class="btn btn-success" type="submit">جستجو</button>
                                    <a class="btn btn-gray-200" href="{{ route('panel.products.logs',$product) }}">
                                        مشاهده همه
                                    </a>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>عنوان</th>
                                <th>کاربر</th>
                                <th>تاریخ</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->content }}</td>
                                    <td>{{ $log->user->name ?: $log->user->mobile }}</td>
                                    <td>{{ jd($log->created_at) }}</td>
                                    <td>
                                        @if($log->old_model != null || $log->new_model)
                                            <button class="btn btn-sm btn-light" type="button" data-toggle="collapse" data-target="#log{{ $log->id }}" aria-expanded="false">
                                                جزئیات
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @if($log->old_model != null || $log->new_model)
                                    <tr>
                                        <td class="p-0" colspan="4">
                                            <div class="collapse" id="log{{ $log->id }}">
                                                @include('panel.products.logs.detail',['log' => $log])
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        {{ $logs->links() }}
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
