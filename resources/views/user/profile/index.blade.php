@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'حساب کاربری',
        'description' => getOption('site_information.description',config('settings.description')),
        'image' => getImageSrc(getOption('site_information.logo'))
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'حساب کاربری' }}</title>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-3 mb-lg-0">
                @include('user.sidebar')
            </div>
            <div class="col-lg-9">
                @include('components.messages')
                <div class="bg-white p-4 shadow-sm rounded mb-4">
                    <div class="body text-secondary">
                        <h3>اطلاعات حساب کاربری</h3>
                        <hr/>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <p>
                                    <strong>نام و نام خانوادگی:</strong>
                                    <span>{{$user->name}}</span>
                                </p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>
                                    <strong>شماره موبایل:</strong>
                                    <span>{{$user->mobile}}</span>
                                </p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>
                                    <strong>ایمیل:</strong>
                                    <span>{{ $user->email ?: '---' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <a id="btnEditProfile" href="{{route('user.profile.edit')}}" class="btn btn-primary">ویرایش</a>
                </div>
            </div>
        </div>
    </div>
@endsection
