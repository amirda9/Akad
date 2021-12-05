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
            <h1 class="m-0 text-secondary">ایجاد محدودیت برای کوپن <span class="text-danger">{{$coupon->title}}</span></h1>
                <a class="btn btn-secondary" href="{{ route('panel.coupons.index') }}">
                    بازگشت
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @include('panel.coupons.tab')
            <div class="card">
                <div class="card-body">
                    @include('components.messages')

                    <form action="{{route('panel.coupons.limitStore',$coupon)}}" method="post" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="model_type">نوع محدودیت</label>
                                <select name="model_type" id="model_type" class="form-control selectpicker"
                                 >
                                    @foreach (App\Coupon::$models as $key=>$model)
                                        <option value="{{$key}}">{{$model}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="model_id">وارد کردن شناسه(کالا - دسته بندی - محصول)</label>
                               <input type="text" name="model_id" class="form-control" id="model_id" placeholder="کد را وارد کنید">
                            </div>
                      
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-primary btn-send">ذخیره</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @if ($limits->count() > 0)
                        <table class="table">
                            <tr>
                                <th>#</th>
                                <th>مدل</th>
                                <th>شماره شناسه</th>
                                <th></th>
                            </tr>
                            @foreach ($limits as $limit)
                                <tr>
                                    <th>{{$limit->id}}</th>
                                    <th>{{$limit->getTypeTitle()}}</th>
                                    <th>{{$limit->model_id}}</th>
                                    <th>
                                    <form action="{{route('panel.coupons.limitDestroy',$limit)}}" method="post">
                                        @csrf
                                        @method('delete')
                                            <button class="btn btn-sm btn-danger" type="submit" onclick="confirm('آیا مطمعن هستید؟')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                        
                                    </th>
                                </tr>
                            @endforeach
                        
                            
                        </table>
                        @else
                        @include('components.limit')

                    @endif
                   
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