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
            size: 148mm 105mm;
        }

        @media print {
            .print-item {
                size: 138mm 95mm;
                background-color: red;
                page-break-after: always;
            }
        }

        table {
            size: 138mm 95mm;
            page-break-after: always;
        }

        td {
            padding: 3px;
            border: 1px solid grey;
        }

        .flex-1 {
            flex: 1;
        }

        .d-flex {
            display: flex;
        }

        .flex-row {
            flex-direction: row;
        }

        .flex-column {
            flex-direction: column;
        }

        .print-item {
            page-break-after: always;
            margin-bottom: 5px;
        }

        .border-top {
            border-top: 1px solid;
        }

        .h-100 {
            height: 100%;
        }

        .w-100 {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .border {
            border: 1px solid;
        }

        .m-1 {
            margin: 1em;
        }

        .p-1 {
            padding: 1em;
        }

        td,
        th {
            padding: 3px;
        }

        p {
            margin: 0;
            margin-bottom: 3px;
        }

        .align-items-center {
            align-items: center;
        }

        .border-right {
            border-right: 1px solid;
        }

        .justify-content-between {
            justify-content: center;
        }

        body {
            background: #fff;
            margin: 0 auto;
            padding: 0;
            font-size: 12px;
            overflow: hidden;
        }
    </style>
    <title>پرینت برچسب</title>
</head>

<body class="fa-num">
    @foreach ($orders as $order)
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
                <td>
                    <div class="float-right">
                        <span><strong>شناسه سفارش:</strong> {{ $order->code }}</span>
                    </div>
                </td>
                <td>
                    <div class="float-left">
                        <span><strong>حاوی پوشاک</strong></span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    @endforeach
</body>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $(document).ready(function() {
        window.print();
    });
</script>

</html>