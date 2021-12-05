@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'سبد خرید',
        'description' => getOption('site_information.description',config('settings.description')),
        'image' => getImageSrc(getOption('site_information.logo'))
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'ثبت سفارش' }}</title>
@endsection

@section('content')
<div class="container">
    @include('components.cart.steps',['step' => 2])
    @include('components.messages')
    <div class="row">
        <div class="col-12 col-lg-4 d-none d-lg-block">
            <ul class="list-unstyled p-0 m-0">
                @foreach(Cart::content() as $cart_item)

                    <li class="p-2 bg-white d-flex shadow-sm border rounded border-gray-200 mb-2">
                        <img src="{{ getImageSrc($cart_item->model->getImage(),'product_card') }}"
                             class="img-fluid ml-2" style="width: 60px;" />
                        <div class="d-flex flex-grow-1 flex-column justify-content-between" >
                            <div>
                                <p class="m-0">{{ $cart_item->name }}</p>
                                @if($cart_item->options['vid'] ?? false)
                                    <div class="text-gray-500">
                                        @foreach($cart_item->options['attributes'] ?? [] as $item_attribute)
                                            <small class="ml-3 text-nowrap">{{$item_attribute['title'] ?? ''}} : {{ $item_attribute['value'] ?? '' }}</small>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center fa-num">
                                <span>{{ $cart_item->qty }} عدد</span>
                                <span>{{ $cart_item->subtotal() }} تومان</span>
                            </div>
                        </div>

                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-12 col-lg-8">
            <form id="submitShipping" method="post" action="{{ route('cart.submitShipping') }}">
                @csrf
                <input type="hidden" name="order_price" value="{{ Cart::total(0,0,'') }}">
                <div class="bg-white shadow-sm rounded p-3 mb-4">
                    <div class="row">
                        <div class="col-12 col-lg-4 form-group">
                            <label for="name">نام و نام خانوادگی</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" id="name" required
                                   oninvalid="this.setCustomValidity('نام و نام خانوادگی را وارد کنید')"
                                   oninput="setCustomValidity('')"
                                   value="{{ old('name') ?: (auth()->user() ? auth()->user()->name : '') }}">
                        </div>
                        <div class="col-12 col-lg-4 form-group">
                            <label for="email">آدرس ایمیل (اختیاری)</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') ?: (auth()->user() ? auth()->user()->email : '') }}">
                        </div>
                        <div class="col-12 col-lg-4 form-group">
                            <label for="mobile">شماره موبایل</label>
                            <input type="text" class="form-control @error('mobile') is-invalid @enderror"
                                   name="mobile" id="mobile" required
                                   oninvalid="this.setCustomValidity('شماره موبایل را وارد کنید')"
                                   oninput="setCustomValidity('')"
                                   value="{{ old('mobile') ?: (auth()->user() ? auth()->user()->mobile : '') }}">
                        </div>
                        <div class="col-12 col-lg-4 form-group">
                            <label for="province">استان</label>
                            <select title="انتخاب استان" data-live-search="true" required
                                    oninvalid="this.setCustomValidity('استان را انتخاب کنید')"
                                    onchange="setCustomValidity('')"
                                    class="form-control selectpicker @error('province') is-invalid @enderror"
                                    name="province" id="province">
                                <option value="">انتخاب استان</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province['name'] }}" {{ old('province') == $province['name'] ? 'selected' : '' }}>
                                        {{ $province['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-4 form-group">
                            <label for="city">شهر</label>
                            <input list="cities" class="form-control @error('city') is-invalid @enderror"
                                   value="{{ old('city') }}"
                                   name="city" required id="city" title="انتخاب شهر"
                                   oninvalid="this.setCustomValidity('شهر را انتخاب کنید')"
                                   onchange="setCustomValidity('')">
                            <datalist id="cities">
                            </datalist>
                        </div>
                        <div class="col-12 col-lg-4 form-group">
                            <label for="postal_code">کد پستی</label>
                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                   oninvalid="this.setCustomValidity('کد پستی را وارد کنید')"
                                   oninput="setCustomValidity('')" name="postal_code" id="postal_code">
                        </div>
                        <div class="col-12 form-group">
                            <label for="address">آدرس</label>
                            <textarea type="text" class="form-control @error('address') is-invalid @enderror" required
                                  rows="4"
                                  oninvalid="this.setCustomValidity('آدرس را وارد کنید')"
                                  oninput="setCustomValidity('')"
                                      placeholder="آدرس خود را به صورت کامل وارد کنید"
                                  name="address" id="address">{{ old('address') }}</textarea>
                        </div>
                        <div class="col-12 form-group">
                            <label for="description">توضیحات (اختیاری)</label>
                            <textarea type="text" class="form-control @error('description') is-invalid @enderror"
                                   placeholder="در صورت نیاز توضیحات مربوط به سفارش را وارد کنید"
                                      name="description" id="description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <h5 class="text-secondary">انتخاب روش ارسال</h5>
                <div class="bg-white shadow-sm rounded p-3">
                    <div id="available_shippings">
                    </div>
                    <div id="select_address" class="text-center py-4 text-gray-400">
                        <h5>لطفا استان و شهر خود را انتخاب کنید</h5>
                    </div>
                </div>
                <div class="d-flex flex-wrap justify-content-between align-items-center mt-4">
                    <a class="btn btn-secondary" href="{{ route('cart.show') }}">
                        <i class="far fa-angle-right ml-2"></i>
                        سبد خرید
                    </a>
                    <button type="submit" class="btn btn-primary">
                        اطلاعات پرداخت
                        <i class="far fa-angle-left mr-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>

        $('body').on('change','#province',function () {
            getProvinceCities();
            getShippings();
        }).on('change','#city',function () {
            getShippings();
        });

        function selectShipping() {
            $('input[name=shipping]').each(function(index, item){
                if($(item).data('price') == 0) {
                    $(item).attr('checked','true');
                }
            })
        }
        function getShippings() {
            $('#available_shippings').html('').addClass('d-none');
            let order_price = $('input[name=order_price]').val();
            let province = $('#province').val();
            let city = $('#city').val();
            if(!city || !province) {
                $('#select_address').removeClass('d-none');
                return ;
            } else {
                $('#select_address').addClass('d-none');
            }
            $.get( "{{ route('shippings') }}", { order_price, province, city, render: true } )
                .done(function(data){
                    $('#available_shippings').html(data).removeClass('d-none');
                    selectShipping();
                });
        }

        $('document').ready(function() {
            getProvinceCities();
        })

        function getProvinceCities() {
            let province = $('#province').val();
            if(province) {
                $.get( "{{ route('cities') }}", { province: province } )
                    .done(function(data){
                        $('#cities').html('');
                        for (var key in data) {
                            if (!data.hasOwnProperty(key)) continue;
                            var city = data[key];
                            var o = new Option(city.name);
                            $("#cities").append(o);
                        }
                    });
            }
        }

    </script>
@endsection
