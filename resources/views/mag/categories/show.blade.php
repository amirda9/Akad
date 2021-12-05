@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) . ' | ' . $category->name,
        'description' => $category->meta_description ?: ($category->description ?: getOption('site_information.description',config('settings.meta_description'))),
        'url' => $category->getRoute()
    ])
@endsection
@section('title')
     <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . ($category->meta_title ?: $category->name) }}</title>
@endsection
@section('content')
    <div class="container py-3">
        {{ Breadcrumbs::render('article_category', $category) }}
        @include('components.messages')
        <div class="row">
            <div class="col-12">
                <div class="mb-4">
                    @if($articles->count())
                        <div class="products-container p-0">
                            <div class="row">
                                @foreach($articles as $article)
                                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 d-flex">
                                        @include('components.mag.article.postCard',[
                                            'article' => $article
                                        ])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        @include('components.empty')
                    @endif
                </div>
                <div class="overflow-auto">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

