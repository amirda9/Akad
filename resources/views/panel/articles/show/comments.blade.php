@extends('panel.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1>مشاهده نظرات مقاله</h1>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                @include('components.messages')
                @include('panel.articles.show.tab')
                <div class="card card-body">
                    <h5>
                        مشاهده نظرات:
                        <a href="{{ $article->getRoute() }}" target="_blank">{{ $article->title }}</a>
                    </h5>
                    <hr/>
                    <form method="get">
                        <div class="row">
                            <div class="col-12 col-lg-3">
                                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="نام، ایمیل، موبایل کاربر">
                            </div>
                            <div class="col-12 col-lg-3">
                                <select name="type" class="form-control">
                                    <option value="">نمایش همه</option>
                                    <option {{ request('type') == 'published' ? 'selected' : '' }} value="published">منتشر شده</option>
                                    <option {{ request('type') == 'not_published' ? 'selected' : '' }} value="not_published">منتشر نشده</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-3">
                                <button type="submit" class="btn btn-success">جستجو</button>
                                <a href="{{ route('panel.posts.articles.comments.index',$article) }}" class="btn btn-secondary">
                                    مشاهده همه
                                </a>
                            </div>
                        </div>
                    </form>
                    <hr/>
                    @if($comments->count())
                        @foreach($comments as $comment)
                            @include('components.panel.comments.article',['comment' => $comment])
                        @endforeach
                        {{ $comments->links() }}
                    @else
                        @include('components.empty')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
