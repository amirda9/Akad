@extends('panel.layouts.master')

@section('content')

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <h1>افزودن منو جدید</h1>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('panel.menus.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="title" class="col-sm-4 text-sm-left col-form-label text-nowrap">عنوان منو</label>
                                <div class="col-sm-5">
                                    <input
                                        type="text"
                                        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                        id="title"
                                        placeholder="عنوان منو را وارد کنید"
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
                                <label for="name" class="col-sm-4 text-sm-left col-form-label text-nowrap">نام منو</label>
                                <div class="col-sm-5">
                                    <input
                                        type="text"
                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                        id="name"
                                        placeholder="نام منو را به انگلیسی وارد کنید"
                                        name="name"
                                        value="{{ old('name') }}"
                                    >
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-5 offset-sm-4">
                                    <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                                    <a class="btn btn-secondary" href="{{ route('panel.menus.index') }}">
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
