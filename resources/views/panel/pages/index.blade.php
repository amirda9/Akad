@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">
    
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="m-0 text-secondary">مدیریت صفحه ها</h1>
                <a class="btn btn-primary" href="{{ route('panel.pages.create') }}">
                    افزودن صفحه جدید
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
                                       class="form-control" value="{{ request('search')}}" placeholder="عنوان مطلب را وارد کنید">
                            </div>
                            <div class="col-12 col-lg-3 form-group">
                                <button type="submit" class="btn btn-success">جستجو</button>
                                <a href="{{ route('panel.pages.index') }}" class="btn btn-secondary">نمایش همه</a>
                            </div>
                        </div>
                    </form>
                    @if($pages->count())
                        <div class="table-responsive">
                            <table class="table table-hover m-0 text-center text-nowrap">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="p-2">#</th>
                                        <th class="p-2">تصویر</th>
                                        <th class="p-2 text-right">عنوان</th>
                                        <th class="p-2">وضعیت</th>
                                        <th class="p-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pages as $page)
                                        <tr>
                                            <td>{{ $page->id }}</td>
                                            <td class="p-1">
                                                @if($page->image)
                                                    <a href="{{ getImageSrc($page->image) }}" target="_blank">
                                                        <img style="width:50px;" src="{{ getImageSrc($page->image,'small') }}" alt="{{ $page->title }}">
                                                    </a>
                                                @else
                                                <div class="bg-gray-400 rounded-circle mx-auto text-white d-flex align-items-center justify-content-center" style="width:38px; height:38px">
                                                    <i class="fad fa-image"></i>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ $page->getRoute() }}" target="_blank">
                                                    {{ $page->title }}
                                                </a>
                                            </td>

                                            <td class="p-2">
                                                @if($page->published)
                                                    <a class="btn btn-success btn-sm" href="{{ route('panel.pages.changePublished',$page) }}">منتشر شده</a>
                                                @else
                                                    <a class="btn btn-danger btn-sm" href="{{ route('panel.pages.changePublished',$page) }}">منتشر نشده</a>
                                                @endif
                                            </td>

                                            <td class="p-2 text-left">
                                                <a class="btn btn-sm btn-primary" href="{{ route('panel.pages.edit',$page) }}" title="ویرایش">
                                                    ویرایش
                                                </a>
                                                <form class="d-inline" method="post" action="{{ route('panel.pages.destroy',$page) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')" type="submit">حذف</button>
                                                </form>
                                                @if($page->image)
                                                    <a class="btn btn-sm btn-warning"
                                                        onclick="return confirm('آیا مطمئن هستید؟')"
                                                        href="{{ route('panel.pages.deleteImage',$page) }}" title="حذف تصویر">
                                                        حذف تصویر
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $pages->links() }}
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
