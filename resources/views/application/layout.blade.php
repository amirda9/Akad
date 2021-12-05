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
    @yield('head')
    @stack('head')
</head>
<body>
    <div id="app" class="min-vh-100 d-flex flex-column">
        <main class="py-lg-4 py-3 flex-grow-1">
            @yield('content')
        </main>
    </div>
</body>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
@stack('scripts')
</html>
