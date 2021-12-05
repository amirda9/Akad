@extends('layouts.app')
@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'اعلان ها',
        'description' => getOption('site_information.description',config('settings.description')),
        'image' => getImageSrc(getOption('site_information.logo'))
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'اعلان ها' }}</title>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-3 mb-lg-0">
                @include('user.sidebar')
            </div>
            <div class="col-md-9">
                @include('components.messages')
                <div class="bg-white p-4 rounded shadow-sm text-secondary">
                    <div class="panel-title d-flex flex-wrap flex-row justify-content-between">
                        <h3 class="m-0">همه پیام ها</h3>
                        <div>
                            <a href="{{ route('user.notifications.deleteRead') }}" class="more-button text-primary">حذف خوانده شده ها</a>
                            <a href="{{ route('user.notifications.readAll') }}" class="more-button text-primary mr-3">خواندن همه</a>
                        </div>
                    </div>
                    <hr/>
                    @if($notifications->count())
                        @foreach( $notifications as $notification)
                            @include('user.notifications.card',[
                                'notification' => $notification
                            ])
                        @endforeach
                        <div class="overflow-auto">
                            {{$notifications->links()}}
                        </div>
                    @else
                        @include('components.empty')
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
