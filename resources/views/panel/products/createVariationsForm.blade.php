@if($variations ?? false)
    <div class="accordion" id="product_variation_form">
        @for($i = 0; $i < $total_forms ?? 0; $i++ )
            @php
                $selected_variation = null;
                if($variation_data ?? false) {
                    if(is_array($variation_data)) {
                        if(array_key_exists($i,$variation_data)) {
                            $selected_variation = $variation_data[$i];
                        }
                    }
                }
            @endphp
            <div class="bg-white" id="variation-form-{{$i}}">
                <div class="border p-2" id="heading-variation{{ $i }}">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            @php
                                $division = $total_forms ?? 1;
                            @endphp
                            @foreach($variations as $key1 => $inner_variation)
                                @php($division = $division/(count($inner_variation['values'] ?? [1]) > 0 ? count($inner_variation['values'] ?? [1]) : 1))
                                <select name="variations[{{$i}}][conditions][]">
                                    <option value="">{{$inner_variation['attribute']->title}}</option>
                                    @foreach($inner_variation['values'] as  $key2 => $value)
                                        <option {{ ($key2) == (floor(($i)/$division)%count($inner_variation['values'])) ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->title }}</option>
                                    @endforeach
                                </select>
                            @endforeach
                        </div>
                        <div>
                            <button class="btn btn-sm"
                                    type="button" data-toggle="collapse"
                                    data-target="#collapse-variation-{{ $i }}"
                                    aria-expanded="false"
                                    aria-controls="collapse-variation-{{ $i }}">
                                <i class="fa fa-angle-down"></i>
                            </button>
                            <button class="btn btn-sm btn-link text-danger remove-variation-form"
                                    data-variation-id="{{ $i }}"
                                    type="button">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="collapse-variation-{{ $i }}" class="collapse"
                     aria-labelledby="heading-variation-{{ $i }}"
                     data-parent="#product_variation_form">
                    <div class="p-3 border">

                        <div class="form-group row">
                            <label class="col-12 col-lg-4" for="regular_price-{{$i}}">قیمت اصلی</label>
                            <div class="input-group col-12 col-lg-8">
                                <input type="number" class="form-control" value="{{ $default_regular_price ?? '' }}"
                                       id="regular_price-{{$i}}" name="variations[{{$i}}][regular_price]">
                                <div class="input-group-append">
                                    <span class="input-group-text">تومان</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-lg-4" for="sale_price-{{$i}}">قیمت فروش فوق العاده</label>
                            <div class="input-group col-12 col-lg-8 align-items-start">
                                <input type="number" class="form-control" value="{{ $default_sale_price ?? '' }}"
                                       id="sale_price-{{$i}}" name="variations[{{$i}}][sale_price]">
                                <div class="input-group-append">
                                    <span class="input-group-text">تومان</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-lg-4" for="sku-{{$i}}">کد محصول</label>
                            <div class="col-12 col-lg-8">
                                <input type="text" class="form-control"
                                       id="sku-{{$i}}" name="variations[{{$i}}][sku]">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-lg-4" for="weight-{{$i}}">وزن محصول</label>
                            <div class="input-group col-12 col-lg-8">
                                <input type="number" class="form-control"
                                       id="weight-{{$i}}" name="variations[{{$i}}][weight]">
                                <div class="input-group-append">
                                    <span class="input-group-text">گرم</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-lg-4" for="manage_stock-{{$i}}">مدیریت موجودی؟</label>
                            <div class="col-12 col-lg-8">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="variations[{{$i}}][manage_stock]" class="custom-control-input"
                                           id="manage_stock-{{$i}}">
                                    <label class="custom-control-label" for="manage_stock-{{$i}}">فعال کردن مدیریت موجودی انبار</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-lg-4" for="stock-{{$i}}">موجودی</label>
                            <div class="col-12 col-lg-8">
                                <input type="text" id="stock-{{$i}}" class="form-control" name="variations[{{$i}}][stock]">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-lg-4" for="stock_status-{{$i}}">وضعیت انبار</label>
                            <div class="col-12 col-lg-8">
                                <select name="variations[{{$i}}][stock_status]" class="selectpicker" id="stock_status-{{$i}}">
                                    <option value="instock">موجود در انبار</option>
                                    <option value="outofstock">در انبار موجود نمی باشد</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endfor
    </div>
@endif
