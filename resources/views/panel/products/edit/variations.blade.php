@extends('panel.layouts.master')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                @include('panel.products.edit.tab')
                <div class="d-flex flex-row align-items-center justify-content-between">
                    <h1 class="m-0">متغیرهای محصول <small>({{ $variations->count() }})</small></h1>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addVariationModal">
                        افزودن متغیر
                    </button>
                </div>

            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                @include('components.messages')
                <div class="card card-body">
                    <div class="mb-3">
                        <a href="{{ route('panel.products.variations.createAll',$product) }}" class="btn btn-primary">ساخت همه متغیرها</a>
                        @if($invalid_variations->count() > 0)
                            <a href="{{ route('panel.products.variations.deleteInvalids',$product) }}" onclick="return confirm('آیا مطمئن هستید؟')" class="btn btn-danger">
                                <span>حذف همه نامعتبرها</span>
                                <small>({{$invalid_variations->count()}})</small>
                            </a>
                        @endif
                    </div>
                    @foreach($variations as $variation)
                        @include('panel.products.edit.variationForm',[
                            'variation' => $variation,
                            'product' => $product,
                            'invalid_variations' => $invalid_variations,
                            'attributes' => $attributes
                        ])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom')
    <!-- Modal -->
    <div class="modal fade" id="addVariationModal" tabindex="-1" aria-labelledby="addVariationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVariationModalLabel">افزودن ویژگی</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('panel.products.variations.store',$product) }}">
                        @csrf
                        <div class="border p-2">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    @foreach($attributes as $attribute)
                                        <select title="{{ $attribute->title }}" required name="attributes[{{$attribute->id}}]">
                                            <option value="">{{$attribute->title}}</option>
                                            @foreach($attribute->pivot->items as $item)
                                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="p-3 border">
                            <div class="form-group row">
                                <label class="col-12 col-lg-4" for="regular_price">قیمت اصلی</label>
                                <div class="input-group col-12 col-lg-8">
                                    <input type="number"
                                           required
                                           autocomplete="off" class="form-control"
                                           id="regular_price"
                                           name="regular_price">
                                    <div class="input-group-append">
                                        <span class="input-group-text">تومان</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-lg-4" for="sale_price">قیمت فروش فوق العاده</label>
                                <div class="input-group col-12 col-lg-8 align-items-start">
                                    <input type="number"
                                           autocomplete="off" class="form-control"
                                           id="sale_price"
                                           name="sale_price">
                                    <div class="input-group-append">
                                        <span class="input-group-text">تومان</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-lg-4" for="sku">کد محصول</label>
                                <div class="col-12 col-lg-8">
                                    <input type="text" class="form-control"
                                           autocomplete="off"
                                           id="sku"
                                           name="sku">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-lg-4" for="weight">وزن محصول</label>
                                <div class="input-group col-12 col-lg-8">
                                    <input type="number"
                                           autocomplete="off" class="form-control"
                                           id="weight"
                                           name="weight">
                                    <div class="input-group-append">
                                        <span class="input-group-text">گرم</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-lg-4">مدیریت موجودی؟</label>
                                <div class="col-12 col-lg-8">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox"
                                               checked
                                               name="manage_stock"
                                               class="custom-control-input"
                                               id="manage_stock">
                                        <label class="custom-control-label" for="manage_stock">فعال کردن مدیریت موجودی انبار</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-lg-4" for="stock">موجودی</label>
                                <div class="col-12 col-lg-8">
                                    <input type="text" id="stock" required
                                           class="form-control"
                                           autocomplete="off"
                                           name="stock">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-lg-4" for="stock_status">وضعیت انبار</label>
                                <div class="col-12 col-lg-8">
                                    <select required name="stock_status" class="selectpicker" id="stock_status">
                                        <option value="instock">موجود در انبار</option>
                                        <option value="outofstock">در انبار موجود نمی باشد</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-success">ذخیره</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function removeVariation(id) {
            if(confirm('آیا مطمئن هستید؟')){
                $(`#deleteVariationForm-${id}`).submit();
            }
        }
    </script>
@endsection
