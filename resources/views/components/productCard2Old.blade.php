@if($product)
    <div class="w-100 overflow-hidden shadow-md-hover d-flex">
        <div class="position-relative border border-top-0 border-gray-200 d-flex flex-column flex-grow-1"
             style="margin-right: -1px;">
            @if($product->is_featured)
                <span class="featured_badge">پیشنهاد ویژه</span>
            @endif
            @if($product->hasDiscount())
                <span class="discount_badge">{{ $product->getDiscountText() }}</span>
            @endif
            <a href="{{ $product->getRoute() }}" class="d-block text-center p-2">
                <img class="img-fluid"
                     src="{{ getImageSrc($product->getImage(),'product_card') }}"
                     alt="{{ $product->title }}" />
            </a>
            <div class="p-2 px-lg-3 d-flex flex-column flex-grow-1">
                <a class="d-block mb-2 mb-lg-3 flex-grow-1 text-secondary text-decoration-none" href="{{ $product->getRoute() }}">
                    {{ $product->title }}
                </a>
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    @if($product->is_in_stock)
                        @if($product->isSimple())
                            <a class="bg-primary px-2 px-lg-3 py-1 text-white text-decoration-none rounded" href="{{ route('cart.add',$product) }}">
                                <i class="fal fa-cart-plus"></i>
                            </a>
                            <div class="fa-num">
                                @if($product->regular_price)
                                    <div class="d-flex flex-column text-left">
                                        <div class="text-success" style="font-size: 18px; line-height: 1.2;">
                                            <strong>{{ number_format($product->sale_price ?: $product->regular_price) }}</strong>
                                            <small>تومان</small>
                                        </div>
                                        @if($product->sale_price)
                                            <del class="text-gray-500" style="line-height: 1.2;">
                                                <span>{{ number_format($product->regular_price) }}</span>
                                                <small>تومان</small>
                                            </del>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-500">تماس بگیرید</span>
                                @endif
                            </div>
                        @endif
                        @if($product->isVariable())
                            <a href="{{ $product->getRoute() }}" class="btn btn-block btn-outline-primary">
                                مشاهده محصول
                            </a>
                        @endif
                    @else
                        <div class="d-flex flex-row w-100 align-items-center text-muted">
                            <hr class="flex-grow-1"/>
                            <span class="mx-3">ناموجود</span>
                            <hr class="flex-grow-1"/>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
