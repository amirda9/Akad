@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'پیشخوان',
        'description' => getOption('site_information.description',config('settings.description')),
        'image' => getImageSrc(getOption('site_information.logo'))
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'پیشخوان' }}</title>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-3 mb-lg-0">
                @include('user.sidebar')
            </div>
            <div class="col-lg-9">
                @if(!auth()->user()->hasVerifiedMobile())
                    <div class="bg-dark-right-gradient-purple p-4 text-white rounded shadow-sm shadow-hover mb-3">
                        <a href="{{ route('mobile.notice') }}" class="d-flex text-decoration-none text-white flex-row justify-content-between align-items-center">
                            <h4 class="m-0">فعال سازی شماره موبایل</h4>
                            <i class="fad fa-chevron-left fa-2x"></i>
                        </a>
                    </div>
                @endif
                @if(!auth()->user()->hasVerifiedEmail())
                    <div class="bg-dark-right-gradient-primary p-4 text-white rounded shadow-sm shadow-hover mb-3">
                        <a href="{{ route('verification.notice') }}" class="d-flex text-decoration-none text-white flex-row justify-content-between align-items-center">
                            <h4 class="m-0">فعال سازی آدرس ایمیل</h4>
                            <i class="fad fa-chevron-left fa-2x"></i>
                        </a>
                    </div>
                @endif

                <div class="bg-white p-4 rounded shadow-sm">
                    <div class="panel-title d-flex flex-row justify-content-between">
                        <h4 class="text-secondary">پیام های خوانده نشده</h4>
                        <div>
                            <a href="{{ route('user.notifications') }}" class="more-button text-primary">همه پیام ها</a>
                            <a href="{{ route('user.notifications.readAll') }}" class="more-button text-primary mr-3">خواندن همه</a>
                        </div>
                    </div>
                    <hr/>
                    @if($unread_notifications->count())
                        @foreach( $unread_notifications as $unread_notification)
                            @include('user.notifications.card',[
                                'notification' => $unread_notification
                            ])
                        @endforeach
                        <div class="overflow-auto">
                            {{ $unread_notifications->links() }}
                        </div>
                    @else
                        @include('components.empty')
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.btn-remove-notification').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                context: $(this)
            }).done(function () {
                $(this).closest('.alert').slideUp(200);
            });
        });
        $('.btn-mark-as-read-notification').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                context: $(this)
            }).done(function () {
                $(this).closest('.alert').slideUp(200);
            });
        })
    </script>
@endsection
