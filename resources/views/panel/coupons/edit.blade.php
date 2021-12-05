@extends('panel.layouts.master')


@section('head')
<link href="{{ asset('css/persian-datepicker.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
<link href="{{asset('css/bootstrap-select.min.css')}}" rel="stylesheet">
<link href="{{asset('css/bootstrap-select.min.css')}}" rel="stylesheet">






@endsection


@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
            <h1 class="m-0 text-secondary">ویرایش کوپن <span class="text-primary">{{$coupon->title}}</span></h1>
                <a class="btn btn-secondary" href="{{ route('panel.coupons.index') }}">
                    بازگشت
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @include('components.messages')
            <div class="card">
                <div class="card-body">
                    @include('components.messages')
                    <form action="{{route('panel.coupons.update' , $coupon)}}" method="post" enctype="multipart/form-data" >
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="form-group col-12 col-lg-6">
                                <label for="code">کد تخفیف</label>
                                <input type="text" id="code" name="code" placeholder="کد تخفیف" value="{{$coupon->code}}" class="form-control" >
                            </div>
                            <div class="form-group col-12 col-lg-6">
                                <label for="title">عنوان</label>
                                <input type="text" id="title" name="title" placeholder="عنوان" value="{{old('title') ?: $coupon->title}}" class="form-control" >
                            </div>
                            <div class="form-group col-12 col-lg-6">
                                <label for="status">وضعیت</label>
                                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" id="status" name="status">
                                    @foreach (App\Coupon::$statuses as $key=>$status)
                                        <option value="{{$key}}" {{ $key == $coupon->status ? 'selected' : '' }}>{{$status}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-lg-6">
                                <label for="type">نوع تخفیف</label>
                                <select class="form-control" name="type" id="type">
                                    @foreach (App\Coupon::$types as $key=>$type)
                                        <option value="{{$key}}" {{ $key == $coupon->type ? 'selected' : '' }}>{{$type}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-lg-6">
                                <label for="amount"> میزان تخفیف</label>

                                <div class="input-group">
                                <input type="text" name="amount" value="{{old('amount') ?: $coupon->amount}}" class="form-control" autocomplete="off" id="amount">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">درصد/تومان</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-lg-6">
                                <label for="number">تعداد کوپن</label>

                                <div class="input-group">
                                <input type="text" name="number" class="form-control" value="{{old('number') ?: $coupon->number}}" autocomplete="off" id="number">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">عدد</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-lg-6">
                                <label for="min_order_amount">حداقل مبلغ سفارش</label>
                                <div class="input-group">
                                    <input type="text" name="min_order_amount" class="form-control" value="{{old('min_order_amount') ?: $coupon->min_order_amount}}" autocomplete="off" id="min_order_amount">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">تومان/درصد</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-lg-6">
                                <label for="max_discount_amount">حداکثر مبلغ تخفیف</label>
                                <div class="input-group">
                                    <input type="text" name="max_discount_amount" class="form-control" value="{{old('max_discount_amount') ?: $coupon->max_discount_amount}}" autocomplete="off" id="max_discount_amount">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">تومان/درصد</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-lg-6">
                                <label for="shipping_discount">تخفیف هزینه ارسال</label>
                                <div class="input-group">
                                    <input type="text" name="shipping_discount" class="form-control" value="{{old('shipping_discount') ?: $coupon->shipping_discount}}" autocomplete="off" id="shipping_discount">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">تومان</span>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-12 col-lg-6">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="start_date_picker">تاریخ شروع تخفیف</label>
                                        <input type="text" class="form-control" value="{{ $coupon->start_date == null ? '' : $coupon->start_date }}" autocomplete="off" id="start_date_picker">
                                        <input type="hidden" class="form-control" id="start_date" name="start_date">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="end_date_picker">تاریخ پایان تخفیف</label>
                                        <input type="text" class="form-control" value="{{ $coupon->end_date == null ? ''  : $coupon->end_date }}" autocomplete="off" id="end_date_picker">
                                        <input type="hidden" class="form-control" id="end_date" name="end_date">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group col-12">
                                <label for="description">توضیحات</label>
                                <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{old('description') ?: $coupon->description}}</textarea>
                            </div>
                            <div class="form-group col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="general" class="custom-control-input" {{$coupon->general == true ? 'checked' : ''}}  id="general">
                                    <label class="custom-control-label" for="general">کوپن تخفیف عمومی است؟</label>
                                </div>
                                <p>
                                    <small>در صورتی که مایل هست هر کاربری بتواند از این کد استفاده کند فعال کنید</small>
                                </p>
                            </div>
                            <div class="form-group col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="is_disposable" class="custom-control-input" {{ $coupon->is_disposable ? 'checked' : '' }} id="is_disposable">
                                    <label class="custom-control-label" for="is_disposable">کوپن تخفیف یکبار مصرف است؟</label>
                                </div>
                                <p>
                                    <small>هر کاربر فقط می تواند یک بار از این کد تخفیف استفاده کند</small>
                                </p>
                            </div>
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-primary">ذخیره</button>

                            </div>
                        </div>

                    </form>


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
                format: 'YYYY/MM/DD HH:mm',
                altField: '#start_date',
                observer: false,
                initialValue: {{ $coupon->start_date != null ? 'true' : 'false' }},
                initialValueType: 'gregorian',
                timePicker: {
                    enabled : true,
                    step : 1,
                    hour:{
                        enabled:true,
                        step:1
                    },
                    minute :{
                        enabled:true,
                        step:1
                    },
                    second:{
                        enabled:false
                    }
                }
            });




            expire_date = $('#end_date_picker').persianDatepicker({
                format: 'YYYY/MM/DD HH:mm',
                altField: '#end_date',
                observer: false,
                initialValue: {{ $coupon->start_date != null ? 'true' : 'false' }},
                initialValueType: 'gregorian',
                timePicker: {
                    enabled : true,
                    step : 1,
                    hour:{
                        enabled:true,
                        step:1
                    },
                    minute :{
                        enabled:true,
                        step:1
                    },
                    second:{
                        enabled:false
                    }
                }

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
