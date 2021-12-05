@extends('panel.layouts.master')

@section('content')

<div class="content-wrapper">
    <div class="content-header">
    </div>

    <div class="content">
        <div class="container-fluid">
            @include('components.messages')
            <div class="mb-5">
                <h4>اطلاعات وبسایت</h4>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-4 form-group" id="site_information_logo">
                                @if($site_information['logo'] ?? false)
                                    <div class="p-3 bg-gray-300 rounded">
                                        <div class="container-with-hover bg-png-pattern rounded p-2">
                                            <div class="content text-center">
                                                <img style="max-height: 100px;" class="img-fluid" src="{{ getImageSrc($site_information['logo']) }}" />
                                            </div>
                                            <div class="overlay d-flex align-items-center justify-content-center">
                                                <a href="{{ route('panel.options.siteInformation.deleteLogo') }}"
                                                   onclick="return confirm('آیا مطمئن هستید؟')"
                                                   class="btn btn-light">
                                                    حذف تصویر
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <form method="post" id="updateLogoForm" enctype="multipart/form-data"
                                          action="{{ route('panel.options.siteInformation.updateLogo') }}">
                                        @csrf
                                        <label for="logo_input" class="d-block border-dashed border-2 border-gray-400 p-3 p-lg-5 rounded text-center">
                                            <p>لوگو وبسایت را انتخاب کنید</p>
                                            <div class="btn px-4 btn-primary shadow-sm d-inline-block">انتخاب کنید</div>
                                        </label>
                                        <input type="file" required accept="image/png, image/jpeg" id="logo_input" name="logo" class="d-none">
                                    </form>
                                @endif
                            </div>
                            <div class="col-12 col-lg-4 form-group" id="site_information_logo">
                                @if($site_information['footer_logo'] ?? false)
                                    <div class="p-3 bg-gray-300 rounded">
                                        <div class="container-with-hover bg-png-pattern rounded p-2">
                                            <div class="content text-center">
                                                <img style="max-height: 100px;" class="img-fluid" src="{{ getImageSrc($site_information['footer_logo']) }}" />
                                            </div>
                                            <div class="overlay d-flex align-items-center justify-content-center">
                                                <a href="{{ route('panel.options.siteInformation.deleteFooterLogo') }}"
                                                   onclick="return confirm('آیا مطمئن هستید؟')"
                                                   class="btn btn-light">
                                                    حذف تصویر
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <form method="post" id="updateFooterLogoForm" enctype="multipart/form-data"
                                          action="{{ route('panel.options.siteInformation.updateFooterLogo') }}">
                                        @csrf
                                        <label for="footer_logo_input" class="d-block border-dashed border-2 border-gray-400 p-3 p-lg-5 rounded text-center">
                                            <p>لوگوی فوتر وبسایت را انتخاب کنید</p>
                                            <div class="btn px-4 btn-primary shadow-sm d-inline-block">انتخاب کنید</div>
                                        </label>
                                        <input type="file" required accept="image/png, image/jpeg" id="footer_logo_input" name="footer_logo" class="d-none">
                                    </form>
                                @endif
                            </div>
                            <div class="col-12 col-lg-4 form-group" id="site_information_favicon">
                                @if($site_information['favicon'] ?? false)
                                    <div class="p-3 bg-gray-300 rounded">
                                        <div class="container-with-hover bg-png-pattern rounded p-2">
                                            <div class="content text-center">
                                                <img style="max-height: 100px;" class="img-fluid" src="{{ getImageSrc($site_information['favicon']) }}" />
                                            </div>
                                            <div class="overlay d-flex align-items-center justify-content-center">
                                                <a href="{{ route('panel.options.siteInformation.deleteFavicon') }}"
                                                   onclick="return confirm('آیا مطمئن هستید؟')"
                                                   class="btn btn-light">
                                                    حذف تصویر
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <form method="post" id="updateFaviconForm" enctype="multipart/form-data"
                                          action="{{ route('panel.options.siteInformation.updateFavicon') }}">
                                        @csrf
                                        <label for="favicon_input" class="d-block border-dashed border-2 border-gray-400 p-3 p-lg-5 rounded text-center">
                                            <p>آیکن وبسایت برای مرورگر را انتخاب کنید</p>
                                            <div class="btn px-4 btn-primary shadow-sm d-inline-block">انتخاب کنید</div>
                                        </label>
                                        <input type="file" required accept="image/png, image/jpeg" id="favicon_input" name="favicon" class="d-none">
                                    </form>
                                @endif
                            </div>
                        </div>
                        <form method="post" action="{{ route('panel.options.siteInformation') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="website_name">نام وبسایت</label>
                                    <input type="text" name="website_name" id="website_name" class="form-control" value="{{ $site_information['website_name'] ?? '' }}">
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="main_title">عنوان صفحه اصلی</label>
                                    <input type="text" name="main_title" id="main_title" class="form-control" value="{{ $site_information['main_title'] ?? '' }}">
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="shop_mobile">موبایل فروشگاه</label>
                                    <input type="text" name="shop_mobile" id="shop_mobile" class="form-control" value="{{ $site_information['shop_mobile'] ?? '' }}">
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="shop_phone">تلفن فروشگاه</label>
                                    <input type="text" name="shop_phone" id="shop_phone" class="form-control" value="{{ $site_information['shop_phone'] ?? '' }}">
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="instagram">اینستاگرام</label>
                                    <input type="text" name="instagram" id="instagram" class="form-control" value="{{ $site_information['instagram'] ?? '' }}">
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="telegram">تلگرام</label>
                                    <input type="text" name="telegram" id="telegram" class="form-control" value="{{ $site_information['telegram'] ?? '' }}">
                                </div>
                                <div class="col-12 form-group">
                                    <label for="address">آدرس فروشگاه</label>
                                    <input type="text" name="address" id="address" class="form-control"
                                           value="{{ $site_information['address'] ?? '' }}">
                                </div>
                                <div class="col-12 form-group">
                                    <label for="copyright">متن کپی رایت</label>
                                    <input type="text" name="copyright" id="copyright" class="form-control"
                                           value="{{ $site_information['copyright'] ?? '' }}">
                                </div>
                                <div class="col-12 form-group">
                                    <label for="description">توضیحات وبسایت</label>
                                    <textarea name="description" id="description"
                                              class="form-control" placeholder="توضیحات مختصر در مورد وبسایت">{{ $site_information['description'] ?? '' }}</textarea>
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="province">استان فروشگاه</label>
                                    <select name="province" id="province" data-live-search="true" title="استان وبسایت را انتخاب کنید" class="form-control selectpicker">
                                        @foreach($provinces as $province)
                                            <option {{ $selected_province ? ($province['id'] == $selected_province['id'] ? 'selected' : '') : '' }} value="{{ $province['id'] }}">{{ $province['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-6 form-group">
                                    <label for="city">شهر فروشگاه</label>
                                    <select name="city" id="city" data-live-search="true" title="شهر وبسایت را انتخاب کنید" class="form-control selectpicker">
                                        @if($cities)
                                            @foreach($cities as $city)
                                                <option {{ $selected_city ? ($city['id'] == $selected_city['id'] ? 'selected' : '') : '' }} value="{{ $city['id'] }}">{{ $city['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">ثبت تغییرات</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <h4>تنظیمات ارسال</h4>
                <div class="card">
                    <div class="card-body">
                        @if($shippings['free_shipping'] ?? false)
                            <div class="d-flex align-items-center border p-3 rounded mb-3">
                                <i class="icons icon-free-delivery" style="font-size: 50px; line-height: 50px;"></i>
                                <div class="flex-grow-1 px-3">
                                    <h4>{{ $shippings['free_shipping']['title'] }}</h4>
                                    <p class="fa-num m-0 text-gray-600">
                                        حداقل مبلغ سبد خرید
                                        {{ $shippings['free_shipping']['province_min_order_price'] }} تومان
                                        {{ $shippings['free_shipping']['all_min_order_price'] }} تومان
                                    </p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fal ml-3 fa-cog fa-2x cursor-pointer" data-toggle="modal"
                                       data-target="#editFreeShippingModal"></i>
                                    <div class="d-flex align-items-center p-2 border rounded">
                                        @if($shippings['free_shipping']['is_active'])
                                            <span class="btn btn-success">فعال</span>
                                            <span class="btn btn-set-deactive" data-target="free_shipping">غیرفعال</span>
                                        @else
                                            <span class="btn btn-set-active" data-target="free_shipping">فعال</span>
                                            <span class="btn btn-danger">غیرفعال</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($shippings['post_shipping'] ?? false)
                            <div class="d-flex align-items-center border p-3 rounded mb-3">
                                <i class="icons icon-post" style="font-size: 50px; line-height: 50px;"></i>
                                <div class="flex-grow-1 px-3">
                                    <h4>{{ $shippings['post_shipping']['title'] }}</h4>
                                    <p class="fa-num m-0 text-gray-600">
                                        هزینه ارسال برای استان
                                        {{ $shippings['post_shipping']['province_price'] }} تومان
                                        و برای سایر شهرها
                                        {{ $shippings['post_shipping']['other_provinces_price'] }} تومان
                                    </p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fal ml-3 fa-cog fa-2x cursor-pointer" data-toggle="modal"
                                       data-target="#editPostShippingModal"></i>
                                    <div class="d-flex align-items-center p-2 border rounded">
                                        @if($shippings['post_shipping']['is_active'])
                                            <span class="btn btn-success">فعال</span>
                                            <span class="btn btn-set-deactive" data-target="post_shipping">غیرفعال</span>
                                        @else
                                            <span class="btn btn-set-active" data-target="post_shipping">فعال</span>
                                            <span class="btn btn-danger">غیرفعال</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($shippings['bike_shipping'] ?? false)
                            <div class="d-flex align-items-center border p-3 rounded mb-3">
                                <i class="icons icon-courier" style="font-size: 50px; line-height: 50px;"></i>
                                <div class="flex-grow-1 px-3">
                                    <h4>{{ $shippings['bike_shipping']['title'] }}</h4>
                                    <p class="fa-num m-0 text-gray-600">
                                        هزینه ارسال فقط برای شهر فروشگاه
                                        {{ $shippings['bike_shipping']['price'] }} تومان
                                    </p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fal ml-3 fa-cog fa-2x cursor-pointer" data-toggle="modal"
                                       data-target="#editBikeShippingModal"></i>
                                    <div class="d-flex align-items-center p-2 border rounded">
                                        @if($shippings['bike_shipping']['is_active'])
                                            <span class="btn btn-success">فعال</span>
                                            <span class="btn btn-set-deactive" data-target="bike_shipping">غیرفعال</span>
                                        @else
                                            <span class="btn btn-set-active" data-target="bike_shipping">فعال</span>
                                            <span class="btn btn-danger">غیرفعال</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($shippings['in_place_delivery'] ?? false)
                            <div class="d-flex align-items-center border p-3 rounded mb-3">
                                <i class="icons icon-delivery-man" style="font-size: 50px; line-height: 50px;"></i>
                                <div class="flex-grow-1 px-3">
                                    <h4>{{ $shippings['in_place_delivery']['title'] }}</h4>
                                    <p class="fa-num m-0 text-gray-600">
                                        درصورتی که امکان دریافت حضوری محصولات توسط مشتری وجود دارد
                                    </p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fal ml-3 fa-cog fa-2x cursor-pointer" data-toggle="modal"
                                       data-target="#editInPlaceShippingModal"></i>
                                    <div class="d-flex align-items-center p-2 border rounded">
                                        @if($shippings['in_place_delivery']['is_active'])
                                            <span class="btn btn-success">فعال</span>
                                            <span class="btn btn-set-deactive" data-target="in_place_delivery">غیرفعال</span>
                                        @else
                                            <span class="btn btn-set-active" data-target="in_place_delivery">فعال</span>
                                            <span class="btn btn-danger">غیرفعال</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('bottom')
    <div class="modal fade" id="editInPlaceShippingModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="in_place_delivery" method="post" action="{{ route('panel.options.updateShipping') }}">
                        @csrf
                        <input type="hidden" name="type" value="in_place_delivery">
                        <input type="hidden" name="is_active" value="{{ $shippings['in_place_delivery']['is_active'] ?? false }}">
                        <h3 class="text-secondary pb-3 border-bottom">ویرایش روش ارسال</h3>
                        <div class="row">
                            <div class="col-6 p-3 mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" {{ $shippings['in_place_delivery']['in_city'] ? 'checked' : '' }}
                                    class="custom-control-input" name="in_city" id="in_city">
                                    <label class="custom-control-label" for="in_city">فقط در شهر فروشگاه</label>
                                </div>
                            </div>
                            <div class="col-6 p-3 mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" {{ $shippings['in_place_delivery']['in_province'] ? 'checked' : '' }}
                                    name="in_province" class="custom-control-input" id="in_province">
                                    <label class="custom-control-label" for="in_province">فقط در استان فروشگاه</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-lg btn-block btn-primary">ذخیره</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-lg btn-block btn-secondary" data-dismiss="modal">بستن</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editBikeShippingModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="bike_shipping" method="post" action="{{ route('panel.options.updateShipping') }}">
                        @csrf
                        <input type="hidden" name="type" value="bike_shipping">
                        <input type="hidden" name="is_active" value="{{ $shippings['bike_shipping']['is_active'] ?? false }}">
                        <h3 class="text-secondary pb-3 border-bottom">ویرایش روش ارسال</h3>
                        <div class="row">
                            <div class="col-12 p-3 mb-3 text-center">
                                <label for="price">قیمت برای شهر فروشگاه</label>
                                <div class="input-group">
                                    <input type="number" name="price" id="price" class="form-control"
                                           value="{{ $shippings['bike_shipping']['price'] }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">تومان</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-lg btn-block btn-primary">ذخیره</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-lg btn-block btn-secondary" data-dismiss="modal">بستن</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editPostShippingModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="post_shipping" method="post" action="{{ route('panel.options.updateShipping') }}">
                        @csrf
                        <input type="hidden" name="type" value="post_shipping">
                        <input type="hidden" name="is_active" value="{{ $shippings['post_shipping']['is_active'] ?? false }}">
                        <h3 class="text-secondary pb-3 border-bottom">ویرایش روش ارسال</h3>
                        <div class="row">
                            <div class="col-6 p-3 mb-3 text-center">
                                <label for="province_price">قیمت برای استان</label>
                                <div class="input-group">
                                    <input type="number" name="province_price" id="province_price" class="form-control"
                                           value="{{ $shippings['post_shipping']['province_price'] }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">تومان</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-3 mb-3 text-center">
                                <label for="other_provinces_price">قیمت برای شهرهای دیگر</label>
                                <div class="input-group">
                                    <input type="number" name="other_provinces_price" id="other_provinces_price" class="form-control"
                                           value="{{ $shippings['post_shipping']['other_provinces_price'] }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">تومان</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-lg btn-block btn-primary">ذخیره</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-lg btn-block btn-secondary" data-dismiss="modal">بستن</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editFreeShippingModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="free_shipping" method="post" action="{{ route('panel.options.updateShipping') }}">
                        @csrf
                        <input type="hidden" name="type" value="free_shipping">
                        <input type="hidden" name="is_active" value="{{ $shippings['free_shipping']['is_active'] ?? false }}">
                        <h3 class="text-secondary pb-3 border-bottom">ویرایش روش ارسال</h3>
                        <p>حداقل مبلغ سبد خرید، برای رایگان شدن هزینه ارسال را به تومان، در بخش زیر وارد کنید</p>
                        <div class="row">
                            <div class="col-6 mb-4 text-center">
                                <label for="province_min_order_price">قیمت برای استان</label>
                                <div class="input-group">
                                    <input type="number" name="province_min_order_price" id="province_min_order_price" class="form-control"
                                           value="{{ $shippings['free_shipping']['province_min_order_price'] }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">تومان</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mb-4 text-center">
                                <label for="all_min_order_price">قیمت برای شهرهای دیگر</label>
                                <div class="input-group">
                                    <input type="number" name="all_min_order_price" id="all_min_order_price" class="form-control"
                                           value="{{ $shippings['free_shipping']['all_min_order_price'] }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">تومان</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <div class="custom-control custom-checkbox ">
                                    <input type="checkbox" {{ $shippings['free_shipping']['all_cities'] ? 'checked' : '' }}
                                           class="custom-control-input" name="all_cities" id="all_cities">
                                    <label class="custom-control-label" for="all_cities">ارسال رایگان برای همه شهرها</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" {{ $shippings['free_shipping']['show_other_shipping'] ? 'checked' : '' }}
                                    class="custom-control-input" name="show_other_shipping" id="show_other_shipping">
                                    <label class="custom-control-label" for="show_other_shipping">نمایش دیگر روش های ارسال هنگام رایگان شدن</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-lg btn-block btn-primary">ذخیره</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-lg btn-block btn-secondary" data-dismiss="modal">بستن</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        var options = {
            height: 200,
            customConfig: "{{ asset('vendor/ckeditor/config_simple.js') }}",
        };
        CKEDITOR.replace('description', options);
        $('body').on('change','#logo_input',function () {
            if($(this).val()) {
                $('#updateLogoForm').submit();
            }
        }).on('change','#footer_logo_input',function () {
            if($(this).val()) {
                $('#updateFooterLogoForm').submit();
            }
        }).on('change','#favicon_input',function () {
            if($(this).val()) {
                $('#updateFaviconForm').submit();
            }
        }).on('change','#province',function () {
            getProvinceCities($(this).val());
        }).on('click','.btn-set-active',function () {
            let target = $(this).data('target');
            let form = $(`form.${target}`);
            form.find('input[name=is_active]').val(1);
            form.submit();
        }).on('click','.btn-set-deactive',function () {
            let target = $(this).data('target');
            let form = $(`form.${target}`);
            form.find('input[name=is_active]').val(0);
            form.submit();
        });

        function getProvinceCities(province) {
            $.get( "/api/cities", { province_id: province } )
                .done(function(data){
                    $('#city').html('');
                    for (var key in data) {
                        // skip loop if the property is from prototype
                        if (!data.hasOwnProperty(key)) continue;
                        var city = data[key];
                        var o = new Option(city.name, city.id);
                        $("#city").append(o);
                    }
                    @if($selected_city)
                        $('#city').val({{ $selected_city['id'] }});
                    @endif
                    $('#city').selectpicker('refresh');
                });
        }

    </script>
@endsection
