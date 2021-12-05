@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="m-0 text-secondary">مدیریت مقالات</h1>
                <a class="btn btn-primary" href="{{ route('panel.posts.articles.create') }}">
                    افزودن مقاله جدید
                </a>
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
                            <div class="col-12 col-lg-3 form-group">
                                <input type="text" name="search" id="search"
                                       class="form-control" value="{{ request('search')}}" placeholder="شناسه، عنوان و یا دسته بندی مطلب">
                            </div>
                            <div class="col-6 col-lg-2 form-group">
                                <select name="order" class="form-control">
                                    <option value="date" {{ request('order') == 'date' ? 'selected' : '' }}>تاریخ</option>
                                    <option value="view" {{ request('order') == 'view' ? 'selected' : '' }}>بازدید</option>
                                    <option value="comment" {{ request('order') == 'comment' ? 'selected' : '' }}>نظرات</option>
                                    <option value="rate" {{ request('order') == 'rate' ? 'selected' : '' }}>امتیاز</option>
                                </select>
                            </div>
                            <div class="col-6 col-lg-2 form-group">
                                <select name="dir" class="form-control">
                                    <option value="desc" {{ request('dir') == 'desc' ? 'selected' : '' }}>نزولی</option>
                                    <option value="asc" {{ request('dir') == 'asc' ? 'selected' : '' }}>صعودی</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-3 form-group">
                                <button type="submit" class="btn btn-success">جستجو</button>
                                <a href="{{ route('panel.posts.articles.index') }}" class="btn btn-secondary">نمایش همه</a>
                            </div>
                        </div>
                    </form>
                    @if($articles->count())
                        <div class="table-responsive">
                            <table class="table table-hover m-0 text-center text-nowrap">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="p-2">#</th>
                                        <th class="p-2">تصویر</th>
                                        <th class="p-2 text-right">عنوان</th>
                                        <th class="p-2 text-right">دسته ها</th>
                                        <th class="p-2 text-center"><i class="fas fa-eye"></i></th>
                                        <th class="p-2 text-center"><i class="fas fa-comments"></i></th>
                                        <th class="p-2 text-center"><i class="fas fa-star"></i></th>
                                        <th class="p-2 text-center">تاریخ</th>
                                        <th class="p-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($articles as $article)
                                        <tr>
                                            <td>{{ $article->id }}</td>
                                            <td class="p-1">
                                                @if($article->image)
                                                    <a href="{{ getImageSrc($article->image) }}" target="_blank">
                                                        <img style="width:50px;" src="{{ getImageSrc($article->image,'small') }}" alt="{{ $article->title }}">
                                                    </a>
                                                @else
                                                    <div class="bg-gray-400 rounded-circle mx-auto text-white d-flex align-items-center justify-content-center" style="width:38px; height:38px">
                                                        <i class="fad fa-image"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ $article->getRoute() }}" target="_blank">{{ $article->title }}</a>
                                            </td>
                                            <td class="text-right">
                                                @foreach($article->categories as $category)
                                                    <a class="badge badge-light" href="{{ $category->getRoute() }}" target="_blank">{{ $category->name }}</a>
                                                @endforeach
                                            </td>
                                            <td class="text-center fa-num">{{ $article->views }}</td>
                                            <td class="text-center fa-num">{{ $article->comments_count }}</td>
                                            <td class="text-center fa-num">{{ $article->rate }}</td>
                                            <td class="text-center fa-num">{{ jd($article->created_at) }}</td>
                                            <td class="p-2 text-left">
                                                <a class="btn btn-sm btn-light" href="{{ route('panel.posts.articles.show',$article) }}" title="ویرایش">
                                                    مشاهده
                                                </a>
                                                <a class="btn btn-sm btn-primary" href="{{ route('panel.posts.articles.edit',$article) }}" title="ویرایش">
                                                    ویرایش
                                                </a>
                                                <form class="d-inline" method="post" action="{{ route('panel.posts.articles.destroy',$article) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')" type="submit">حذف</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $articles->links() }}
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
