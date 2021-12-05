@if(Cart::count())
    <div class="d-flex flex-column" style="width: 300px; max-width: 100%;">
        <div class="cart-dropdown-header d-flex
                justify-content-between align-items-center p-2 border-bottom border-gray-200">
            <span class="text-gray-500 fa-num">{{ Cart::count() }} کالا</span>
            <a class="btn btn-link text-decoration-none" href="{{ route('cart.shipping') }}">
                ثبت سفارش
            </a>

        </div>
        <div class="cart-dropdown-body">
            <ul class="list-unstyled p-0 m-0">
                @foreach(Cart::content() as $cart_item)
                    <li class="p-2 d-flex border-bottom border-gray-200">
                        <a class=" ml-2" href="{{ $cart_item->model->getRoute() }}">
                            <img src="{{ getImageSrc($cart_item->model->getImage(),'product_card') }}"
                                 class="img-fluid" style="width: 60px;" />
                        </a>
                        <div class="d-flex flex-grow-1 flex-column">
                            <a href="{{ $cart_item->model->getRoute() }}" class="text-decoration-none">{{ $cart_item->name }}</a>
                            @if($cart_item->options['vid'] ?? false)
                                <div class="text-muted my-1">
                                    @foreach($cart_item->options['attributes'] ?? [] as $item_attribute)
                                        <small class="ml-3">{{$item_attribute['title'] ?? ''}} : {{ $item_attribute['value'] ?? '' }}</small>
                                    @endforeach
                                </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center text-gray-500 fa-num">
                                <small>{{ $cart_item->qty }} عدد</small>
                                <div>
                                    <a class="btn btn-sm btn-light" href="{{ route('cart.increase',$cart_item->rowId) }}">
                                        <i class="far fa-plus"></i>
                                    </a>
                                    <a class="btn btn-sm btn-light" href="{{ route('cart.decrease',$cart_item->rowId) }}">
                                        <i class="far fa-minus"></i>
                                    </a>
                                    <a onclick="return confirm('آیا مطمئین هستید؟')" class="text-danger btn-light btn btn-sm"
                                       href="{{ route('cart.remove',$cart_item->rowId) }}">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="cart-dropdown-footer d-flex justify-content-between align-items-center p-2">
            <div class="d-flex flex-column">
                <small class="text-gray-500">مبلغ سفارش:</small>
                <strong class="fa-num text-gray-700">{{ Cart::total() }} تومان</strong>
            </div>


            <a class="btn btn-primary p-1 text-decoration-none flex-end" href="{{ route('cart.show') }}">
                <i class="fas fa-shopping-basket"></i>
                مشاهده سبد خرید
            </a>






        </div>
    </div>
@else
    <div class="p-3 text-center text-gray-400">
        <i class="fal fa-shopping-cart fa-2x mb-2"></i>
        <span class="d-block">سبد خرید خالی است</span>
    </div>
@endif
