@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'ویرایش حساب کاربری',
        'description' => getOption('site_information.description',config('settings.description')),
        'image' => getImageSrc(getOption('site_information.logo'))
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'ویرایش حساب کاربری' }}</title>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-3 mb-lg-0">
                @include('user.sidebar')
            </div>
            <div class="col-lg-9">
                @include('components.messages')
                <div class="bg-white p-4 rounded shadow-sm text-secondary">
                    <h3>ویرایش حساب کاربری</h3>
                    <hr/>
                    <form id="editProfileForm" class="form-horizontal" method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                        <div class="body">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="name">نام و نام خانوادگی</label>
                                    <input id="name" type="text" class="form-control" autocomplete="false"
                                           name="name" value="{{ old('name') ?: $user->name }}" required autofocus
                                           oninvalid="this.setCustomValidity('نام کاربر را وارد کنید')"
                                           oninput="setCustomValidity('')"/>
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="mobile">شماره موبایل</label>
                                    <input id="mobile" readonly type="text" class="form-control" autocomplete="false"
                                           name="mobile" value="{{ old('mobile') ?: $user->mobile }}"/>
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="email">ایمیل</label>
                                    <input id="email" type="text" class="form-control" autocomplete="false"
                                           name="email" value="{{ old('email') ?: $user->email }}"/>
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="image">تصویر</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <hr/>
                            <div class="row">
                                <div class="col-md-12">
                                    <button id="btnFormSubmit" type="submit" class="btn btn-success">ذخیره</button>
                                    <a id="btnBackToDashboard" class="btn btn-primary" href="{{ route('user.profile.index') }}">بازگشت</a>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection