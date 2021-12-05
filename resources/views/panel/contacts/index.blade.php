@extends('panel.layouts.master')

@section('head')
    <link href="{{ asset('css/persian-datepicker.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <h1 class="text-secondary m-0">مدیریت پیام ها</h1>
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
                                           placeholder="ایمیل، شماره و یا نام کاربر">
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
                                    <select id="status" name="status" class="form-control selectpicker" title="انتخاب وضعیت پیام">
                                        <option>نمایش همه</option>
                                        <option value="seen" {{ request('status') == 'seen' ? 'selected' : '' }}>مشاهده شده</option>
                                        <option value="not_seen" {{ request('status') == 'not_seen' ? 'selected' : '' }}>مشاهده نشده</option>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-3 form-group">
                                    <button class="btn btn-success" type="submit">جستجو</button>
                                    <a class="btn btn-secondary" href="{{ route('panel.contacts.index') }}">
                                        مشاهده همه
                                    </a>
                                </div>
                            </div>
                        </form>
                        @if($contacts->count())
                            <div class="table-responsive">
                                <table class="table table-sm table-hover table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-right">نام کاربر</th>
                                        <th class="text-center">ایمیل</th>
                                        <th class="text-center">شماره</th>
                                        <th class="text-center">وضعیت</th>
                                        <th class="text-center">تاریخ</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($contacts as $key => $contact)
                                        <tr>
                                            <td class="fa-num">
                                                {{ $contacts->firstItem() + $key }}
                                            </td>
                                            <td class="text-right">
                                                {{ $contact->name }}
                                            </td>
                                            <td>
                                                {{ $contact->email ?: '---' }}
                                            </td>
                                            <td>
                                                {{ $contact->mobile ?: '---' }}
                                            </td>
                                            <td>
                                                @if($contact->seen)
                                                    <span class="badge badge-success">مشاهده شده</span>
                                                @else
                                                    <span class="badge badge-danger">مشاهده نشده</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ jd($contact->created_at) }}
                                            </td>
                                            <td>
                                                <a href="{{route('panel.contacts.show',$contact)}}" class="btn btn-sm btn-success">
                                                    مشاهده
                                                </a>
                                                <form class="d-inline" method="post" action="{{ route('panel.contacts.destroy',$contact) }}">
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
                                {{ $contacts->links() }}
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