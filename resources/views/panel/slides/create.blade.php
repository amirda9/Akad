@extends('panel.layouts.master')

@section('content')

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <h1>افزودن اسلاید جدید</h1>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('panel.slides.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="image" class="col-sm-4 text-sm-left col-form-label text-nowrap">تصویر اسلاید</label>
                                <div class="col-sm-5">
                                    <input
                                            type="file"
                                            class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                            id="image"
                                            name="image"
                                    >
                                    @if ($errors->has('image'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="link" class="col-sm-4 text-sm-left col-form-label text-nowrap">لینک اسلاید</label>
                                <div class="col-sm-5">
                                    <input
                                            type="text"
                                            class="form-control dir-ltr text-left {{ $errors->has('link') ? 'is-invalid' : '' }}"
                                            id="link"
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
                                <label for="position" class="col-sm-4 text-sm-left col-form-label text-nowrap">موقعیت</label>
                                <div class="col-sm-5">
                                    <select name="position" data-placeholder='انتخاب موقعیت نمایش'
                                            required
                                            oninvalid="this.setCustomValidity('موقعیت نمایش را انتخاب کنید')"
                                            oninput="setCustomValidity('')"
                                            class="form-control selectpicker {{ $errors->has('position') ? 'is-invalid' : '' }}"
                                            id="position">
                                        @foreach(\App\Slide::$positions as $position_index => $position_title)
                                            <option {{ $position_index == old('position') ? 'selected' : '' }} value={{ $position_index }}>{{$position_title}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('position'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('position') }}</strong>
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
                                        value="{{ old('order') }}"
                                        name="order"
                                    >
                                    @if ($errors->has('order'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('order') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-5 offset-sm-4">
                                    <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                                    <a class="btn btn-secondary" href="{{ route('panel.slides.index') }}">
                                        لیست اسلایدها
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
