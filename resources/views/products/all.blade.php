@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')),
        'description' => config('settings.meta_description'),
        'url' => route('products.all')
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) . ' | ' . 'لیست همه محصولات' }}</title>
@endsection
@section('content')
    <div class="container">
        {{ Breadcrumbs::render('products.all') }}
        <div class="row">
            <div class="col-12 col-lg-3 mb-3 mb-lg-0">
                <form id="filters" class="position-sticky sticky-top" style="top: 55px;" method="GET" enctype="multipart/form-data">
                    <input type="hidden" id="orderby-input" name="orderBy" value="{{ request('orderBy') }}">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-gray-50">
                            <h6 class="m-0 text-secondary">جستجو</h6>
                        </div>
                        <div class="p-3">
                            <div class="custom-search-input">
                                <i class="fa fa-search"></i>
                                <input type="text" value="{{ request('product_name') }}" name="product_name" placeholder="نام محصول مورد نظر را بنویسید">
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-gray-50 d-flex align-items-center collapse-with-rotate"
                             data-toggle="collapse" data-target="#other-filter-container"
                             aria-expanded="false" aria-controls="other-filter-container">
                            <h6 class="m-0 text-secondary flex-grow-1">فیلترها</h6>
                            <span>
                                <i class="fal fa-angle-down rotate" style="font-size:22px;" data-rotate="rotate-180"></i>
                            </span>
                        </div>
                        <div id="other-filter-container" class="collapse">
                            <div class="p-3">
                                <div class="custom-control custom-checkbox text-secondary mb-2">
                                    <input type="checkbox" class="custom-control-input select-other-filter"
                                           {{ request()->filled('featured') ? 'checked' : '' }}
                                           name="featured" id="featured">
                                    <label class="custom-control-label" for="featured">محصولات ویژه</label>
                                </div>
                            </div>
                        </div>
                    </div>


                    @if($brands->count())
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-gray-50 d-flex align-items-center collapse-with-rotate"
                                 data-toggle="collapse" data-target="#brands-filter-container"
                                 aria-expanded="false" aria-controls="brands-filter-container">
                                <h6 class="m-0 text-secondary flex-grow-1">برندها</h6>
                                <span>
                                <i class="fal fa-angle-down rotate" style="font-size:22px;" data-rotate="rotate-180"></i>
                            </span>
                            </div>
                            <div id="brands-filter-container" class="collapse" style="max-height: 400px; overflow-y:scroll">
                                <div class="p-3">
                                    @foreach($brands as $brand)
                                        <div class="custom-control custom-checkbox text-secondary mb-2">
                                            <input type="checkbox" class="custom-control-input d-flex flex-row select-brands-filter"
                                                   value="{{ $brand->id }}"
                                                   {{ in_array($brand->id, request()->get('brands') ?: []) ? 'checked' : '' }}
                                                   name="brands[]" id="brand_{{ $brand->id }}">
                                            <label class="custom-control-label d-flex flex-grow-1 justify-content-between" for="brand_{{ $brand->id }}">
                                                <span>{{ $brand->name }}</span>
                                                @if($brand->en_name)
                                                    <span>{{ $brand->en_name }}</span>
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @foreach($attributes as $attribute)
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-gray-50 d-flex align-items-center collapse-with-rotate"
                                 data-toggle="collapse" data-target="#attribute-filter-container-{{ $attribute->id }}"
                                 aria-expanded="false" aria-controls="attribute-filter-container-{{ $attribute->id }}">
                                <h6 class="m-0 text-secondary flex-grow-1">{{ $attribute->title }}</h6>
                                <span>
                                <i class="fal fa-angle-down rotate" style="font-size:22px;" data-rotate="rotate-180"></i>
                            </span>
                            </div>
                            <div id="attribute-filter-container-{{ $attribute->id }}" class="collapse">
                                <div class="p-3">
                                    @foreach($attribute->items as $attribute_item)
                                        <div class="custom-control custom-checkbox text-secondary mb-2">
                                            <input type="checkbox" class="custom-control-input select-other-filter"
                                                   value="{{ $attribute_item->id }}"
                                                   {{ in_array($attribute_item->id, request()->get('attributes') ?: []) ? 'checked' : '' }}
                                                   name="attributes[]" id="attribute_item_{{ $attribute_item->id }}">
                                            <label class="custom-control-label" for="attribute_item_{{ $attribute_item->id }}">{{ $attribute_item->title }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-gray-50 d-flex align-items-center collapse-with-rotate"
                             data-toggle="collapse" data-target="#price-filter-container"
                             aria-expanded="false" aria-controls="price-filter-container">
                            <h6 class="m-0 text-secondary flex-grow-1">محدوده قیمت</h6>
                            <span>
                                <i class="fal fa-angle-down rotate" style="font-size:22px;" data-rotate="rotate-180"></i>
                            </span>
                        </div>
                        <div id="price-filter-container" class="collapse">
                            <div class="p-4">
                                <div id="priceSlider"></div>
                                <input type="hidden" name="max_price" id="max_price" value="{{ request('max_price') ?: $max_price }}">
                                <input type="hidden" name="min_price" id="min_price" value="{{ request('min_price') ?: 0 }}">
                            </div>
                            <div class="d-flex border-top border-bottom">
                                <div class="flex-grow-1 p-2 border-right d-flex flex-column align-items-center text-gray-500">
                                    <span>از قیمت</span>
                                    <span id="min_price_holder" class="fa-num d-inline-block px-2 py-1 bg-light rounded text-secondary text-center my-2" style="min-width:100px;">
                                        ---
                                    </span>
                                    <span>
                                        تومان
                                    </span>
                                </div>
                                <div class="flex-grow-1 p-2 border-right d-flex flex-column align-items-center text-gray-500">
                                    <span>تا قیمت</span>
                                    <span id="max_price_holder" class="fa-num d-inline-block px-2 py-1 bg-light rounded text-secondary text-center my-2" style="min-width:100px;">
                                        ---
                                    </span>
                                    <span>
                                        تومان
                                    </span>
                                </div>
                            </div>
                            <div class="p-3 text-center">
                                <button class="btn btn-primary btn-sm">
                                    <i class="fa fa-filter ml-2" style="font-siz:16px;"></i>
                                    <span class="flex-grow-1">
                                        اعمال محدوده قیمت
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-12 col-lg-9">
                <div class="bg-white border border-gray-200">
                    <div class="d-flex justify-content-between p-3 border-bottom border-gray-200" style="font-size:13px;">
                        <div class="">
                            <span class="text-gray-600">
                                <i class="far fa-sort text-gray-500"></i>
                                مرتب سازی بر اساس :
                            </span>
                            <a href="javascript:" class="products-order-btn btn btn-sm btn-light {{ request('orderBy') ? (request('orderBy') == 'latest' ? 'active' : '') : 'active'  }}" data-orderby="latest">جدیدترین</a>
                            <a href="javascript:" class="products-order-btn btn btn-sm btn-light {{ request('orderBy') ? (request('orderBy') == 'oldest' ? 'active' : '') : ''  }}" data-orderby="oldest">قدیمی ترین</a>
                            <a href="javascript:" class="products-order-btn btn btn-sm btn-light {{ request('orderBy') ? (request('orderBy') == 'lcost' ? 'active' : '') : ''  }}" data-orderby="lcost">ارزان ترین</a>
                            <a href="javascript:" class="products-order-btn btn btn-sm btn-light {{ request('orderBy') ? (request('orderBy') == 'hcost' ? 'active' : '') : ''  }}" data-orderby="hcost">گران ترین</a>
                        </div>
                        <span class="fa-num text-gray-500">
                            {{ number_format($products->total())}} محصول
                        </span>
                    </div>
                    @if($products->count())
                        <div class="products-container p-0">
                            <div class="row no-gutters" style="margin-left: -1px;">
                                @foreach($products as $product)
                                    <div class="col-6 col-lg-3 col-md-4 col-sm-6 d-flex">
                                        @include('components.productCard2',[
                                            'product' => $product
                                        ])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    <div class="mt-3 px-3 overflow-auto">
                        {{ $products->links() }}
                    </div>
                    @else
                        @include('components.empty')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/nouislider.min.js') }}"></script>
    <script>

        $('.products-order-btn').click(function(){
            $('#orderby-input').val($(this).data('orderby'));
            $('#filters').submit();
        })

        $('.select-other-filter').change(function(){
            $('#filters').submit();
        })

        $('.select-brands-filter').change(function(){
            $('#filters').submit();
        })

        var slider = document.getElementById('priceSlider');
        var snapValues = [
            document.getElementById('min_price_holder'),
            document.getElementById('max_price_holder')
        ];
        noUiSlider.create(slider, {
            start: [{{ request('min_price') ?: 0}}, {{ request('max_price') ?: $max_price }}],
            connect: true,
            direction: 'rtl',
            step: {{ round(($max_price - $min_price) / 20) }},
            range: {
                'min': 0,
                'max': {{ $max_price }}
            }
        });
        slider.noUiSlider.on('update', function (values, handle) {
            snapValues[handle].innerHTML = (parseInt(values[handle])).toFixed(0).replace(/./g, function(c, i, a) {
                return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
            });
            if(handle == 0) {
                $('#min_price').val(parseInt(values[handle]));
            } else {
                $('#max_price').val(parseInt(values[handle]));
            }
        });
    </script>
@endsection
