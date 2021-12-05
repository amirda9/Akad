@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">
    
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="m-0 text-secondary">دسته بندی محصولات</h1>
                <a class="btn btn-primary" href="{{ route('panel.posts.categories.create') }}">افزودن دسته بندی</a>
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
                                <input class="form-control" value="{{ request('search') }}"
                                       name="search" type="search" placeholder="نام دسته بندی را وارد کنید">
                            </div>
                            <div class="col-12 col-lg-3 form-group">
                                <button type="submit" class="btn btn-success">
                                    جستجو
                                </button>
                            </div>
                        </div>
                    </form>
                    @if($categories->count())
                        <div class="table-responsive">
                            <table class="table fa-num table-hover m-0 text-center text-nowrap">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="p-2">#</th>
                                        <th class="text-right p-2">نام دسته بندی</th>
                                        <th class="p-2">ترتیب نمایش</th>
                                        <th class="p-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{$category->id}}</td>
                                            <td class="text-right">
                                                {{-- <a href="{{ $category->getRoute() }}" target="_blank"> --}}
                                                    {{str_repeat('—',$category->level)}}
                                                    @if($category->app_image)
                                                        <img src="{{ getImageSrc($category->app_image,'avatar') }}"
                                                             alt="{{ $category->name }}" width="25" class="rounded-circle">
                                                    @endif
                                                    {{$category->name}}
                                                {{-- </a> --}}
                                            </td>
                                            <td>{{$category->order}}</td>
                                            <td class="p-2 text-right">
                                                <a class="btn btn-sm btn-light" href="{{ route('panel.posts.categories.show',$category) }}">
                                                    مشاهده
                                                </a>
                                                <a class="btn btn-sm btn-primary" href="{{ route('panel.posts.categories.edit',$category) }}">
                                                    ویرایش
                                                </a>
                                                <form class="d-inline" method="post" action="{{ route('panel.posts.categories.destroy', $category) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm btn-danger"
                                                       onclick="return confirm('آیا مطمئن هستید؟')"
                                                            type="submit"
                                                    >
                                                        حذف
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $categories->links() }}
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
