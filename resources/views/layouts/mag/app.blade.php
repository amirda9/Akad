<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ config('app.dir')[app()->getLocale()] }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ getImageSrc(getOption('site_information.favicon')) }}">
    @yield('meta')
    @yield('title')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/persianfonts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/swiper-bundle.min.css') }}" rel="stylesheet">
    @yield('head')
    @stack('head')
</head>
<body>
    <div id="app" class="min-vh-100 d-flex flex-column">
        @include('layouts.header')
        @yield('top')
        <main class="flex-grow-1 py-3">
            @yield('content')
        </main>
        {!! render_widget_position('top_footer') !!}
        @include('layouts.footer')
    </div>
    @include('components.drawer')
</body>
<!-- Scripts -->
<script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $('.cart-dropdown-body').click(function(e) {
        e.stopPropagation();
    });
    $('body').on('click',function (e) {
        var container = $("#cardDropdownContainer");
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            $('#cardDropdown').removeClass('show');
        }
    })
</script>
@yield('bottom')
@stack('bottom')
@yield('scripts')
@stack('scripts')
</html>
