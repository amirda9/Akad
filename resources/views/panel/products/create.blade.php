@extends('panel.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1>افزودن محصول جدید</h1>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                @include('components.messages')
                <form id="createProductForm" method="POST" action="{{ route('panel.products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="title">عنوان محصول</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="title"
                                                        name="title"
                                                        required
                                                        value="{{ old('title') }}"
                                                        placeholder="عنوان محصول را وارد کنید"
                                                        oninvalid="this.setCustomValidity('عنوان را وارد کنید')"
                                                        oninput="setCustomValidity('')"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <div class="form-group">
                                                    <label for="slug">اسلاگ</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="slug"
                                                        name="slug"
                                                        placeholder="آدرس محصول را وارد کنید"
                                                        value="{{ old('slug') }}"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label for="categories">دسته بندی</label>
                                                    <select name="categories[]" data-placeholder='انتخاب دسته بندی'
                                                            data-live-search="true"
                                                            multiple
                                                            class="form-control selectpicker"
                                                            id="categories">
                                                        @include('panel.products.childrenOptions',[
                                                            'categories' => $categories,
                                                            'selected_categories' => old('categories')
                                                        ])
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label for="brand">برند</label>
                                                    <select name="brand" data-placeholder='انتخاب برند محصول'
                                                            data-live-search="true"
                                                            class="form-control selectpicker"
                                                            id="brand">
                                                        <option></option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{ $brand->id }}" {{ old('brand') == $brand->id ? 'selected' : '' }}>
                                                                {{ $brand->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="short_description">توضیحات کوتاه</label>
                                                    <textarea
                                                        class="form-control"
                                                        id="short_description"
                                                        placeholder="توضیحات محصول را وارد کنید"
                                                        rows="5"
                                                        name="short_description">{!! old('short_description') !!}</textarea>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="card card-body bg-white shadow-sm ">
                                    <a class="btn m-2 btn-light" data-toggle="collapse" href="#fulldescription" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        افزودن توضیحات کامل
                                    </a>
                                    <div class="collapse" id="fulldescription">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="full_description">توضیحات کامل</label>
                                                <textarea
                                                    class="form-control"
                                                    id="full_description"
                                                    placeholder="توضیحات محصول را وارد کنید"
                                                    rows="5"
                                                    name="full_description">{!! old('full_description') !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="btn m-2 btn-light" data-toggle="collapse" href="#producthepler" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        افزودن  راهنمای سایز
                                    </a>
                                    <div class="collapse" id="producthepler">

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="product_helper">راهنمای سایز</label>
                                                <textarea
                                                    class="form-control"
                                                    id="product_helper"
                                                    placeholder="راهنمای سایز محصول را وارد کنید"
                                                    rows="5"
                                                    name="product_helper">{!! old('product_helper') !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="product-information" class="card card-body">
                                    <div class="mb-3 pb-2 border-bottom">
                                        <label for="product_type">نوع محصول</label>
                                        <select class="selectpicker mr-3" name="product_type" id="product_type">
                                            <option value="simple-product" {{ old('product_type') == 'simple-product' ? 'selected' : '' }}>محصول ساده</option>
                                            <option value="variable-product" {{ old('product_type') == 'variable-product' ? 'selected' : '' }}>محصول متغیر</option>
                                        </select>
                                    </div>
                                    <div class="row no-gutters">
                                        <div class="col-3">
                                            <div class="nav flex-column nav-pills " id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                <a class="nav-link active" id="public-tab" data-toggle="pill" href="#public-content"
                                                   role="tab" aria-controls="v-pills-home">
                                                    همگانی
                                                </a>
                                                <a class="nav-link" id="inventory-tab" data-toggle="pill" href="#inventory-content"
                                                   role="tab">
                                                    انبار
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="tab-content pr-3" id="v-pills-tabContent">
                                                <div class="tab-pane fade border p-3 show active" id="public-content"
                                                     role="tabpanel">
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="regular_price">قیمت اصلی</label>
                                                        <div class="input-group col-12 col-lg-9">
                                                            <input type="number" class="form-control" value="{{ old('regular_price') }}"
                                                                   id="regular_price" name="regular_price">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">تومان</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="sale_price">قیمت فروش فوق العاده</label>
                                                        <div class="input-group col-12 col-lg-9 align-items-start">
                                                            <input type="number" class="form-control" value="{{ old('sale_price') }}"
                                                                   id="sale_price" name="sale_price">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">تومان</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr/>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="is_featured" {{old('is_featured') ? 'checked' : ''}} class="custom-control-input" id="is_featured">
                                                            <label class="custom-control-label" for="is_featured">پیشنهاد شگفت انگیز</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade border p-3 show " id="inventory-content"
                                                     role="tabpanel">
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="sku">کد محصول</label>
                                                        <div class="col-12 col-lg-9">
                                                            <input type="text" class="form-control" value="{{ old('sku') }}"
                                                                   id="sku" name="sku">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="weight">وزن محصول</label>
                                                        <div class="input-group col-12 col-lg-9">
                                                            <input type="number" class="form-control" value="{{ old('weight') }}"
                                                                   id="weight" name="weight">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">گرم</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="manage_stock">مدیریت موجودی؟</label>
                                                        <div class="col-12 col-lg-9">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" name="manage_stock" {{ old('manage_stock') ? 'checked' : '' }} class="custom-control-input" id="manage_stock">
                                                                <label class="custom-control-label" for="manage_stock">فعال کردن مدیریت موجودی انبار</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="stock">موجودی</label>
                                                        <div class="col-12 col-lg-9">
                                                            <input type="text" id="stock" value="{{ old('stock') }}" class="form-control" name="stock">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="min_stock">آستانه کم بودن موجودی؟</label>
                                                        <div class="col-12 col-lg-9">
                                                            <input type="text" id="min_stock" value="{{ old('min_stock') }}" class="form-control" name="min_stock">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="stock_status">وضعیت انبار</label>
                                                        <div class="col-12 col-lg-9">
                                                            <select name="stock_status" class="selectpicker" id="stock_status">
                                                                <option value="instock" {{ old('stock_status') == 'instock' ? 'selected' : '' }}>موجود در انبار</option>
                                                                <option value="outofstock" {{ old('stock_status') == 'outofstock' ? 'selected' : '' }}>در انبار موجود نمی باشد</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <hr/>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="sold_individually">فروش تکی</label>
                                                        <div class="col-12 col-lg-9">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" name="sold_individually" {{ old('sold_individually') ? 'checked' : '' }}
                                                                       class="custom-control-input" id="sold_individually">
                                                                <label class="custom-control-label" for="sold_individually">اگر مایل به فروش تکی هستید، این گزینه را فعال کنید</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="meta_title">عنوان متا</label>
                                                <input
                                                        type="text"
                                                        placeholder="عنوان متا را وارد کنید"
                                                        class="form-control"
                                                        id="meta_title"
                                                        name="meta_title"
                                                        value="{{ old('meta_title') }}"
                                                >
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="meta_description">توضیحات متا</label>
                                                <textarea
                                                    placeholder="توضیحات متا را وارد کنید"
                                                    class="form-control"
                                                    id="meta_description"
                                                    name="meta_description"
                                                >{!! old('meta_description') !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3 d-flex flex-column">
                            <div class="card">
                                <div class="card-body p-2">
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
                                            <span class="input-group-text">وضعیت</span>
                                        </div>
                                        <select class="form-control" name="published">
                                            <option value="1" {{ old('published') == '1' ? 'selected' : '' }}>منتشر شود</option>
                                            <option value="0" {{ old('published') == '0' ? 'selected' : '' }}>عدم انتشار</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-success">ذخیره</button>
                                    <a class="btn btn-secondary" href="{{ route('panel.products.index') }}">
                                        بازگشت
                                    </a>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body p-2">
                                    <h5 class="pb-3 mb-3 border-bottom">برچسب ها</h5>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input id="tags" type="hidden" value="{{ old('tags') }}" name="tags">
                                            <input id="tag_input" title="برچسب" placeholder="برچسب" type="text" class="form-control">
                                            <div class="input-group-append">
                                                <button onclick="addNewTag()" type="button" class="input-group-btn btn btn-primary">
                                                    افزودن
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tag-labels">
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body p-2">
                                    <h5 class="pb-3 mb-3 border-bottom">گالری تصاویر</h5>
                                    <div class="form-group">
                                        <label for="gallery" class="d-block">
                                            <span class="btn btn-outline-primary btn-block">
                                                انتخاب عکس
                                            </span>
                                            <input type='file' multiple class="d-none" name="gallery[]" id="gallery" />
                                        </label>
                                    </div>
                                    <div id="image-holder">
                                    </div>
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
        var simpleConfig = {
            height: 250,
            customConfig: "{{ asset('vendor/ckeditor/config_simple.js') }}",
        };
        CKEDITOR.replace('full_description', options);
        CKEDITOR.replace('product_helper', options);
        CKEDITOR.replace('short_description', simpleConfig);

        $('body').on('keydown','#tag_input',function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
                addNewTag();
            }
            if($(this).val().length > 3) {
                if(!!searchTimeout) {
                    clearTimeout(searchTimeout);
                }
                searchTimeout = setTimeout(searchTags, 1000);
            }
        }).on('click','.product-tag-label i',function() {
            let selected_tag = $(this).data('tag')
            tags = tags.filter(function (el) {
                return el != selected_tag;
            });
            renderTags();
        });

        var searchTimeout = null;

        function searchTags() {
            let query = $('#tag_input').val();
            $.get("{{ route('panel.tags.search') }}",{
                q: query
            }).done(data => {
                console.log(data)
            })
        }
        var tags = !!$('#tags').val() ? ($('#tags').val()).split(',') : [];
        $('document').ready(() =>{
            renderTags();
            renderAttributes();
        })

        function addNewTag() {
            let tag = $('#tag_input').val();
            tags = [...tags, tag];
            tags = [...new Set(tags)];
            tags = tags.filter(function (el) {
                return !!el;
            });
            renderTags();
            $('#tag_input').val('')
        }

        function renderTags() {
            $('#tags').val(tags);
            $('#tag-labels').empty();
            tags.map(tag => {
                $('#tag-labels').append(`<div class="product-tag-label">${tag}<i data-tag="${tag}" class="fa fa-times"></i></div>`);
            })
        }


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

        $("#gallery").on('change', function () {
            var countFiles = $(this)[0].files.length;
            var imgPath = $(this)[0].value;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            var image_holder = $("#image-holder");
            image_holder.empty();
            if (extn == "png" || extn == "jpg" || extn == "jpeg") {
                if (typeof (FileReader) != "undefined") {
                    for (var i = 0; i < countFiles; i++) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("<img />", {
                                "src": e.target.result,
                                "class": "gallery-image-thimbnail"
                            }).appendTo(image_holder);
                        }
                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[i]);
                    }
                } else {
                    alert("This browser does not support FileReader.");
                }
            } else {
                alert("Pls select only images");
            }
        });

    </script>
@endsection
