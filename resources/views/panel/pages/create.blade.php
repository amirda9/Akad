@extends('panel.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1>افزودن صفحه جدید</h1>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                @include('components.messages')
                <form method="POST" action="{{ route('panel.pages.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-sm-7 col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="title" class="col-sm-2 text-sm-left col-form-label text-nowrap">عنوان</label>
                                        <div class="col-sm-10">
                                            <input
                                                    type="text"
                                                    class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                                    id="title"
                                                    name="title"
                                                    required
                                                    value="{{ old('title') }}"
                                                    oninvalid="this.setCustomValidity('عنوان را وارد کنید')"
                                                    oninput="setCustomValidity('')"
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="slug" class="col-sm-2 text-sm-left col-form-label text-nowrap">اسلاگ</label>
                                        <div class="col-sm-10">
                                            <input
                                                    type="text"
                                                    class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}"
                                                    id="slug"
                                                    name="slug"
                                                    value="{{ old('slug') }}"
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="short_description" class="col-sm-2 text-sm-left col-form-label">توضیحات کوتاه</label>
                                        <div class="col-sm-10">
                                    <textarea
                                            class="form-control"
                                            id="short_description"
                                            required
                                            rows="5"
                                            oninvalid="this.setCustomValidity('توضیحات کوتاه را وارد کنید')"
                                            oninput="setCustomValidity('')"
                                            name="short_description">{!! old('short_description') !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="full_description" class="col-sm-2 text-sm-left col-form-label">توضیحات کامل</label>
                                        <div class="col-sm-10">
                                    <textarea
                                            class="form-control"
                                            id="full_description"
                                            required
                                            oninvalid="this.setCustomValidity('توضیحات کامل را وارد کنید')"
                                            oninput="setCustomValidity('')"
                                            name="full_description">{!! old('full_description') !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="meta_title" class="col-sm-2 text-sm-left col-form-label text-nowrap">عنوان متا</label>
                                        <div class="col-sm-10">
                                            <input
                                                    type="text"
                                                    class="form-control {{ $errors->has('meta_title') ? 'is-invalid' : '' }}"
                                                    id="meta_title"
                                                    name="meta_title"
                                                    value="{{ old('meta_title') }}"
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="meta_description" class="col-sm-2 text-sm-left col-form-label text-nowrap">توضیحات متا</label>
                                        <div class="col-sm-10">
                                    <textarea
                                            class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}"
                                            id="meta_description"
                                            name="meta_description"
                                    >{!! old('meta_description') !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-sm-5 col-md-3 d-flex flex-column">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="image" class="d-block">
                                            <img id="image_preview" class="img-fluid d-none rounded mb-3" style="width:100%" src="#" />
                                            <div id="no_preview" class="border py-4 rounded mb-3 text-gray-300 text-center">
                                                <i class="fad fa-image" style="font-size:90px;"></i>
                                                <h4 class="mt-2">تصویر شاخص</h4>
                                            </div>
                                            <span class="btn btn-outline-primary btn-block">
                                        انتخاب عکس
                                        </span>
                                            <input type='file' class="d-none" name="image" id="image" />
                                        </label>
                                    </div>
                                    <hr/>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">وضعیت انتشار</span>
                                        </div>
                                        <select class="form-control {{ $errors->has('published') ? 'is-invalid' : '' }}" name="published">
                                            <option value="1" {{ old('published') == '1' ? 'selected' : '' }}>منتشر شود</option>
                                            <option value="0" {{ old('published') == '0' ? 'selected' : '' }}>عدم انتشار</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">ذخیره</button>
                                    <a class="btn btn-secondary" href="{{ route('panel.pages.index') }}">
                                        بازگشت
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/filemanager?type=Images',
            filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token={{ csrf_token() }}',
            filebrowserBrowseUrl: '/filemanager?type=Files',
            filebrowserUploadUrl: '/filemanager/upload?type=Files&_token={{ csrf_token() }}',
            height: 400,
            customConfig: "{{ asset('vendor/ckeditor/config_full.js') }}",
        };
        CKEDITOR.replace('full_description', options);

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image_preview').attr('src', e.target.result).removeClass('d-none');
                    $('#no_preview').addClass('d-none');
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                $('#image_preview').addClass('d-none');
                $('#no_preview').removeClass('d-none');
            }
        }

        $("#image").change(function() {
            readURL(this);
        });

        $("#addImage_input").change(function() {
            if (this.files && this.files[0]) {
                $('#add_image_form').submit();
            }
        });
    </script>
@endsection
