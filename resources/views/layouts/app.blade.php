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
    <script>
        !function (t, e, n) {
            t.yektanetAnalyticsObject = n, t[n] = t[n] || function () {
                t[n].q.push(arguments)
            }, t[n].q = t[n].q || [];
            var a = new Date, r = a.getFullYear().toString() + "0" + a.getMonth() + "0" + a.getDate() + "0" + a.getHours(),
                c = e.getElementsByTagName("script")[0], s = e.createElement("script");
            s.id = "ua-script-mxWOT9Mc"; s.dataset.analyticsobject = n; s.async = 1; s.type = "text/javascript";
            s.src = "https://cdn.yektanet.com/rg_woebegone/scripts_v3/mxWOT9Mc/rg.complete.js?v=" + r, c.parentNode.insertBefore(s, c)
        }(window, document, "yektanet");
    </script>
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
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-164510768-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-164510768-1');
</script>
</html>
