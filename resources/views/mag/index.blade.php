@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) . ' | ' . 'ملجه',
        'description' => getOption('site_information.description',config('settings.meta_description')),
    ])
@endsection
@section('title')
     <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'مجله' }}</title>
@endsection
@section('content')
    <div class="container py-3">
        @include('components.messages')
        @foreach($article_categories as $article_category)
            <div class="mb-5">
                @include('components.mag.category.slider',['article_category' => $article_category])
            </div>
        @endforeach
    </div>
@endsection


@section('scripts')
    <script>
        var mySwiper = new Swiper('.article-category-swiper', {
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                nextEl: '.article-category-swiper-next',
                prevEl: '.article-category-swiper-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 15,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                },
            }
        })
    </script>
@endsection
