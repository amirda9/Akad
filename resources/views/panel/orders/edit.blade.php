@extends('panel.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <h1 class="text-secondary m-0">ویرایش سفارش</h1>
                    <a class="btn btn-secondary" href="{{ route('panel.orders.index') }}">
                        بازگشت
                    </a>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        @include('components.messages')
                        <form method="post" action="{{ route('panel.orders.update',$order) }}">
                            @csrf
                            @method('put')
                            <div class="row">
                                @foreach($order->items as $item)
                                    <div class="col-12 col-lg-4 form-group">
                                        <div class="p-2 bg-white d-flex shadow-sm border align-items-center rounded border-gray-200 mb-3">
                                            <img src="{{ getImageSrc($item->product->getImage(),'product_card') }}"
                                                 class="img-fluid ml-2" style="width: 60px;" />
                                            <div class="d-flex flex-grow-1 flex-column">
                                                <div>
                                                    <p class="m-0">{{ $item->product->title }}</p>
                                                    <div class="my-1 text-muted"><small>{{ $item->sub_title }}</small></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" class="form-control" required name="items[{{$item->id}}][qty]" value="{{ $item->quantity }}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">عدد</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" class="form-control"
                                                                   name="items[{{$item->id}}][price]" required value="{{ $item->price }}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">تومان</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-12 col-lg-4 form-group">
                                    <label for="name">نام و نام خانوادگی</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') ?: $order->name }}">
                                </div>
                                <div class="col-12 col-lg-4 form-group">
                                    <label for="email">آدرس ایمیل</label>
                                    <input type="text" class="form-control" name="email" id="email" value="{{ old('email') ?: $order->email }}">
                                </div>
                                <div class="col-12 col-lg-4 form-group">
                                    <label for="mobile">شماره موبایل</label>
                                    <input type="text" class="form-control" name="mobile" id="mobile" value="{{ old('mobile') ?: $order->mobile }}">
                                </div>
                                <div class="col-12 col-lg-4 form-group">
                                    <label for="province">استان</label>
                                    <select title="انتخاب استان" data-live-search="true"
                                            class="form-control selectpicker"
                                            name="province" id="province">
                                        @foreach($provinces as $province)
                                            <option value="{{ $province['name'] }}" {{ old('province') ? (old('province') == $province['name'] ? 'selected' : '') : (($order->getProvince()['name'] == $province['name']) ? 'selected' : '') }}>
                                                {{ $province['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-4 form-group">
                                    <label for="city">شهر</label>
                                    <input list="cities" class="form-control @error('city') is-invalid @enderror"
                                           value="{{ old('city') ?: $order->getCity()['name'] }}"
                                           name="city" required id="city" title="انتخاب شهر"
                                           oninvalid="this.setCustomValidity('شهر را انتخاب کنید')"
                                           onchange="setCustomValidity('')">
                                    <datalist id="cities">
                                        @foreach($cities as $city)
                                            <option value="{{ $city['name'] }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="col-12 col-lg-4 form-group">
                                    <label for="postal_code">کد پستی</label>
                                    <input type="text" class="form-control" name="postal_code" id="postal_code" value="{{ old('postal_code') ?: $order->postal_code }}">
                                </div>
                                <div class="col-12 col-lg-4 form-group">
                                    <label for="shipping">روش ارسال</label>
                                    <input type="text" class="form-control" name="shipping" id="shipping" value="{{ old('shipping') ?: $order->shipping }}">
                                </div>
                                <div class="col-12 col-lg-4 form-group">
                                    <label for="status">وضعیت سفارش</label>
                                    <select class="form-control selectpicker" name="status" id="status">
                                        @foreach(\App\Order::statuses() as $key => $status)
                                            <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-4 form-group">
                                    <label for="payment">روش پرداخت</label>
                                    <select class="form-control selectpicker" title="انتخاب روش پرداخت" name="payment" id="payment">
                                        <option value="">انتخاب روش پرداخت</option>
                                        @foreach(\App\Order::payments() as $key => $payment)
                                            <option value="{{ $key }}" {{ $order->payment == $key ? 'selected' : '' }}>{{ $payment['title'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-4 form-group">
                                    <label for="shipping_price">هزینه ارسال</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="shipping_price" id="shipping_price" value="{{ old('shipping_price') ?: $order->shipping_price }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">تومان</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-8 form-group">
                                    <label for="address">آدرس</label>
                                    <input type="text" class="form-control" id="address"
                                           name="address" value="{{ old('address') ?: $order->address }}">
                                </div>
                                <div class="col-12 form-group">
                                    <label for="description">توضیحات</label>
                                    <textarea class="form-control" name="description"
                                              id="description">{{ old('description') ?: $order->description }}</textarea>
                                </div>
                                <div class="col-12 form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" {{ $order->is_paid ? 'checked' : '' }} class="custom-control-input" name="is_paid" id="is_paid">
                                        <label class="custom-control-label" for="is_paid">هزینه سفارش پرداخت شده است</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" {{ $order->is_approved ? 'checked' : '' }} class="custom-control-input" name="is_approved" id="is_approved">
                                        <label class="custom-control-label" for="is_approved">سفارش مورد تایید می باشد</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">ذخیره تغییرات</button>
                            <a href="{{ route('panel.orders.index') }}" class="btn btn-secondary">بازگشت</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script>

        $('body').on('change','#province',function () {
            getProvinceCities($(this).val());
        });

        function getProvinceCities(province) {
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

    </script>
@endsection
