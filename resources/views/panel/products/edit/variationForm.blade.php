@if($variation ?? false)
    <div class="accordion" id="product_variation_form">
        <form method="post" action="{{ route('panel.products.variations.update',$product) }}">
            @csrf
            @method('put')
            <input type="hidden" name="variation_id" value="{{ $variation->id }}">
            <div class="{{ in_array($variation->id, $invalid_variations->pluck('id')->toArray()) ? 'bg-light' : 'bg-white' }}" id="variation-form-{{$variation->id}}">
                <div class="border p-2" id="heading-variation{{ $variation->id }}">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            @foreach($variation->attributes as $attribute)
                                <select required name="attributes[{{$attribute->id}}]">
                                    <option value="">{{$attribute->title}}</option>
                                    @foreach($attribute->items as $item)
                                        <option {{ in_array($item->id,$variation->conditions) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            @endforeach
                            <span>موجودی: {{ $variation->stock }}</span>
                                @if(in_array($variation->id, $invalid_variations->pluck('id')->toArray()))
                                    <strong class="text-danger">(نامعتبر)</strong>
                                @endif
                        </div>
                        <div>
                            <button class="btn btn-sm"
                                    type="button" data-toggle="collapse"
                                    data-target="#collapse-variation-{{ $variation->id }}"
                                    aria-expanded="false"
                                    aria-controls="collapse-variation-{{ $variation->id }}">
                                <i class="fa fa-angle-down"></i>
                            </button>
                            <button onclick="removeVariation({{ $variation->id }})" class="btn btn-sm btn-link text-danger"
                                    type="button">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="collapse-variation-{{ $variation->id }}" class="collapse"
                     aria-labelledby="heading-variation-{{ $variation->id }}">
                    <div class="p-3 border">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="regular_price-{{$variation->id}}">قیمت اصلی</label>
                                    <div class="input-group">
                                        <input type="number" required
                                               autocomplete="off" class="form-control"
                                               value="{{ $variation->regular_price }}"
                                               id="regular_price-{{$variation->id}}"
                                               name="regular_price">
                                        <div class="input-group-append">
                                            <span class="input-group-text">تومان</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="sale_price-{{$variation->id}}">قیمت فروش فوق العاده</label>
                                    <div class="input-group align-items-start">
                                        <input type="number"
                                               autocomplete="off" class="form-control"
                                               value="{{ $variation->sale_price }}"
                                               id="sale_price-{{$variation->id}}"
                                               name="sale_price">
                                        <div class="input-group-append">
                                            <span class="input-group-text">تومان</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="sku-{{$variation->id}}">کد محصول</label>
                                    <input type="text" class="form-control"
                                           autocomplete="off"
                                           value="{{ $variation->sku }}"
                                           id="sku-{{$variation->id}}"
                                           name="sku">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="weight-{{$variation->id}}">وزن محصول</label>
                                    <div class="input-group">
                                        <input type="number"
                                               autocomplete="off" class="form-control"
                                               id="weight-{{$variation->id}}"
                                               value="{{ $variation->weight }}"
                                               name="weight">
                                        <div class="input-group-append">
                                            <span class="input-group-text">گرم</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="stock-{{$variation->id}}">موجودی</label>
                                    <input type="text" id="stock-{{$variation->id}}"
                                           class="form-control" required
                                           autocomplete="off"
                                           value="{{ $variation->stock }}"
                                           name="stock">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="stock_status-{{$variation->id}}">وضعیت انبار</label>
                                    <select name="stock_status" class="selectpicker form-control" id="stock_status-{{$variation->id}}">
                                        <option {{$variation->stock_status == 'instock' ? 'selected' : ''}} value="instock">موجود در انبار</option>
                                        <option {{$variation->stock_status == 'outofstock' ? 'selected' : ''}} value="outofstock">در انبار موجود نمی باشد</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               {{ $variation->manage_stock ? 'checked' : '' }}
                                               name="manage_stock"
                                               class="custom-control-input"
                                               id="manage_stock-{{$variation->id}}">
                                        <label class="custom-control-label" for="manage_stock-{{$variation->id}}">فعال کردن مدیریت موجودی انبار</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">ذخیره</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form class="d-none" id="deleteVariationForm-{{ $variation->id }}" method="post" action="{{ route('panel.products.variations.destroy',$product) }}">
            @csrf
            @method('delete')
            <input type="hidden" name="variation_id" value="{{ $variation->id }}">
        </form>
    </div>
@endif
