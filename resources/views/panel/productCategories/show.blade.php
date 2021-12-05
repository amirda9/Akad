@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <h1 class="m-0 text-secondary">{{ $category->name }}</h1>
                <a class="btn btn-secondary" href="{{ route('panel.productCategories.index') }}">
                    بازگشت
                </a>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @include('components.messages')
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td>شناسه</td>
                                <th>{{ $category->id }}</th>
                                <td>نام</td>
                                <th>{{ $category->name }}</th>
                            </tr>
                            <tr>
                                <td>آیکن</td>
                                <th>
                                    @if($category->icon)
                                        <a href="{{ getImageSrc($category->icon) }}" target="_blank">
                                            <img width="30" height="30" src="{{ getImageSrc($category->icon,'avatar') }}" />
                                        </a>
                                        <a onclick="return confirm('آیا مطمئن هستید؟')"
                                           href="{{ route('panel.productCategories.deleteIcon',$category) }}"
                                           class="btn btn-sm btn-danger">
                                            حذف
                                        </a>
                                    @else
                                        ---
                                    @endif
                                </th>
                                <td>تصویر</td>
                                <th>
                                    @if($category->image)
                                        <a href="{{ getImageSrc($category->image) }}" target="_blank">
                                            <img width="30" height="30" src="{{ getImageSrc($category->image,'avatar') }}" />
                                        </a>
                                        <a onclick="return confirm('آیا مطمئن هستید؟')"
                                           href="{{ route('panel.productCategories.deleteImage',$category) }}"
                                           class="btn btn-sm btn-danger">
                                            حذف
                                        </a>
                                    @else
                                        ---
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>اسلاگ</td>
                                <th>{{ $category->slug }}</th>
                                <td>ترتیب نمایش</td>
                                <th>{{ $category->order }}</th>
                            </tr>
                            <tr>
                                <td>دسته والد</td>
                                <th class="fa-num">{{ $category->parent ? $category->parent->name : '---' }}</th>
                                <td>تعداد زیرمجموعه</td>
                                <th class="fa-num">{{ $category->children()->count() }}</th>
                            </tr>
                        </table>
                    </div>
                    @if($category->description)
                        <h3>توضیحات</h3>
                        <p>
                            {{ $category->description }}
                        </p>
                    @endif
                    @if($category->meta_title)
                        <h5>عنوان متا</h5>
                        <p>
                        {{ $category->meta_title }}
                        </p>
                    @endif
                    @if($category->meta_description)
                        <h5>توضیحات متا</h5>
                        <p>
                        {{ $category->meta_description }}
                        </p>
                    @endif
                    <a class="btn btn-primary" href="{{ route('panel.productCategories.edit',$category) }}">
                        ویرایش دسته بندی
                    </a>
                    @if($category->app_image)
                        <a class="btn btn-warning" onclick="return confirm('آیا مطمئن هستید؟')"
                           href="{{route('panel.productCategories.deleteAppImage',$category)}}">
                            حذف تصویر
                        </a>
                    @endif
                    <form class="d-inline" method="post" action="{{ route('panel.productCategories.destroy', $category) }}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger"
                            type="submit"
                            onclick="return confirm('آیا مطمئن هستید؟')" title="حذف">
                            حذف
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
