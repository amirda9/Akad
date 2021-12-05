@if($order ?? false)
    @php
        $border_color = '';
        switch ($order->status) {
            case 'failed' : {
                $border_color = 'border-danger';
                break;
            }
            case 'processing' : {
                $border_color = 'border-info';
                break;
            }
            case 'sent' : {
                $border_color = 'border-primary';
                break;
            }
            case 'pending' : {
                $border_color = 'border-warning';
                break;
            }
            case 'completed' : {
                $border_color = 'border-success';
                break;
            }
            case 'reserve' : {
                $border_color = 'border-purple';
                break;
            }
        }
    @endphp
    <div class="bg-white rounded shadow-sm shadow-hover mb-3 p-3 border-right border-4 {{ $border_color }}">
        <div class="d-flex flex-row align-items-center justify-content-between text-muted mb-2">
            <a class="d-block text-muted text-decoration-none" href="{{ route('user.orders.show',$order->code) }}">
                <span>کد سفارش: </span>
                <strong class="fa-num">{{ $order->code }}</strong>
            </a>
            <span>تاریخ: {{ jd($order->created_at) }}</span>
        </div>
        <p>
            <i class="far fa-map-marker-alt ml-2" style="font-size: 18px"></i>
            {{ $order->getProvince()['name']}}، {{ $order->getCity()['name']}}، {{ $order->address }}{{ $order->zip ? "، کدپستی: $order->postal_code" : ''}}
        </p>
        <div class="mb-2">
            @foreach($order->items as $order_item)
                @if($order_item->product->image ?? false)
                    <a href="{{ $order_item->product->getRoute() }}" target="_blank">
                        <img class="rounded m-1" src="{{ getImageSrc($order_item->product->image,'avatar') }}" style="width:40px; height:40px; object-fit: cover" />
                    </a>
                @endif
            @endforeach
        </div>
        <div class="d-flex align-items-end justify-content-between">
            <div class="d-flex flex-column align-items-start fa-num text-muted">
                <span>وضعیت : {{ $order->getStatusTitle() }}</span>
                <span>مبلغ : <strong>{{ number_format($order->getOrderPrice()) }} تومان</strong></span>
            </div>
            <div class="d-flex flex-row align-items-center justify-content-end">
                @if($order->canReserve())
                    <a class="btn btn-indigo btn-sm mr-2" href="{{ route('user.orders.reserve',$order->code) }}">
                        رزرو سفارش
                    </a>
                @endif
                @if($order->isReserved())
                    <a class="btn btn-success mr-2 btn-sm" href="{{ route('user.orders.done',$order->code) }}">
                        تکمیل خرید
                    </a>
                @endif
                <a href="{{ route('user.orders.show',$order->code) }}" class="btn btn-light btn-sm mr-2">
                    مشاهده <i class="far fa-chevron-left mr-2"></i>
                </a>
            </div>
        </div>
    </div>
@endif
