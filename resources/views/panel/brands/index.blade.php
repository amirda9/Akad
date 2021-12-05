@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="m-0 text-secondary">مدیریت برندها</h1>
                <a class="btn btn-primary" href="{{ route('panel.brands.create') }}">
                    افزودن برند جدید
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
                                       class="form-control" value="{{ request('search')}}" placeholder="عنوان برند را وارد کنید">
                            </div>
                            <div class="col-12 col-lg-3 form-group">
                                <button type="submit" class="btn btn-success">جستجو</button>
                                <a href="{{ route('panel.brands.index') }}" class="btn btn-secondary">نمایش همه</a>
                            </div>
                        </div>
                    </form>
                    @if($brands->count())
                        <div class="table-responsive">
                            <table class="table table-hover m-0 text-center text-nowrap">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="p-2">#</th>
                                        <th class="p-2">تصویر</th>
                                        <th class="p-2 text-right">نام</th>
                                        <th class="p-2 text-right">نام انگلیسی</th>
                                        <th class="p-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $brand)
                                        <tr>
                                            <td>{{ $brand->id }}</td>
                                            <td class="p-1">
                                                @if($brand->image)
                                                    <a href="{{ getImageSrc($brand->image) }}" target="_blank">
                                                        <img style="width:50px;" src="{{ getImageSrc($brand->image,'avatar') }}" alt="{{ $brand->name }}">
                                                    </a>
                                                @else
                                                <div class="bg-gray-400 rounded-circle mx-auto text-white d-flex align-items-center justify-content-center" style="width:38px; height:38px">
                                                    <i class="fad fa-image"></i>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ $brand->getRoute() }}" target="_blank">
                                                    {{ $brand->name }}
                                                </a>
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ $brand->getRoute() }}" target="_blank">
                                                    {{ $brand->en_name }}
                                                </a>
                                            </td>

                                            <td class="p-2 text-left">
                                                <a class="btn btn-sm btn-primary" href="{{ route('panel.brands.edit',$brand) }}" title="ویرایش">
                                                    ویرایش
                                                </a>
                                                <form class="d-inline" method="post" action="{{ route('panel.brands.destroy',$brand) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')" type="submit">حذف</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $brands->links() }}
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
