@if($cart_item ?? false)
    <div class="p-2 bg-white d-flex shadow-sm border rounded border-gray-200 mb-3">
        @if($cart_item->product)
            <a href="{{ $cart_item->product->getRoute() }}" target="_blank">
                <img src="{{ getImageSrc($cart_item->product->getImage(),'product_card') }}"
                     class="img-fluid ml-2" style="width: 60px;" />
            </a>
        @endif
        <div class="d-flex flex-grow-1 flex-column">
            @if($cart_item->product)
                <a href="{{ $cart_item->product->getRoute() }}" class="text-decoration-none text-secondary" target="_blank">
                    <p class="m-0">{{ $cart_item->title }}</p>
                </a>
            @else
                <p class="m-0">{{ $cart_item->title }}</p>
            @endif
            @if($cart_item->sub_title)
                <div class="my-1 text-muted"><small>{{$cart_item->sub_title}}</small></div>
            @endif
            <div class="d-flex justify-content-between align-items-center text-gray-500 fa-num">
                <small>{{ $cart_item->quantity }} عدد</small>
                <small>{{ number_format($cart_item->total_price) }} تومان</small>
            </div>
        </div>
    </div>
@endif
