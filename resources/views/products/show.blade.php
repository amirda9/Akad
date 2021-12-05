@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => $product->title,
        'description' => $product->meta_description ?: ($product->short_description ?: config('settings.meta_description')),
        'url' => $product->getRoute(),
        'image' => getImageSrc($product->image)
    ])
    <meta name="product_id" content="{{ $product->id }}">
    <meta name="product_name" content="{{ $product->title }}">
    <meta name="product_image" content="{{ getImageSrc($product->image,'product_large') }}">
    <meta name="product_price" content="{{ $product->min_price }}">
    <style>
        .variation_attribute_item_btn.disabled:after {
            content: "";
            position: absolute;
            left: 3px;
            right: 3px;
            top: 50%;
            height: 2px;
            background: rgba(0,0,0,0.4);
        }
    </style>
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . ($product->meta_title ?: $product->title) }}</title>
@endsection
@section('head')
    <link rel="stylesheet" href="{{ asset('css/photoswipe-4.1.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/photoswipe-default-skin-4.1.0.min.css') }}" />
    <style>
        .open-slider {
            cursor: pointer;
        }
    </style>
@endsection

@php($product->submitViewLog())

@section('content')
<div class="container">
    @include('components.messages')
    {{ Breadcrumbs::render('product', $product) }}
    <div class="bg-white position-relative overflow-hidden shadow-sm rounded mb-4">
        @if($product->is_featured)
            <span class="featured_badge">پیشنهاد ویژه</span>
        @endif
        <div class="row no-gutters text-secondary">
            <div class="col-12 col-lg-5 p-3">
                <img class="product_image img-fluid open-slider border border-gray-200" data-index="0"
                     alt="{{ $product->title }}" title="{{ $product->title }}"
                     src="{{ getImageSrc($product->getImage(),'product_large') }}" />

                @if($product->images->count())
                    <div class="row p-2 bg-gray-100 border border-gray-200 border-top-0 m-0">
                        @if($product->images->count() > 4)
                            @foreach($product->images->take(3) as $index => $image)
                                <div class="col-3 p-1">
                                    <img class="img-fluid open-slider" data-index="{{ $index+1 }}"
                                         alt="{{ $product->title }}" title="{{ $product->title }}"
                                         src="{{ getImageSrc($image->src, 'product_card') }}" />
                                </div>
                            @endforeach
                            <div class="col-3 p-1">
                                <div class="text-gray-200 open-slider d-flex align-items-center justify-content-center h-100 bg-white rounded">
                                    <i class="fa fa-ellipsis-h fa-3x"></i>
                                </div>
                            </div>
                        @else
                            @foreach($product->images as $index => $image)
                                <div class="col-3 p-1">
                                    <img class="img-fluid open-slider" data-index="{{ $index+1 }}"
                                         alt="{{ $product->title }}" title="{{ $product->title }}"
                                         src="{{ getImageSrc($image->src, 'product_card') }}" />
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>
            <div class="col-12 col-lg-7 p-3">
                <h1 class="my-3 text-dark" style="font-size: 23px;">{{ $product->title }}</h1>
                <div class="p-2 my-3 bg-light rounded-5">
                    <strong>دسته بندی :</strong>
                    @foreach($product->categories as $product_category)
                        <a target="_blank" class="ml-2 text-gray-600 text-decoration-none" href="{{ $product_category->getRoute() }}">{{ $product_category->name }}</a>
                    @endforeach
                </div>

                @if($product->short_description)
                    <div class="text-gray-600">
                        {!! $product->short_description !!}
                    </div>
                @endif
                @if($product->is_in_stock)
                    <div id="addToCartContainer">
                        @if($product->isVariable())
                            <form id="addToCartForm" method="get" action="{{ route('cart.add',$product) }}">
                                <input type="hidden" name="vid" value="">
                                <div class="my-4">
                                    @foreach($product->variation_attributes as $variation_attribute)
                                        <div class="mb-3">
                                            <strong class="d-block">{{ $variation_attribute->title }}</strong>
                                            @foreach($variation_attribute->pivot->items as $variation_attribute_item)
                                                <input id="variation_attribute_item_{{ $variation_attribute_item->id }}"
                                                       type="radio" class="d-none attribute_item"
                                                       value="{{ $variation_attribute_item->id }}"
                                                       name="attribute_{{$variation_attribute->id}}">
                                                <label for="variation_attribute_item_{{ $variation_attribute_item->id }}"
                                                       data-attribute-item="{{$variation_attribute_item->id}}"
                                                       class="btn position-relative btn-outline-purple variation_attribute_item_btn">{{ $variation_attribute_item->title }}</label>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mb-4">
                                    <div id="notAvailable" class="d-none">
                                        <h4 class="d-inline-block">ناموجود</h4>
                                        <button type="button" class="btn btn-light btn-sm mr-3 remove-filters">حذف فیلترها</button>
                                    </div>
                                    <div id="pricesContainer" class="">
                                        @if($product->min_price && $product->max_price && $product->min_price != $product->max_price)
                                            <span class="fa-num"><strong class="text-tomato" style="font-size: 30px;">{{ number_format($product->min_price) }}</strong> <span class="mx-2 text-gray" style="font-size: 30px">-</span> <strong class="text-tomato" style="font-size: 30px;">{{ number_format($product->max_price) }}</strong></span> <small>تومان</small>
                                        @elseif($product->min_price)
                                            <span class="fa-num"><strong class="text-tomato" style="font-size: 30px;">{{ number_format($product->min_price) }}</strong></span> <small>تومان</small>
                                        @endif
                                    </div>
                                    <div id="variationPriceContainer" class="d-none">
                                        <span class="fa-num"><strong id="variationPrice" class="text-tomato" style="font-size: 30px;"></strong></span> <small>تومان</small>
                                        <button type="button" class="btn btn-light btn-sm mr-3 remove-filters">حذف فیلترها</button>
                                    </div>

                                </div>
                                @if(!$product->sold_individually)
                                    <div class="d-inline-block ml-lg-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="input-group-btn btn btn-light border border-gray-200 increase-qty" type="button">
                                                    <i class="far fa-plus"></i>
                                                </button>
                                            </div>
                                            <input style="width: 70px;" type="number" class="bg-white form-control border-gray-200 pl-1" min="1" name="qty" value="1">
                                            <div class="input-group-prepend">
                                                <button class="input-group-btn btn btn-light border border-gray-200 decrease-qty" type="button">
                                                    <i class="far fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <button disabled type="submit" class="btn btn-success">
                                    <i class="fal fa-cart-plus" style="font-size: 14px"></i>
                                    <span class="">افزودن به سبد خرید</span>
                                </button>
                                @if ($product->product_helper != null)
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                                        راهنمای انتخاب سایز
                                    </button>
                                @endif
                            </form>
                        @endif
                        @if($product->isSimple())
                            <div class="mb-4">
                                <div id="productStockStatus" class="d-none">
                                    <h4>ناموجود</h4>
                                </div>
                                <div id="product-price-container">
                                    @if($product->regular_price)
                                        <span class="fa-num text-tomato"><strong style="font-size: 30px;">{{ number_format($product->sale_price ?: $product->regular_price) }} <small>تومان</small></strong></span>
                                        @if($product->sale_price)
                                            <del class="fa-num text-gray-500 mr-3">{{ number_format($product->regular_price) }} <small>تومان</small></del>
                                        @endif
                                    @else
                                        <span class="fa-num text-gray-500">تماس بگیرید</span>
                                    @endif
                                </div>
                            </div>
                            <form id="addToCartForm" method="get" action="{{ route('cart.add',$product) }}">
                                @if(!$product->sold_individually)
                                    <div class="d-inline-block ml-lg-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="input-group-btn btn btn-light border border-gray-200 increase-qty" type="button">
                                                    <i class="far fa-plus"></i>
                                                </button>
                                            </div>
                                            <input style="width: 70px;" type="number" class="bg-white form-control border-gray-200 pl-1" min="1" max="{{ $product->stock }}" name="qty" value="1">
                                            <div class="input-group-prepend">
                                                <button class="input-group-btn btn btn-light border border-gray-200 decrease-qty" type="button">
                                                    <i class="far fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <button type="submit" class="btn  btn-success shadow">
                                    <i class="fal fa-cart-plus" style="font-size: 16px"></i>
                                    <span class="">افزودن به سبد خرید</span>
                                </button>
                                @if ($product->product_helper != null)
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                                        راهنمای محصول
                                    </button>
                                @endif
                            </form>
                        @endif
                    </div>
                @else
                    <div>
                        <h4>ناموجود</h4>
                        <p class="text-gray-500">متاسفانه این محصول در حال حاضر موجود نمی باشد، می توانید از محصولات مشابه این کالا دیدن کنید.</p>
                    </div>
                @endif


                @can('edit product')
                    <div class="mt-3">
                        <a class="btn btn-secondary"
                           href="{{ route('panel.products.edit',$product) }}">
                            ویرایش محصول
                        </a>
                    </div>
                @endcan

                @if($product->tags->count())
                    <div class="pt-3 border-top text-gray-500 fa-num mt-4">
                        @foreach($product->tags as $product_tag)
                            <a class="btn btn-sm btn-light text-gray-500 rounded-5 mb-1" style="min-width:75px;" href="{{ $product_tag->getRoute() }}" target="_blank">
                                {{ $product_tag->title }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
    {!! render_widget_position('top_product_full_description') !!}

    @include('products.tabsContainer',[
        'product' => $product,
        'attribute_groups' => $attribute_groups,
    ])
    {!! render_widget_position('bottom_product_full_description') !!}
    {!! render_widget_position('top_related_products') !!}
    @if($related_products->count())
        <div class="bg-white mb-4 rounded shadow-sm p-3 p-lg-4">
            <h4 class="text-secondary pb-3 border-bottom mb-4">محصولات مرتبط</h4>
            <div class="row">
                @foreach($related_products as $related_product)
                    <div class="col-6 col-lg-3 col-md-4 col-sm-6">
                        @include('components.productCard',['product' => $related_product])
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    {!! render_widget_position('bottom_related_products') !!}
    @include('products.bottom')

</div>
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">مشاهده راهنمای سایز محصول</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body overflow-auto">
        {!!$product->product_helper!!}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
        </div>
      </div>
    </div>
</div>

@endsection

@section('bottom')
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="pswp__bg"></div>
        <div class="pswp__scroll-wrap">
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <div class="pswp__counter"></div>
                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                    <button class="pswp__button pswp__button--share" title="Share"></button>
                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>
                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                </button>
                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                </button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script type="application/javascript" src="{{ asset('js/photoswipe-4.1.0.min.js') }}"></script>
    <script type="application/javascript" src="{{ asset('js/photoswipe-ui-default-4.1.0.min.js') }}"></script>
    <script>
        var loading = false;
        $('body').on('click','.increase-qty',function(){
            let qty = $('#addToCartForm').find('input[name=qty]');
            let new_val = parseInt(qty.val())+1;
            qty.val(new_val).attr('value',new_val)
        }).on('click','.decrease-qty',function(){
            let qty = $('#addToCartForm').find('input[name=qty]');
            let new_val = parseInt(qty.val())-1;
            qty.val(new_val < 1 ? 1 : new_val).attr('value',new_val < 1 ? 1 : new_val)
        }).on('click','.variation_attribute_item_btn',function() {
            if(!loading) {
                $(this).parent().find('.variation_attribute_item_btn')
                    .removeClass('btn-purple').addClass('btn-outline-purple');
                $(this).toggleClass('btn-purple btn-outline-purple');
            }
        }).on('change','.attribute_item',function() {
            getProductPrice($(this))
        }).on('click','.remove-filters',function() {
            $('.variation_attribute_item_btn').removeClass('btn-purple').addClass('btn-outline-purple');
            $('.attribute_item').prop('checked', false);
            getProductPrice()
        });

        @if($product->isVariable())
        $(document).ready(function () {
            getProductPrice();
        })
        function getProductPrice(el = null) {
            if(!loading) {
                $('.variation_attribute_item_btn').removeClass('out_of_stock');
                $('.attribute_item').removeAttr('disabled');
                $('#addToCartContainer').addClass('loading');
                loading = true;
                let items = [];
                let last_item = null;
                $('.attribute_item:checked').each(function ()  {
                    items.push($(this).val());
                });
                $('.remove-filters').addClass('d-none');
                if(items.length > 0) {
                    $('.remove-filters').removeClass('d-none');
                }
                if(!!el) {
                    last_item = el.val();
                }
                $('#productStockStatus').removeClass('d-block').addClass('d-none');
                $.post("{{ route('products.price') }}",{
                    _token: "{{ @csrf_token() }}",
                    product_id: "{{ $product->id }}",
                    items,
                    last_item
                }).done(response => {
                    $('.variation_attribute_item_btn').removeClass('disabled');
                    response.not_available_items.map(item => {
                        $('label[for="variation_attribute_item_' + item + '"]').addClass('disabled');
                    })
                    $('#addToCartForm input[name=vid]').val('');
                    $('#addToCartForm button[type=submit]').attr('disabled',true);
                    if(response.variation_id) {
                        $('#pricesContainer').addClass('d-none');
                        if(response.can_order) {
                            $('#notAvailable').addClass('d-none');
                            $('#variationPriceContainer').removeClass('d-none');
                            $('#variationPrice').text(response.formatted_price);
                            $('#addToCartForm input[name=vid]').val(response.variation_id);
                            $('#addToCartForm button[type=submit]').removeAttr('disabled');
                        } else {
                            $('#notAvailable').removeClass('d-none');
                            $('#variationPriceContainer').addClass('d-none');
                        }
                    } else {
                        $('#notAvailable').addClass('d-none');
                        $('#variationPriceContainer').addClass('d-none');
                        $('#pricesContainer').removeClass('d-none');
                    }
                    loading = false;
                    $('#addToCartContainer').removeClass('loading');
                }).fail(error => {
                    $('#addToCartForm button[type=submit]').attr('disabled',true);
                    $('#addToCartForm input[name=vid]').val('');
                    loading = false;
                    $('#addToCartContainer').removeClass('loading');
                })
            }
        }
        @endif

    </script>

    <script>
        $('body').on('click','.open-slider',function(){
            var pswpElement = document.querySelectorAll('.pswp')[0];
            var items = [
                {
                    src: "{{ getImageSrc($product->getImage(),'original') }}",
                    w: 756,
                    h: 945
                },
                @foreach($product->images as $image)
                    {
                        src: "{{ getImageSrc($image->src,'original') }}",
                        w: 756,
                        h: 945
                    },
                @endforeach
            ];
            var options = {
                index: $(this).data('index'),
                bgOpacity: 0.85
            };
            var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
        });
    </script>

    <script>
        $('body').on('click','.captcha-container',() => {
            refreshCaptcha();
        })
        function refreshCaptcha(){
            $.ajax({
                url: "{{ route('captcha.refresh') }}",
                type: 'get',
                dataType: 'html',
                success: function(json) {
                    $('.captcha-container').html(json);
                },
                error: function(data) {
                    alert('Try Again.');
                }
            });
        }
    </script>
    <script>
        $('.rateItemButton').mouseenter(function(){
            var value = $(this).data('value');
            $(this).parent().find('.rateItemButton').each(function() {
                if($(this).data('value') > value) {
                    $(this).removeClass('fas').addClass('far');
                } else {
                    $(this).addClass('fas').removeClass('far');
                }
            });
        })

        $('.rateItemButton').mouseout(function(){
            value = $(this).parent().find('input[type="hidden"]').val();
            $(this).parent().find('.rateItemButton').each(function() {
                if($(this).data('value') > value) {
                    $(this).removeClass('fas').addClass('far');
                } else {
                    $(this).addClass('fas').removeClass('far');
                }
            });
        })

        $('.rateItemButton').click(function(){
            if(loading ==false) {
                loading = true;
                var value = $(this).data('value');
                var form = $(this).closest('form');

                form.find('input[name="rate"]').val(value);

                var url = form.attr('action');
                $.post(url, form.serialize()).done(function( data ) {
                    loading = false;
                    $.toast({
                        heading: 'پیام',
                        text: 'امتیاز شما با موفقیت ثبت شد',
                        icon: 'info',
                        loader: true,
                        bgColor: '#1f9944',
                        loaderBg: '#fff'
                    })
                    $('#productRateContainer .rateResult').width(`${data.rate/5*100}%`);
                }).fail(function( data ) {
                    loading = false;
                    $.toast({
                        heading: 'خطا',
                        text: 'خطا در ثبت امتیاز',
                        icon: 'error',
                        loader: true,
                        bgColor: '#991f1f',
                        loaderBg: '#fff'
                    })
                    console.log('error');
                });
            }
        })


    </script>

@endsection
