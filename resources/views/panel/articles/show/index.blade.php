@extends('panel.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1>مشاهده مقاله</h1>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                @include('components.messages')
                @include('panel.articles.show.tab')
                <div class="card card-body">
                    <div class="row">
                        @if($article->image)
                            <div class="col-12 col-lg-5">
                                <img src="{{ getImageSrc($article->image) }}" class="img-fluid" />
                            </div>
                        @endif
                        <div class="col-12 {{ $article->image ? 'col-lg-7' : '' }}">
                            <p>
                                <strong>عنوان:</strong>
                                {{ $article->title }}
                            </p>
                            <p>
                                <strong>دسته ها:</strong>
                                @foreach($article->categories as $category)
                                    @if(!$loop->first)
                                        <span class="mx-2">|</span>
                                    @endif
                                    <span>{{ $category->name }}</span>
                                @endforeach
                            </p>
                            <p>
                                <strong>توضیحات کوتاه:</strong>
                                {{ $article->short_description }}
                            </p>
                        </div>
                        @if($article->full_description)
                            <div class="col-12">
                                <hr/>
                                <h5>توضیحات کامل:</h5>
                                {!! $article->full_description !!}
                            </div>
                        @endif
                    </div>
                </div>
                <a href="{{ route('panel.posts.articles.edit',$article) }}" class="btn btn-primary">ویرایش</a>
                <a href="{{ route('panel.posts.articles.index') }}" class="btn btn-secondary">بازگشت</a>
            </div>
        </div>
    </div>
@endsection
