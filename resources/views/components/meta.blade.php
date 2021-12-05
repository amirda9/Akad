<meta content='summary' name='twitter:card'>
@if($title ?? null)
    <meta content='{{ $title }}' name='twitter:title'>
    <meta content='{{ $title }}' property='og:title'>
@endif
@if($description ?? null)
    <meta content='{{ $description }}' name='description'>
    <meta content='{{ $description }}' name='twitter:description'>
    <meta content='{{ $description }}' property='og:description'>
@endif
@if($url ?? null)
    <meta content='{{ $url }}' name='twitter:url'>
    <meta content='{{ $url }}' property='og:url'>
@endif
@if($image ?? null)
    <meta content='{{ $image }}' property='og:image'>
@endif
<meta content='{{ getOption('site_information.website_name',config('settings.website_name')) }}' property='og:site_name'>