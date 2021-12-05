
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
    @foreach ($new_orders as $order)
        @include('panel.orders.factor',['order' => $order])
    @endforeach
    </body>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function(){
            window.print();
        });
    </script>
</html>



