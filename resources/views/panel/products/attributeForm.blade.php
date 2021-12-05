@if($attribute ?? false)
    <div id="product_attribute_form_{{$attribute->id}}" class="shadow-hover my-2 p-2">
        <div class="row">
            <div class="col-12 col-lg-7 form-group">
                <label for="attribute_values_{{$attribute->id}}">{{ $attribute->title }}</label>
                <select id="attribute-select-picker-{{ $attribute->id }}" multiple data-actions-box="true"
                        class="selectpicker form-control"
                         name="attributes[{{$attribute->id}}][values][]" data-live-search="true">
                    @foreach($attribute->items as $item)
                        @if(!empty($values))
                            <option value="{{ $item->id }}" {{in_array($item->id, $values) ? 'selected' : ''}}>{{$item->title}}</option>
                        @else
                            <option value="{{ $item->id }}">{{$item->title}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-lg-5">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input {{ ($visibility ?? true) ? 'checked' : '' }} type="checkbox" name="attributes[{{$attribute->id}}][visibility]"
                               class="custom-control-input" id="attribute_visibility[{{ $attribute->id }}]">
                        <label class="custom-control-label" for="attribute_visibility[{{ $attribute->id }}]">نمایش در برگه محصول</label>
                    </div>
                </div>
                <div class="form-group variable-product-only">
                    <div class="custom-control custom-checkbox">
                        <input {{ ($variation ?? false) ? 'checked' : '' }} type="checkbox" name="attributes[{{$attribute->id}}][variation]"
                               data-attribute-id="{{ $attribute->id }}"
                               class="custom-control-input attribute_variation" id="attribute_variation[{{ $attribute->id }}]">
                        <label class="custom-control-label" for="attribute_variation[{{ $attribute->id }}]">استفاده برای متغیرها</label>
                    </div>
                </div>

                <button type="button" data-attribute-id="{{ $attribute->id }}"
                        class="btn btn-sm btn-light add_attribute_value">افزودن مقدار</button>
                <button type="button" data-attribute-id="{{ $attribute->id }}"
                        class="btn btn-sm btn-light text-tomato remove_attribute_form"><i class="fa fa-trash-alt"></i></button>
            </div>
        </div>
    </div>
@endif
