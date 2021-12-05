@extends('panel.layouts.master')

@section('head')
    <style>
        .simple-product .variable-product-only {
            display: none;
        }
        .gallery-image-thumbnail {
            max-width: 70px;
            padding:2px;
            margin:2px;
            background-color: #eee;
            flex-grow: 1;
            height: 90px;
            object-fit: cover;
        }
        .product-tag-label {
            display: inline-block;
            padding: 2px 4px;
            margin: 2px 3px;
            background-color: #f1f1f1;
            border-radius: 4px;
        }
        .product-tag-label i{
            margin-right: 5px;
            color: tomato;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1>ویرایش محصول</h1>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                @include('components.messages')
                <form id="editProductForm" method="POST" action="{{ route('panel.products.update',$product) }}" enctype="multipart/form-data">
                    <input type="hidden" value="0" name="form_validated">
                    <div class="row">
                        <div class="col-12 col-lg-9">
                                @csrf
                                @method('put')
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
                                                        value="{{ old('title') ?: $product->title }}"
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
                                                        value="{{ old('slug') ?: $product->slug }}"
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
                                                            'selected_categories' => old('categories') ?: $product->categories()->pluck('id')->toArray()
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
                                                            <option value="{{ $brand->id }}" {{ old('brand') ? (old('brand') == $brand->id ? 'selected' : '') : ($product->brand_id == $brand->id ? 'selected' : '') }}>
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
                                                        name="short_description">{!! old('short_description') ?: $product->short_description !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card card-body bg-white shadow-sm ">
                                    <a class="btn m-2 btn-light" data-toggle="collapse" href="#fulldescription" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        ویرایش توضیحات کامل
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
                                                    name="full_description">{!! old('full_description') ?: $product->full_description !!}</textarea>
                                            </div>
                                        </div>
                                    </div>


                                    <a class="btn m-2 btn-light" data-toggle="collapse" href="#producthepler" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        ویرایش  راهنمای سایز
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
                                                    name="product_helper">{!! old('product_helper') ?: $product->product_helper !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="product-information" class="card card-body {{ $product->type == 'variable-product' ? 'variable-product' : 'simple-product' }}">
                                    <div class="mb-3 pb-2 border-bottom">
                                        <label for="product_type">نوع محصول</label>
                                        <select class="selectpicker mr-3" name="product_type" id="product_type">
                                            <option value="simple-product"  {{ old('product_type') ? (old('product_type') == 'simple-product' ? 'selected' : '') : ($product->type == 'simple-product' ? 'selected' : '') }}>محصول ساده</option>
                                            <option value="variable-product" {{ old('product_type') ? (old('product_type') == 'variable-product' ? 'selected' : '') : ($product->type == 'variable-product' ? 'selected' : '') }}>محصول متغیر</option>
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
                                                <a class="nav-link" id="attributes-tab" data-toggle="pill" href="#attributes-content"
                                                   role="tab">
                                                    ویژگی ها
                                                </a>
                                                <a class="nav-link variable-product-only" id="variables-tab" data-toggle="pill" href="#variables-content"
                                                   role="tab">
                                                    متغیرها
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
                                                            <input type="number" class="form-control" value="{{ old('regular_price') ?: $product->regular_price }}"
                                                                   id="regular_price" name="regular_price">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">تومان</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="sale_price">قیمت فروش فوق العاده</label>
                                                        <div class="input-group col-12 col-lg-9 align-items-start">
                                                            <input type="number" class="form-control" value="{{ old('sale_price') ?: $product->sale_price }}"
                                                                   id="sale_price" name="sale_price">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">تومان</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr/>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="is_featured" {{ old('is_featured') ? (old('is_featured') ? 'checked' : '') : ($product->is_featured ? 'checked' : '') }} class="custom-control-input" id="is_featured">
                                                            <label class="custom-control-label" for="is_featured">پیشنهاد شگفت انگیز</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade border p-3 show " id="inventory-content"
                                                     role="tabpanel">
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="sku">کد محصول</label>
                                                        <div class="col-12 col-lg-9">
                                                            <input type="text" class="form-control" value="{{ old('sku') ?: $product->sku }}"
                                                                   id="sku" name="sku">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="weight">وزن محصول</label>
                                                        <div class="input-group col-12 col-lg-9">
                                                            <input type="number" class="form-control" value="{{ old('weight') ?: $product->weight }}"
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
                                                                <input type="checkbox" name="manage_stock" {{ old('manage_stock') ? (old('manage_stock') ? 'checked' : '') : ($product->manage_stock ? 'checked' : '') }}
                                                                    class="custom-control-input" id="manage_stock">
                                                                <label class="custom-control-label" for="manage_stock">فعال کردن مدیریت موجودی انبار</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="stock">موجودی</label>
                                                        <div class="col-12 col-lg-9">
                                                            <input type="text" id="stock" value="{{ old('stock') ?: $product->stock }}" class="form-control" name="stock">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="min_stock">آستانه کم بودن موجودی؟</label>
                                                        <div class="col-12 col-lg-9">
                                                            <input type="text" id="min_stock" value="{{ old('min_stock') ?: $product->min_stock }}" class="form-control" name="min_stock">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="stock_status">وضعیت انبار</label>
                                                        <div class="col-12 col-lg-9">
                                                            <select name="stock_status" class="selectpicker" id="stock_status">
                                                                <option value="instock" {{ old('stock_status') ? (old('stock_status') == 'instock' ? 'selected' : '') : ($product->stock_status == 'instock' ? 'selected' : '') }}>موجود در انبار</option>
                                                                <option value="outofstock" {{ old('stock_status') ? (old('stock_status') == 'outofstock' ? 'selected' : '') : ($product->stock_status == 'outofstock' ? 'selected' : '') }}>در انبار موجود نمی باشد</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <hr/>
                                                    <div class="form-group row">
                                                        <label class="col-12 col-lg-3" for="sold_individually">فروش تکی</label>
                                                        <div class="col-12 col-lg-9">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" name="sold_individually"  {{ old('sold_individually') ? (old('sold_individually') ? 'checked' : '') : ($product->sold_individually ? 'checked' : '') }}
                                                                       class="custom-control-input" id="sold_individually">
                                                                <label class="custom-control-label" for="sold_individually">اگر مایل به فروش تکی هستید، این گزینه را فعال کنید</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade border p-3 show " id="attributes-content"
                                                     role="tabpanel">
                                                    <div id="attribute_form_header">
                                                        <select id="attributes_list" class="selectpicker">
                                                            @foreach($attribute_groups as $attribute_group)
                                                                <optgroup label="{{ $attribute_group->title }}">
                                                                    @foreach($attribute_group->attributes as $attribute)
                                                                        @php($product_attribute = $selected_attributes->where('id',$attribute->id)->first())
                                                                        @if(old('attributes')[$attribute->id] ?? false)
                                                                            <option disabled value="{{ $attribute->id }}"
                                                                                    data-values="{{ (old('attributes')[$attribute->id]['values'] ?? false) ? json_encode(old('attributes')[$attribute->id]['values']) : '' }}"
                                                                                    data-visibility="{{ (old('attributes')[$attribute->id]['visibility'] ?? false) ? '1' : '0' }}"
                                                                                    data-variation="{{ (old('attributes')[$attribute->id]['variation'] ?? false) ? '1' : '0' }}"
                                                                            >{{ $attribute->title }}</option>
                                                                        @elseif($product_attribute)
                                                                            <option value="{{ $attribute->id }}"
                                                                                    disabled
                                                                                    data-values="{{ json_encode($product_attribute->pivot->value) }}"
                                                                                    data-visibility="{{$product_attribute->pivot->visibility}}"
                                                                                    data-variation="{{$product_attribute->pivot->variation}}">{{ $attribute->title }}</option>
                                                                        @else
                                                                        <option value="{{ $attribute->id }}">{{ $attribute->title }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </optgroup>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" id="on_attributes_list_select" class="btn btn-primary">انتخاب</button>
                                                        @can('view attributes')
                                                            <a href="{{ route('panel.attributeGroups.index') }}" target="_blank"
                                                               class="btn btn-success">ثبت جدید</a>
                                                        @endcan
                                                        <hr/>
                                                    </div>
                                                    <div id="attribute_form_content">

                                                    </div>
                                                </div>
                                                <div class="tab-pane fade border p-3 show " id="variables-content"
                                                     role="tabpanel">
                                                    <div id="variations_form_header">
                                                        <button type="button" id="get_variables_form" class="btn btn-primary btn-sm">ساخت متغیرها</button>
                                                        <hr/>
                                                    </div>
                                                    <div id="variations_form_content">
                                                        @include('panel.products.variationsForm',[
                                                            'current_product' => $product
                                                        ])
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
                                            @if($product->image)
                                                <img id="image_preview" class="img-fluid rounded mb-3" style="width:100%"
                                                     src="{{ getImageSrc($product->image) }}" />
                                                <img id="no_preview" class="img-fluid d-none rounded mb-3" style="width:100%"
                                                     src="{{ getImageSrc($product->image) }}" />
                                            @else
                                                <img id="image_preview" class="img-fluid d-none rounded mb-3" style="width:100%" src="#" />
                                                <div id="no_preview" class="border py-4 rounded mb-3 text-gray-300 text-center">
                                                    <i class="fad fa-image" style="font-size:90px;"></i>
                                                    <h4 class="mt-2">تصویر شاخص</h4>
                                                </div>
                                            @endif
                                            <span class="btn btn-outline-primary btn-block">
                                                انتخاب عکس
                                            </span>
                                            <input type='file' class="d-none" name="image" id="image" />
                                        </label>
                                        @if($product->image)
                                            <a href="{{ route('panel.products.deleteImage',$product) }}" onclick="return confirm('آیا مطمئن هستید؟')" class="btn btn-outline-danger btn-block">
                                                حذف تصویر شاخص
                                            </a>
                                        @endif
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
                                            <input id="tags" type="hidden" value="{{ old('tags') ?? implode(',',$product->tags()->pluck('title')->toArray()) }}" name="tags">
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
                                    @foreach($product->images as $image)
                                        <div class="d-inline-block position-relative m-1">
                                            <a href="{{ getImageSrc($image->src) }}" target="_blank">
                                                <img class="gallery-image-thumbnail m-0" src="{{ getImageSrc($image->src) }}" />
                                            </a>
                                            <a href="{{ route('panel.products.gallery.delete',[$product, $image]) }}" onclick="return confirm('آیا مطمئن هستید؟')" class="bg-light text-red px-2" style="position: absolute; left: 0; top: 0"><i class="fas fa-times"></i></a>
                                        </div>
                                    @endforeach
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

        $('body').on('click','#on_attributes_list_select',() => {
            try {
                let selected_attribute = $('#attributes_list :selected');
                if(!selected_attribute.attr('disabled')) {
                    $.get('{{ route('panel.attributes.getForm') }}',{
                        attribute_id: selected_attribute.val()
                    }).done((data) => {
                        $('#attribute_form_content').append(data);
                        selected_attribute.attr('disabled',true);
                        $('.selectpicker').selectpicker('refresh');
                    });
                }
            } catch (e) {
                console.log(e)
            }
        }).on('click','.add_attribute_value',function() {
            let selected_attribute_id = $(this).data('attribute-id');
            let new_value = prompt('لطفا مقدار جدید را وارد کنید');
            $.post('{{ route('panel.attributes.addNewValue') }}',{
                _token: '{{ csrf_token() }}',
                attribute_id: selected_attribute_id,
                new_value
            }).done(data => {
                $(`#product_attribute_form_${selected_attribute_id}`).replaceWith(data);
                $('.selectpicker').selectpicker('refresh');
            }).fail(e => {
                console.log(e)
            })
        }).on('click','.remove_attribute_form',function() {
            if(confirm('آیا مطمئن هستید؟')) {
                let selected_attribute_id = $(this).data('attribute-id');
                $(`#product_attribute_form_${selected_attribute_id}`).remove();
                $(`#attributes_list option[value=${selected_attribute_id}]`).removeAttr('disabled');
                $('.selectpicker').selectpicker('refresh');
            }
        }).on('change','#product_type',function () {
            $('#product-information').removeClass('simple-product variable-product')
                .addClass($(this).val());
        }).on('click','#get_variables_form',function () {
            if(confirm('آیا مطمئن هستید ؟')) {
                getVariationForms();
            }
        }).on('click','.remove-variation-form',function() {
            if(confirm('آیا مطمئن هستید؟')) {
                let variation_id = $(this).data('variation-id');
                $(`#variation-form-${variation_id}`).remove();
            }
        }).on('keydown','#tag_input',function (e) {
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
        }).on('submit','#editProductForm',function (e) {
            $('#messageContainer').remove();
            if($('input[name=form_validated]').val() != 1) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('panel.products.updateValidation',$product) }}",
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('input[name=form_validated]').val(1);
                        $('#editProductForm').submit();
                    },
                    error: function(error) {
                        console.log(error)
                        $('div.content div.container-fluid').prepend(error.responseText);
                        $("html, body").animate({ scrollTop: 0 }, "fast");
                    }
                });
            }
        });

        var searchTimeout = null;

        function getVariationForms(selected_variations = null) {
            let variations = [];
            let regular_price = $('#regular_price').val();
            let sale_price = $('#sale_price').val();
            if(selected_variations == null) {
                let attribute_variations = $('.attribute_variation:checked');
                attribute_variations.map((index,attribute_variation) => {
                    let attribute_id = $(attribute_variation).data('attribute-id');
                    let selected_values = $(`#attribute-select-picker-${attribute_id}`).val();
                    variations.push({
                        attribute_id,
                        selected_values:selected_values || []
                    })
                })
            } else {
                variations = selected_variations;
            }
            console.log(variations);

            $.post("{{ route('panel.attributes.getVariationForm') }}",{
                _token: '{{ csrf_token() }}',
                variations: variations || [],
                regular_price,
                sale_price,
            }).done(data => {
                $('#variations_form_content').html(data)
                $('.selectpicker').selectpicker('refresh');
            }).fail(e => {
                console.log(e)
            })
        }

        function searchTags() {
            let query = $('#tag_input').val();
            $.get("{{ route('panel.tags.search') }}",{
                q: query
            }).done(data => {
                console.log(data)
            })
        }
        var tags = !!$('#tags').val() ? ($('#tags').val()).split(',') : [];
        $('document').ready(() => {
            renderTags();
            renderAttributes();
        })

        function renderAttributes() {
            let old_attributes = $('#attributes_list :disabled');
            old_attributes.map((index, item) => {
                appendAttributeForm(item)
            })
        }

        async function appendAttributeForm(selected_attribute) {
            await $.get('{{ route('panel.attributes.getForm') }}',{
                attribute_id: $(selected_attribute).val(),
                values: !!$(selected_attribute).data('values') ? $(selected_attribute).data('values') : [],
                visibility: $(selected_attribute).data('visibility'),
                variation: $(selected_attribute).data('variation'),
            }).done((data) => {
                $('#attribute_form_content').append(data);
                $(selected_attribute).attr('disabled',true);
                $('.selectpicker').selectpicker('refresh');
            });
        }
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
                                "class": "gallery-image-thumbnail"
                            }).appendTo(image_holder);
                        }
                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[i]);
                    }
                } else {
                    alert("This browser does not support FileReader.");
                }
            }
        });

    </script>
@endsection
