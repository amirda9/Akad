@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => $page->title,
        'description' => $page->meta_description ?: ($page->short_description ?: config('settings.meta_description')),
        'url' => $page->getRoute(),
        'image' => getImageSrc($page->image)
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . ($page->meta_title ?: $page->title) }}</title>
@endsection

@section('content')
<div class="container">
    {{ Breadcrumbs::render('pages.show', $page) }}
    @include('components.messages')
    <div class="bg-white position-relative overflow-hidden shadow-sm rounded p-3 p-lg-4">
        @if($page->image)
            <img src="{{ getImageSrc($page->image) }}" alt="{{ $page->title }}" class="w-100 rounded mb-4" />
        @endif
        <h2>{{ $page->title }}</h2>
        <div class="mb-5">{{ $page->short_description }}</div>
        {!! render_content($page->full_description) !!}
    </div>
</div>
@endsection
