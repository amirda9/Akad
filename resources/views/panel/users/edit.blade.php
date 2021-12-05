@extends('panel.layouts.master')

@section('content')

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h1 class="m-0 text-secondary">ویرایش کاربر</h1>
                    <a class="btn btn-secondary" href="{{ route('panel.users.index') }}">
                        بازگشت
                    </a>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('panel.users.update',$user) }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="name">نام کاربر</label>
                                    <input
                                            type="text"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                            id="name"
                                            name="name"
                                            placeholder="نام کاربر را وارد کنید"
                                            value="{{ old('name') ?: $user->name }}"
                                            required
                                            oninvalid="this.setCustomValidity('نام کاربر را وارد کنید')"
                                            oninput="setCustomValidity('')"
                                    >
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="email">آدرس ایمیل</label>
                                    <input
                                            type="text"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                            id="email"
                                            placeholder="آدرس ایمیل کاربر را وارد کنید"
                                            name="email"
                                            value="{{ old('email') ?: $user->email }}"
                                    >
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="mobile">شماره موبایل</label>
                                    <input
                                            type="text"
                                            class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}"
                                            id="mobile"
                                            placeholder="شماره موبایل کاربر را وارد کنید"
                                            value="{{ old('mobile') ?: $user->mobile }}"
                                            name="mobile"
                                    >
                                    @if ($errors->has('mobile'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('mobile') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="image">تصویر جدید کاربر</label>
                                    <input
                                        type="file"
                                        class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                        id="image"
                                        name="image"
                                    >
                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" {{ $user->is_active ? 'checked' : '' }} name="is_active" class="custom-control-input" id="is_active">
                                        <label class="custom-control-label" for="is_active">حساب کاربری فعال است.</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                                    <a class="btn btn-secondary" href="{{ route('panel.users.index') }}">
                                        بازگشت
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
