@extends('panel.layouts.master')

@section('content')

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <h1>ویرایش گروه</h1>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('panel.attributeGroups.update',$group) }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group row">
                                <label for="title" class="col-sm-4 text-sm-left col-form-label text-nowrap">عنوان گروه</label>
                                <div class="col-sm-5">
                                    <input
                                        type="text"
                                        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                        id="title"
                                        placeholder="عنوان گروه را وارد کنید"
                                        required
                                        name="title"
                                        value="{{ old('title') ?: $group->title }}"
                                    >
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="order" class="col-sm-4 text-sm-left col-form-label text-nowrap">ترتیب نمایش</label>
                                <div class="col-sm-5">
                                    <input
                                        type="text"
                                        class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}"
                                        id="order"
                                        name="order"
                                        value="{{ old('order') ?: $group->order }}"
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
                                    <a class="btn btn-secondary" href="{{ route('panel.attributeGroups.index') }}">
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