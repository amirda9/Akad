@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="m-0 text-secondary">مدیریت نظرات</h1>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @include('components.messages')
            <div class="card">
                <div class="card-body">
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
                                <a href="{{ route('panel.comments.index') }}" class="btn btn-secondary">
                                    مشاهده همه
                                </a>
                            </div>
                        </div>
                    </form>
                    <hr/>
                    @if($comments->count())
                        @foreach($comments as $comment)
                            <div class="mb-3">
                                @include('components.panel.comments.comment',['comment' => $comment])
                            </div>
                        @endforeach
                        <div class="overflow-auto">
                            {{ $comments->links() }}
                        </div>
                    @else
                        @include('components.empty')
                    @endif
                </div>
            </div>
        </div>
    </div>

    </div>

@endsection
