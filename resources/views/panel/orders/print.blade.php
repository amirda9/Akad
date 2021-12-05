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
            @media print{
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
            td{
                padding: 3px;
                border: 1px solid grey;
            }
            .flex-1 {
                flex:1;
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
            td, th {
                padding: 3px;
            }
            p {
                margin: 0;
                margin-bottom: 3px;
            }
            .align-items-center{
                align-items: center;
            }
            .border-right {
                border-right: 1px solid;
            }
            .justify-content-between{
                justify-content: center;
            }
            body{
                background: #fff;
                margin:0 auto;
                padding:0;
                font-size:12px;
                overflow: hidden;
            }
        </style>
        <title>پرینت برچسب</title>
    </head>
    <body class="fa-num">
        @foreach ($new_orders as $order)
            @include('panel.orders.label',['order' => $order])
        @endforeach
    </body>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function(){
            window.print();
        });
    </script>
</html>



