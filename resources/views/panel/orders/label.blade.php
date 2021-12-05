@if($order ?? false)
<table>
    <tbody>
        <tr>
            <td width="50%">
                <div class="d-flex flex-row justify-content-between w-100">
                    <img src="{{asset('images/label-logo.jpg')}}" style="object-fit: contain" height="150px" alt="">
                    <img src="{{asset('images/label-mohr.jpg')}}" style="object-fit: contain" height="150px" alt="">
                </div>
            </td>
            <td width="50%" rowspan="2">
                <div class="">
                    <div>
                        <h3>مجموعه فروشگاه های آکاد</h3>
                        <p><strong>فرستنده:</strong> گلستان، گنبد، خیابان طالقانی شرقی، خیابان سپاس، مجموعه فروشگاه های آکاد</p>
                        <p><strong>کدپستی:</strong> 4971734400</p>
                        <p><strong>تلفن:</strong> 01733345768</p>
                    </div>
                    <p><strong>کد ملی فرستنده:</strong> 5309682481</p>
                    <p><strong>وبسایت:</strong> https://akadwomen.com</p>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="">
                    <p><strong>گیرنده:</strong> {{$order->getProvince()['name']}}، {{$order->getCity()['name']}}، {{ $order->address }}</p>
                    <p><strong>نام کامل:</strong> {{$order->name}}</p>
                    @if($order->postal_code)
                    <p><strong>کد پستی:</strong> {{$order->postal_code}}</p>
                    @endif
                    <p><strong>تلفن:</strong> {{$order->mobile}}</p>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="text-center flex-1">
                    <span>حمل و نقل رایگان</span>
                    <span class="mx-2">|</span>
                    <span><strong>شناسه سفارش:</strong> {{ $order->code }}</span>
                </div>
            </td>
        </tr>
    </tbody>
</table>
@endif