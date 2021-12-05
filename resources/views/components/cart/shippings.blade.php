@if(count($shippings ?? []))
    @foreach($shippings as $shipping)
        <label for="{{ $shipping['name'] }}" class="shadow-hover cursor-pointer d-flex flex-wrap align-items-center bg-white border rounded p-3 mb-3">
            <input required
                   oninvalid="this.setCustomValidity('لطفا روش ارسال را انتخاب کنید')"
                   oninput="setCustomValidity('')"
                   data-price="{{$shipping['price']}}" type="radio" name="shipping" id="{{ $shipping['name'] }}" value="{{ $shipping['name'] }}"/>
            <h5 class="mb-0 mx-3 flex-grow-1">{{ $shipping['title'] ?? '' }}</h5>
            <h5 class="m-0 fa-num">
                @if($shipping['price'])
                    {{ $shipping['price'] }} تومان
                @else
                    رایگان!
                @endif
            </h5>
        </label>
    @endforeach
@else
    @include('components.empty')
@endif
