@extends('application.layout')

@section('meta')
    @include('components.meta',[
        'title' => 'نتیجه درگاه پرداخت',
        'description' => config('settings.meta_description'),
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'نتیجه درگاه پرداخت' }}</title>
@endsection

@section('content')
    <div class="container">
        @if($message)
            @if($type == 'danger')
                <div style="height: 500px; display: flex; align-items: center; justify-content: center;">
                    <h2 class="text-danger text-center">{{ $message }}</h2>
                </div>
            @endif
            @if($type == 'success')
                <div style="height: 500px; display: flex; align-items: center; justify-content: center;">
                    <h2 class="text-success text-center">{{ $message }}</h2>
                </div>
            @endif
        @endif
    </div>
@endsection

