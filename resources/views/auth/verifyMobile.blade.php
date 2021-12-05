@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'تایید شماره موبایل',
        'description' => getOption('site_information.description',config('settings.description')),
        'image' => getImageSrc(getOption('site_information.logo'))
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'تایید شماره موبایل' }}</title>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('components.auth.verifyMobile')
        </div>
    </div>
</div>
@endsection
