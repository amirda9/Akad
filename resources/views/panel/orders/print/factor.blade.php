
<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/persianfonts.css') }}" rel="stylesheet">

        <style>
            @page {
                margin: 1mm;
                size: 105mm 148mm;
            }
            body{
                height: auto;
                background: #fff;
                margin:0 auto;
                padding:0;
                font-size:12px;
                overflow: hidden;

            }
            td, th{
                padding:3px !important;
                border: 1px solid grey;
            }
            .item-row {
                border-top: 1px dashed grey;
            }
            .text-center {
                text-align: center;
            }
            .text-right {
                text-align: right;
            }
            .text-left {
                text-align: left;
            }
            .dir-ltr {
                direction: ltr;
            }
            p {
                margin: 0;
                margin-bottom: 3px;
            }
            table{
                width: 100%;
                border-spacing: 0;
                page-break-after: always;
                border: 1px solid grey;
            }
            .border {
                border: 1px solid grey !important;
            }
        </style>
        <title>پرینت فاکتور</title>


    </head>
    <body class="fa-num">
    @foreach ($orders as $order)
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
    @endforeach
    </body>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function(){
            window.print();
        });
    </script>
</html>



