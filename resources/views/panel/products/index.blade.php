@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="text-secondary m-0">مدیریت محصولات</h1>
                <a class="btn btn-primary" href="{{ route('panel.products.create') }}">
                    افزودن محصول جدید
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
                                <input class="form-control" type="text" name="title" id="title" placeholder="نام محصول را وارد کنید">
                            </div>
                            <div class="col-12 col-lg-3 form-group">
                                <select class="form-control selectpicker" id="category" data-live-search="true"
                                        name="category" title="دسته بندی محصول را انتخاب کنید">
                                    <option value="">نمایش همه</option>
                                    @include('panel.products.childrenOptions',[
                                        'categories' => $categories,
                                        'selected_categories' => [request('category')]
                                    ])
                                </select>
                            </div>
                            <div class="col-12 col-lg-3 form-group">
                                <select class="form-control selectpicker" id="status"
                                        name="status" title="وضعیت محصول را انتخاب کنید">
                                    <option value="">نمایش همه</option>
                                    <option {{ request('status') == 'published' ? 'selected' : '' }} value="published">منتشر شده</option>
                                    <option {{ request('status') == 'unpublished' ? 'selected' : '' }} value="unpublished">منتشر نشده</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-3 form-group">
                                <select class="form-control selectpicker" id="featured"
                                        name="featured" title="محصول ویژه">
                                    <option value="">نمایش همه</option>
                                    <option {{ request('featured') == 'featured' ? 'selected' : '' }} value="featured">فعال</option>
                                    <option {{ request('featured') == 'not_featured' ? 'selected' : '' }} value="not_featured">غیرفعال</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-3 form-group">
                                <select class="form-control selectpicker" id="order"
                                        name="order" title="مرتب سازی">
                                    <option {{ request('order') == 'date' ? 'selected' : '' }} value="date">تاریخ</option>
                                    <option {{ request('order') == 'price' ? 'selected' : '' }} value="price">قیمت</option>
                                    <option {{ request('order') == 'views' ? 'selected' : '' }} value="views">بازدید</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-3 form-group">
                                <select class="form-control selectpicker" id="direction"
                                        name="direction" title="جهت ترتیب">
                                    <option {{ request('direction') == 'asc' ? 'selected' : '' }} value="asc">صعودی</option>
                                    <option {{ request('direction') == 'desc' ? 'selected' : '' }} value="desc">نزولی</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-3 form-group">
                                <button type="submit" class="btn btn-success">جستجو</button>
                                <a href="{{ route('panel.products.index') }}" class="btn btn-secondary">
                                    نمایش همه
                                </a>
                            </div>
                        </div>
                    </form>
                    @if($products->count())
                        <div class="table-responsive">
                            <table class="table table-hover m-0 text-center text-nowrap">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="p-2">#</th>
                                        <th class="p-2">تصویر</th>
                                        <th class="p-2 text-right">عنوان</th>
                                        <th class="p-2">دسته بندی</th>
                                        <th class="p-2">قیمت</th>
                                        <th class="p-2">وضعیت</th>
                                        <th class="p-2">ویژه</th>
                                        <th class="p-2">بازدید</th>
                                        <th class="p-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td class="p-1">
                                                <a href="{{ getImageSrc($product->getImage()) }}" target="_blank">
                                                    <img style="width:50px;" src="{{ getImageSrc($product->getImage(),'small') }}" alt="{{ $product->title }}">
                                                </a>
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ $product->getRoute() }}" title="{{ $product->title }}" target="_blank">
                                                    {{ str_limit($product->title,60) }}
                                                </a>
                                            </td>
                                            <td>
                                                @foreach($product->categories as $product_category)
                                                    <a href="{{ route('panel.productCategories.show',$product_category) }}">
                                                        {{ $product_category->name }}
                                                    </a>
                                                @endforeach
                                            </td>
                                            <td class="fa-num">
                                                @if($product->regular_price)
                                                    {{ number_format($product->regular_price) }}
                                                @else
                                                    ---
                                                @endif
                                            </td>

                                            <td class="p-2">
                                                @if($product->published)
                                                    <a class="badge badge-success" href="{{ route('panel.products.changePublished',$product) }}">منتشر شده</a>
                                                @else
                                                    <a class="badge badge-danger" href="{{ route('panel.products.changePublished',$product) }}">منتشر نشده</a>
                                                @endif
                                            </td>

                                            <td class="p-2">
                                                @if($product->is_featured)
                                                    <a class="badge badge-success" href="{{ route('panel.products.changeFeatured',$product) }}">فعال</a>
                                                @else
                                                    <a class="badge badge-danger" href="{{ route('panel.products.changeFeatured',$product) }}">غیرفعال</a>
                                                @endif
                                            </td>

                                            <td class="p-2 fa-num">
                                                {{ number_format($product->views) }}
                                            </td>

                                            <td class="p-2 text-left">
                                                <a class="btn btn-sm btn-light" target="_blank" href="{{ route('panel.products.show',$product) }}" title="پیش نمایش">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm btn-primary" href="{{ route('panel.products.edit',$product) }}" title="ویرایش">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <form class="d-inline" method="post" action="{{ route('panel.products.destroy',$product) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')" type="submit">
                                                        <i class="far fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $products->links() }}
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
