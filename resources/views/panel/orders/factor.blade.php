@if($order)
    <table>
        <thead>
            <tr>
                <td colspan="2" class="text-center"><strong>کد سفارش: </strong>{{ $order->code }}</td>
                <td colspan="2" class="text-left">{{ jd($order->created_at) }}</td>
            </tr>
            <tr><td colspan="4"></td></tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">#</td>
                <td>محصول</td>
                <td class="text-center">تعداد</td>
                <td class="text-left">قیمت</td>
            </tr>
            @foreach ($order->items as $key => $item)
                <tr>
                    <td class="text-center">{{$key+1}}</td>
                    <td>
                        <p>{{$item->title}} @if($item->sub_title)<small>({{$item->sub_title}})</small>@endif</p>

                    </td>
                    <td class="text-center">{{$item->quantity}}</td>
                    <td class="text-left">{{number_format($item->total_price)}} تومان</td>
                </tr>
            @endforeach
            <tr><td colspan="4"></td></tr>
            <tr>
                <td colspan="2" class="text-left">مبلغ سفارش</td>
                <td colspan="2" class="text-left">{{ number_format($order->getOrderPrice()) }} تومان</td>
            </tr>
            <tr>
                <td colspan="2" class="text-left">هزینه ارسال</td>
                <td colspan="2" class="text-left">{{ number_format($order->shipping_price) }} تومان</td>
            </tr>
            @if($order->discount > 0)
                <tr>
                    <td colspan="2" class="text-left">تخفیف</td>
                    <td colspan="2" class="text-left">{{ number_format($order->discount) }} تومان</td>
                </tr>
            @endif
            <tr>
                <td colspan="2" class="text-left">مبلغ کل</td>
                <td colspan="2" class="text-left">{{ number_format($order->getFinalPrice()) }} تومان</td>
            </tr>
            <tr><td colspan="4"></td></tr>
            <tr>
                <th colspan="4">اطلاعات گیرنده</th>
            </tr>
            <tr>
                <td colspan="4">
                    <p><strong>گیرنده:</strong> {{$order->getProvince()['name']}}، {{$order->getCity()['name']}}، {{ $order->address }} @if($order->postal_code)<strong>کد پستی:</strong> {{$order->postal_code}}@endif</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p><strong>نام کامل:</strong> {{$order->name}}</p>
                </td>
                <td colspan="2">
                    <p><strong>تلفن:</strong> {{$order->mobile}}</p>
                </td>
            </tr>
            @if($order->description)
                <tr>
                    <td colspan="4">
                        <p><strong>توضیحات:</strong> {{$order->description}}</p>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
@endif
