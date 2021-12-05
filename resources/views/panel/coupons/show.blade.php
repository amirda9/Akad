@extends('panel.layouts.master')


@section('head')
<link href="{{ asset('css/persian-datepicker.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
<link href="{{asset('css/bootstrap-select.min.css')}}" rel="stylesheet">
@endsection


@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
            <h1 class="m-0 text-secondary">مشاهده کوپن <span class="text-primary">{{$coupon->title}}</span></h1>
                <a class="btn btn-secondary" href="{{ route('panel.coupons.index') }}">
                    بازگشت
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @include('panel.coupons.tab')
            @include('components.messages')
            <div class="card">
                <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <strong>عنوان کوپن : </strong> {{$coupon->title}}
                                <br>
                                <br>
                                <strong>نوع کوپن : </strong>{{$coupon->general ? 'کوپن عمومی ' : 'اختصاصی  '}}
                                <br>
                                <br>
                                <strong>کوپن یکبار مصرف : </strong> {{$coupon->is_disposable ? 'بله' : 'خیر'}}
                                <br>
                                <br>
                                <strong>وضعیت کوپن : </strong>{{$coupon->getStatusTitle()}}
                                <br>
                                <br>
                                <strong>میزان تخفیف : </strong>{{$coupon->amount}} <span class="badge badge-light">{{$coupon->getTypeTitle()}}</span>
                                <br>
                                <br>
                                <strong>تخفیف هزینه ارسال : </strong>{{ number_format($coupon->shipping_discount) }} تومان
                                <br>
                                <br>
                                <strong>تعداد کوپن : </strong>{{$coupon->number}}
                                <br>
                                <br>
                                <strong>حداقل مبلغ سفارش : </strong>{{$coupon->min_order_amount}}
                                <br>
                                <br>
                                <strong>حداکثر مبلغ تخفیف : </strong>{{$coupon->max_discount_amount}}
                                <br>
                                <br>
                                <strong>تاریخ شروع کوپن : </strong>{{$coupon->start_date == null ? '---' : jd($coupon->start_date)}}
                                <br>
                                <br>
                                <strong>تاریخ انقضا کوپن : </strong>{{$coupon->end_date == null ? '---' : jd($coupon->end_date)}}
                                <br>
                                <br>
                                <strong>توضیحات :</strong>
                                <br>
                                <br>
                                <p>{{$coupon->description}}</p>

                                <br>

                                <form action="{{route('panel.coupons.destroy' , $coupon )}}" method="post">
                                    @csrf
                                    @method('delete')

                                    <a href="{{route('panel.coupons.edit' , $coupon->id )}}" class="btn btn-sm btn-success " >ویرایش</a>

                                <button type="submit" onclick="confirm('ایا از حذف اطمینان دارید؟')"  target="_blank" class="btn btn-sm btn-danger" >حذف</button>

                                </form>

                            </div>
                        </div>


                </div>
            </div>
        </div>
    </div>

</div>
@endsection


@section('scripts')
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
    <script src="{{ asset('js/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/persian-datepicker.min.js') }}"></script>
    <script>
        $('#user_id').selectpicker({});

        $(document).ready(function () {
        var start_date;
        var end_date;

        $(document).ready(function () {
            start_date = $('#start_date_picker').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#start_date',
                observer: false,
                initialValue: false,
            });

            expire_date = $('#end_date_picker').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#end_date',
                observer: false,
                initialValue: false,

            });


            @if(old('start_date'))
                start_date.setDate(parseFloat("{{ old('start_date') }}"));
            @endif


            @if(old('end_date'))
                end_date.setDate(parseFloat("{{ old('end_date') }}"));
            @endif


        });



    });



    </script>

<script type="text/javascript">

    var searchTimer = null;
    var selected_products = [];


     $(".products").keyup(function(e){
         if(searchTimer) {
             clearTimeout(searchTimer);
             searchTimer = null;
         } else {
             searchTimer = setTimeout(() => searchProducts(), 400);
         }
      });

      function searchProducts() {
          console.log('search');
             var products = $(".products").val();
             if(products.length > 2) {
                 $.ajax({
                     type:'POST',
                     url:"http://localhost:8000/panel/products/viewProducts",
                     data:{
                         'products':products,
                         _token: "{{ csrf_token() }}",
                     },
                     success:function(data){
                         $('#search_result').html(data);
                     },
                     error:
                     function(err){
                         console.log(err)
                     }
                 });
             } else {
                 $('#search_result').html('');
             }
         clearTimeout(searchTimer);
         searchTimer = null;
      }
     </script>


     <script>
         $('body').on('click','.product-search-result-item', function() {

             let product_id = $(this).data('product-id');
             let product_title = $(this).data('product-title');
             selected_products = selected_products.filter(product => {
                 return product.id != product_id
             });
             selected_products.push({
                 id: product_id,
                 title: product_title
             });
             renderSelectedProducts();



         }).on('click','.remove-selected-product',function () {
             let product_id = $(this).data('id');
             selected_products = selected_products.filter(product => {
                 return product.id != product_id;
             });
             renderSelectedProducts();
         })

         function renderSelectedProducts() {
             let content = '';
             selected_products.forEach(product => {
                 content += '<span class="badge badge-success m-2">'+product.title+'<i data-id="'+ product.id +'" class="remove-selected-product fe fe-x mr-2" style="cursor: pointer"></i></span>';
                 content += '<input type="hidden" name="product[]" value='+product.id+' >' ;
                 $('.product-search-result-item').slideUp().remove();
             });
             $('#export').html(content);
         }

     </script>




@endsection
