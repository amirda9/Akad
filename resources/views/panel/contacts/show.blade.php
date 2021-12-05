@extends('panel.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <h1 class="text-secondary m-0">مشاهده پیام</h1>
                    <a class="btn btn-secondary" href="{{ route('panel.contacts.index') }}">
                        بازگشت
                    </a>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        @include('components.messages')
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <strong>نام و نام خانوادگی:</strong>
                                <span>{{ $contact->name }}</span>
                            </div>
                            <div class="col-12 col-lg-4">
                                <strong>آدرس ایمیل:</strong>
                                <span>{{ $contact->email ?: '---' }}</span>
                            </div>
                            <div class="col-12 col-lg-4">
                                <strong>شماره موبایل:</strong>
                                <span>{{ $contact->mobile ?: '---' }}</span>
                            </div>
                            <div class="col-12">
                                <hr/>
                                <h4>متن پیام :</h4>
                                <div class="p-4 border mb-4">
                                    {{ $contact->message }}
                                </div>
                            </div>
                            <div class="col-12">
                                <a class="btn btn-secondary" href="{{ route('panel.contacts.index') }}">
                                    بازگشت
                                </a>
                                <form class="d-inline" method="post" action="{{ route('panel.contacts.destroy', $contact) }}">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('آیا مطمئن هستید؟')">
                                        حذف پیام
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
