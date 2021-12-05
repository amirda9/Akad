@if($current_product ?? false)
    @foreach($current_product->variations as $product_variation)
        <div class="accordion" id="product_variation_form">
            <div class="bg-white" id="variation-form-{{$product_variation->id}}">
                <div class="border p-2" id="heading-variation{{ $product_variation->id }}">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            @foreach($current_product->variation_attributes as $current_product_attribute)
                                <select name="variations[{{$product_variation->id}}][conditions][]">
                                    <option value="">{{$current_product_attribute->title}}</option>
                                    @foreach($current_product_attribute->pivot->items as $current_product_attribute_item)
                                        <option {{ in_array($current_product_attribute_item->id,$product_variation->conditions) ? 'selected' : '' }} value="{{ $current_product_attribute_item->id }}">{{ $current_product_attribute_item->title }}</option>
                                    @endforeach
                                </select>
                            @endforeach
                        </div>
                        <div>
                            <button class="btn btn-sm"
                                    type="button" data-toggle="collapse"
                                    data-target="#collapse-variation-{{ $product_variation->id }}"
                                    aria-expanded="false"
                                    aria-controls="collapse-variation-{{ $product_variation->id }}">
                                <i class="fa fa-angle-down"></i>
                            </button>
                            <button class="btn btn-sm btn-link text-danger remove-variation-form"
                                    data-variation-id="{{ $product_variation->id }}"
                                    type="button">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="collapse-variation-{{ $product_variation->id }}" class="collapse"
                     aria-labelledby="heading-variation-{{ $product_variation->id }}"
                     data-parent="#product_variation_form">
                    <div class="p-3 border">

                        <div class="form-group row">
                            <label class="col-12 col-lg-4" for="regular_price-{{$product_variation->id}}">قیمت اصلی</label>
                            <div class="input-group col-12 col-lg-8">
                                <input type="number"
                                       autocomplete="off" class="form-control"
                                       value="{{ $product_variation->regular_price }}"
                                       id="regular_price-{{$product_variation->id}}"
                                       name="variations[{{$product_variation->id}}][regular_price]">
                                <div class="input-group-append">
                                    <span class="input-group-text">تومان</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-lg-4" for="sale_price-{{$product_variation->id}}">قیمت فروش فوق العاده</label>
                            <div class="input-group col-12 col-lg-8 align-items-start">
                                <input type="number"
                                       autocomplete="off" class="form-control"
                                       value="{{ $product_variation->sale_price }}"
                                       id="sale_price-{{$product_variation->id}}"
                                       name="variations[{{$product_variation->id}}][sale_price]">
                                <div class="input-group-append">
                                    <span class="input-group-text">تومان</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-lg-4" for="sku-{{$product_variation->id}}">کد محصول</label>
                            <div class="col-12 col-lg-8">
                                <input type="text" class="form-control"
                                       autocomplete="off"
                                       value="{{ $product_variation->sku }}"
                                       id="sku-{{$product_variation->id}}"
                                       name="variations[{{$product_variation->id}}][sku]">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-lg-4" for="weight-{{$product_variation->id}}">وزن محصول</label>
                            <div class="input-group col-12 col-lg-8">
                                <input type="number"
                                       autocomplete="off" class="form-control"
                                       id="weight-{{$product_variation->id}}"
                                       value="{{ $product_variation->weight }}"
                                       name="variations[{{$product_variation->id}}][weight]">
                                <div class="input-group-append">
                                    <span class="input-group-text">گرم</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-lg-4" for="manage_stock-{{$product_variation->id}}">مدیریت موجودی؟</label>
                            <div class="col-12 col-lg-8">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox"
                                           {{ $product_variation->manage_stock ? 'checked' : '' }}
                                           name="variations[{{$product_variation->id}}][manage_stock]"
                                           class="custom-control-input"
                                           id="manage_stock-{{$product_variation->id}}">
                                    <label class="custom-control-label" for="manage_stock-{{$product_variation->id}}">فعال کردن مدیریت موجودی انبار</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-lg-4" for="stock-{{$product_variation->id}}">موجودی</label>
                            <div class="col-12 col-lg-8">
                                <input type="text" id="stock-{{$product_variation->id}}"
                                       class="form-control"
                                       autocomplete="off"
                                       value="{{ $product_variation->stock }}"
                                       name="variations[{{$product_variation->id}}][stock]">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-lg-4" for="stock_status-{{$product_variation->id}}">وضعیت انبار</label>
                            <div class="col-12 col-lg-8">
                                <select name="variations[{{$product_variation->id}}][stock_status]" class="selectpicker" id="stock_status-{{$product_variation->id}}">
                                    <option {{$product_variation->stock_status == 'instock' ? 'selected' : ''}} value="instock">موجود در انبار</option>
                                    <option {{$product_variation->stock_status == 'outofstock' ? 'selected' : ''}} value="outofstock">در انبار موجود نمی باشد</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
@elseif($variations ?? false)
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
                            @foreach($variations as $inner_variation)
                                <select name="variations[{{$i}}][conditions][]">
                                    <option value="">{{$inner_variation['attribute']->title}}</option>
                                    @foreach($inner_variation['values'] as $value)
                                        <option {{ ($selected_variation['conditions'][$inner_variation['attribute']->id] ?? null) == $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->title }}</option>
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
                                <input type="number"
                                       autocomplete="off" class="form-control"
                                       id="regular_price-{{$i}}" name="variations[{{$i}}][regular_price]">
                                <div class="input-group-append">
                                    <span class="input-group-text">تومان</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-lg-4" for="sale_price-{{$i}}">قیمت فروش فوق العاده</label>
                            <div class="input-group col-12 col-lg-8 align-items-start">
                                <input type="number"
                                       autocomplete="off" class="form-control"
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
                                <input type="number"
                                       autocomplete="off" class="form-control"
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
                                <input type="text"
                                       autocomplete="off" id="stock-{{$i}}" class="form-control" name="variations[{{$i}}][stock]">
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
