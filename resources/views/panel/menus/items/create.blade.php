@extends('panel.layouts.master')

@section('content')

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <h1>افزودن آیتم جدید</h1>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('panel.menuItems.store', $menu) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="title" class="col-sm-4 text-sm-left col-form-label text-nowrap">عنوان آیتم</label>
                                <div class="col-sm-5">
                                    <input
                                        type="text"
                                        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                        id="title"
                                        placeholder="عنوان آیتم را وارد کنید"
                                        name="title"
                                        value="{{ old('title') }}"
                                    >
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="link" class="col-sm-4 text-sm-left col-form-label text-nowrap">لینک آیتم</label>
                                <div class="col-sm-5">
                                    <input
                                        type="text"
                                        class="form-control text-left dir-ltr {{ $errors->has('link') ? 'is-invalid' : '' }}"
                                        id="link"
                                        placeholder="http://example.com"
                                        name="link"
                                        value="{{ old('link') }}"
                                    >
                                    @if ($errors->has('link'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('link') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="parent" class="col-sm-4 text-sm-left col-form-label text-nowrap">آیتم والد</label>
                                <div class="col-sm-5">
                                    <select class="form-control selectpicker {{ $errors->has('parent') ? 'is-invalid' : '' }}"
                                            data-placeholder="آیتم والد را انتخاب کنید"
                                            name="parent" id="parent">
                                        <option></option>
                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('parent'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('parent') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="order" class="col-sm-4 text-sm-left col-form-label text-nowrap">ترتیب نمایش</label>
                                <div class="col-sm-5">
                                    <input
                                            type="number"
                                            class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}"
                                            id="order"
                                            placeholder="ترتیب نمایش را وارد کنید"
                                            name="order"
                                            value="{{ old('order') }}"
                                    >
                                    @if ($errors->has('order'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('order') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12 col-md-5 offset-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="new_page" id="new_page">
                                        <label class="custom-control-label" for="new_page">نمایش در پنجره جدید</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-5 offset-sm-4">
                                    <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                                    <a class="btn btn-secondary" href="{{ route('panel.menuItems.index', $menu) }}">
                                        بازگشت
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
