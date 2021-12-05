@extends('panel.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1>ویرایش برند</h1>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                @include('components.messages')
                <form method="POST" action="{{ route('panel.brands.update', $brand) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-12 col-sm-7 col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 text-sm-left col-form-label text-nowrap">نام برند</label>
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                id="name"
                                                name="name"
                                                required
                                                value="{{ old('name') ?: $brand->name }}"
                                                oninvalid="this.setCustomValidity('عنوان را وارد کنید')"
                                                oninput="setCustomValidity('')"
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="en_name" class="col-sm-2 text-sm-left col-form-label text-nowrap">نام انگلیسی</label>
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                class="form-control {{ $errors->has('en_name') ? 'is-invalid' : '' }}"
                                                id="en_name"
                                                name="en_name"
                                                value="{{ old('en_name') ?: $brand->en_name }}"
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
                                                value="{{ old('slug') ?: $brand->slug }}"
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="short_description" class="col-sm-2 text-sm-left col-form-label">توضیحات کوتاه</label>
                                        <div class="col-sm-10">
                                    <textarea
                                            class="form-control"
                                            id="short_description"
                                            rows="5"
                                            name="short_description">{!! old('short_description') ?: $brand->short_description !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="full_description" class="col-sm-2 text-sm-left col-form-label">توضیحات کامل</label>
                                        <div class="col-sm-10">
                                    <textarea
                                            class="form-control"
                                            id="full_description"
                                            name="full_description">{!! old('full_description') ?: $brand->full_description !!}</textarea>
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
                                                value="{{ old('meta_title') ?: $brand->meta_title }}"
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
                                            >{!! old('meta_description') ?: $brand->meta_description !!}</textarea>
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
                                            @if($brand->image)
                                                <img id="image_preview" class="img-fluid rounded mb-3" style="width:100%"
                                                     src="{{ getImageSrc($brand->image) }}" />
                                                <img id="no_preview" class="img-fluid d-none rounded mb-3" style="width:100%"
                                                     src="{{ getImageSrc($brand->image) }}" />
                                            @else
                                                <img id="image_preview" class="img-fluid d-none rounded mb-3" style="width:100%" src="#" />
                                                <div id="no_preview" class="border py-4 rounded mb-3 text-gray-300 text-center">
                                                    <i class="fad fa-image" style="font-size:90px;"></i>
                                                    <h4 class="mt-2">تصویر برند</h4>
                                                </div>
                                            @endif
                                            <input type='file' class="d-none" name="image" id="image" />
                                        </label>
                                        <span class="btn btn-outline-primary btn-block">
                                            انتخاب عکس
                                        </span>

                                        @if($brand->image)
                                            <a class="btn btn-outline-danger btn-block"
                                               onclick="return confirm('آیا مطمئن هستید؟')"
                                               href="{{ route('panel.brands.deleteImage',$brand) }}">
                                                حذف تصویر
                                            </a>
                                        @endif
                                    </div>
                                    <hr/>
                                    <div class="form-group">
                                        <label for="logo" class="d-block">
                                            @if($brand->logo)
                                                <img id="logo_preview" class="img-fluid rounded mb-3" style="width:100%"
                                                     src="{{ getImageSrc($brand->logo) }}" />
                                                <img id="no_preview" class="img-fluid d-none rounded mb-3" style="width:100%"
                                                     src="{{ getImageSrc($brand->logo) }}" />
                                            @else
                                                <img id="logo_preview" class="img-fluid d-none rounded mb-3" style="width:100%" src="#" />
                                                <div id="logo_no_preview" class="border py-4 rounded mb-3 text-gray-300 text-center">
                                                    <i class="fad fa-image" style="font-size:90px;"></i>
                                                    <h4 class="mt-2">لوگو برند</h4>
                                                </div>
                                            @endif
                                            <input type='file' class="d-none" name="logo" id="logo" />
                                        </label>
                                        <span class="btn btn-outline-primary btn-block">
                                            انتخاب عکس
                                        </span>

                                        @if($brand->logo)
                                            <a class="btn btn-outline-danger btn-block"
                                               onclick="return confirm('آیا مطمئن هستید؟')"
                                               href="{{ route('panel.brands.deleteLogo',$brand) }}">
                                                حذف لوگو
                                            </a>
                                        @endif
                                    </div>
                                    <hr/>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">وضعیت انتشار</span>
                                        </div>
                                        <select class="form-control {{ $errors->has('published') ? 'is-invalid' : '' }}" name="published">
                                            <option value="1" {{ $brand->published ? 'selected' : '' }}>منتشر شود</option>
                                            <option value="0" {{ $brand->published ? '' : 'selected' }}>عدم انتشار</option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">ترتیب نمایش</span>
                                        </div>
                                        <input type="text" name="order" autocomplete="off"
                                               placeholder="ترتیب نمایش"
                                               value="{{ old('order') ?: $brand->order }}"
                                               class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}">
                                    </div>

                                    <button type="submit" class="btn btn-primary">ذخیره</button>
                                    <a class="btn btn-secondary" href="{{ route('panel.brands.index') }}">
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
    <script>var options = {
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

        function readLogoURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#logo_preview').attr('src', e.target.result).removeClass('d-none');
                    $('#logo_no_preview').addClass('d-none');
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                $('#logo_preview').addClass('d-none');
                $('#logo_no_preview').removeClass('d-none');
            }
        }

        $("#image").change(function() {
            readURL(this);
        });
        $("#logo").change(function() {
            readLogoURL(this);
        });

    </script>
@endsection
