@extends('panel.layouts.master')



@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <h1 class="m-0 text-dark">افزودن دسته بندی</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('panel.productCategories.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 text-sm-left col-form-label text-nowrap">نام دسته بندی</label>
                            <div class="col-sm-5">
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    id="name"
                                    name="name"
                                    required
                                    value="{{ old('name') }}"
                                    oninvalid="this.setCustomValidity('نام دسته بندی را وارد کنید')"
                                    oninput="setCustomValidity('')"
                                >
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="slug" class="col-sm-4 text-sm-left col-form-label text-nowrap">اسلاگ</label>
                            <div class="col-sm-5">
                                <input
                                    type="text"
                                    class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}"
                                    id="slug"
                                    name="slug"
                                    value="{{ old('slug') }}"
                                >
                                @if ($errors->has('slug'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="parent" class="col-sm-4 text-sm-left col-form-label text-nowrap">دسته بندی والد</label>
                            <div class="col-sm-5">
                                <select name="parent" data-placeholder='انتخاب دسته بندی والد' class="form-control selectpicker {{ $errors->has('parent') ? 'is-invalid' : '' }}" id="parent">
                                    <option></option>
                                    @include('panel.productCategories.childrenOptions',[
                                        'categories' => $categories,
                                        'selected_categories' => [old('parent')]
                                    ])
                                </select>
                                @if ($errors->has('parent'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('parent') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-sm-4 text-sm-left col-form-label text-nowrap">تصویر</label>
                            <div class="col-sm-5">
                                <input type="file" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                       name="image" id="image"/>
                                @if ($errors->has('image'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="icon" class="col-sm-4 text-sm-left col-form-label text-nowrap">آیکن</label>
                            <div class="col-sm-5">
                                <input type="file" class="form-control {{ $errors->has('icon') ? 'is-invalid' : '' }}"
                                       name="icon" id="icon"/>
                                @if ($errors->has('icon'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('icon') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="order" class="col-sm-4 text-sm-left col-form-label text-nowrap">ترتیب نمایش</label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" name="order" id="order" value="{{ old('order')?: 0 }}"/>
                                @if ($errors->has('order'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('order') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-4 text-sm-left col-form-label text-nowrap">توضیحات</label>
                            <div class="col-sm-5">
                                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description"
                                    id="description">{{ old('description') }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            <label for="meta_title" class="col-sm-4 text-sm-left col-form-label text-nowrap">عنوان متا</label>
                            <div class="col-sm-5">
                                <input type="text"
                                        class="form-control {{ $errors->has('meta_title') ? 'is-invalid' : '' }}"
                                        id="meta_title"
                                        name="meta_title"
                                        value="{{ old('meta_title') }}"
                                >
                                @if ($errors->has('meta_title'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('meta_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="meta_description" class="col-sm-4 text-sm-left col-form-label text-nowrap">توضیحات متا</label>
                            <div class="col-sm-5">
                                <textarea class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}" name="meta_description"
                                          id="meta_description">{{ old('meta_description') }}</textarea>
                                @if ($errors->has('meta_description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('meta_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5 offset-sm-4">
                                <button type="submit" class="btn btn-primary">افزودن دسته بندی</button>
                                <a class="btn btn-secondary" href="{{ route('panel.productCategories.index') }}">بازگشت</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
