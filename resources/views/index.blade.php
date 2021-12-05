@extends('layouts.app')
@section('meta')
    @include('components.meta',[
        'title' => config('settings.website_name'),
        'description' => config('settings.meta_description'),
        'url' => route('index')
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.main_title',config('settings.website_name')) }}</title>
@endsection
@section('top')
    @if($slides->count())
        <div class="container-fluid py-3">
            <div class="row">
                <div class="col-6 col-md-6 d-none d-lg-block col-lg-3">
                    {!! render_widget_position('right_main_slider') !!}
                </div>
                <div class="col-12 col-md-6 col-lg-9">
                    @include('components.mainSlider',[
                        'slides' => $slides
                    ])
                </div>
            </div>
        </div>
    @endif
    @include('components.services')
    @include('components.messages')
@endsection
@section('content')
    {!! render_widget_position('bottom_main_slider') !!}
    {!! render_widget_position('top_featured_products') !!}
    @widget('horizontal_slider',[
        'type' => 'featured_products',
        'colored' => true,
        'link' => route('products.all',['featured' => 'on'])
    ])
    {!! render_widget_position('bottom_featured_products') !!}
    {!! render_widget_position('top_latest_products') !!}
    @widget('horizontal_slider',[
        'type' => 'latest_products',
        'link' => route('products.all',['orderBy' => 'latest'])
    ])
    {!! render_widget_position('bottom_latest_products') !!}
@endsection
