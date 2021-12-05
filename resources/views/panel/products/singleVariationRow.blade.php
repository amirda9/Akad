
<div class="accordion" id="product_variation_form">
        <div class="bg-white" id="variation-form-{{$index}}">
            <div class="border p-2" id="heading-variation{{ $index }}">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        @foreach($variations as $inner_variation)
                            <select name="variations[{{$index}}][conditions][]">
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
                                data-target="#collapse-variation-{{ $index }}"
                                aria-expanded="false"
                                aria-controls="collapse-variation-{{ $index }}">
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <button class="btn btn-sm btn-link text-danger remove-variation-form"
                                data-variation-id="{{ $index }}"
                                type="button">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div id="collapse-variation-{{ $index }}" class="collapse"
                 aria-labelledby="heading-variation-{{ $index }}"
                 data-parent="#product_variation_form">
                <div class="p-3 border">

                    <div class="form-group row">
                        <label class="col-12 col-lg-4" for="regular_price-{{$index}}">قیمت اصلی</label>
                        <div class="input-group col-12 col-lg-8">
                            <input type="number" class="form-control"
                                   id="regular_price-{{$index}}" name="variations[{{$index}}][regular_price]">
                            <div class="input-group-append">
                                <span class="input-group-text">تومان</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-lg-4" for="sale_price-{{$index}}">قیمت فروش فوق العاده</label>
                        <div class="input-group col-12 col-lg-8 align-items-start">
                            <input type="number" class="form-control"
                                   id="sale_price-{{$index}}" name="variations[{{$index}}][sale_price]">
                            <div class="input-group-append">
                                <span class="input-group-text">تومان</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-lg-4" for="sku-{{$index}}">کد محصول</label>
                        <div class="col-12 col-lg-8">
                            <input type="text" class="form-control"
                                   id="sku-{{$index}}" name="variations[{{$index}}][sku]">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-lg-4" for="weight-{{$index}}">وزن محصول</label>
                        <div class="input-group col-12 col-lg-8">
                            <input type="number" class="form-control"
                                   id="weight-{{$index}}" name="variations[{{$index}}][weight]">
                            <div class="input-group-append">
                                <span class="input-group-text">گرم</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-lg-4" for="manage_stock-{{$index}}">مدیریت موجودی؟</label>
                        <div class="col-12 col-lg-8">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="variations[{{$index}}][manage_stock]" class="custom-control-input"
                                       id="manage_stock-{{$index}}">
                                <label class="custom-control-label" for="manage_stock-{{$index}}">فعال کردن مدیریت موجودی انبار</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-lg-4" for="stock-{{$index}}">موجودی</label>
                        <div class="col-12 col-lg-8">
                            <input type="text" id="stock-{{$index}}" class="form-control" name="variations[{{$index}}][stock]">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-lg-4" for="stock_status-{{$index}}">وضعیت انبار</label>
                        <div class="col-12 col-lg-8">
                            <select name="variations[{{$index}}][stock_status]" class="selectpicker" id="stock_status-{{$index}}">
                                <option value="instock">موجود در انبار</option>
                                <option value="outofstock">در انبار موجود نمی باشد</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
</div>
</div>
