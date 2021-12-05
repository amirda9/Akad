@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'سبد خرید',
        'description' => getOption('site_information.description',config('settings.description')),
        'image' => getImageSrc(getOption('site_information.logo'))
    ])
@endsection
@section('title')
    <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . 'سبد خرید' }}</title>
@endsection
@section('content')
<div class="container">
    @if(Cart::count())
        @include('components.cart.steps',['step' => 1])
    @endif
    @include('components.messages')
    @if(Cart::count())
        <div class="table-responsive mb-4 d-none d-lg-block">
            <table class="table bg-white m-0 text-center border">
                <thead class="bg-light">
                <tr>
                    <th>تصویر محصول</th>
                    <th class="text-right">توضیحات</th>
                    <th>قیمت</th>
                    <th>تعداد</th>
                    <th>مجموع</th>
                </tr>
                </thead>
                <tbody>
                @foreach(Cart::content() as $item)
                    <tr>
                        <td class="align-middle">
                             <a href="{{ $item->model->getRoute() }}">
                                <img style="height: 50px;" class="rounded shadow-sm" src="{{ getImageSrc($item->model->getImage(),'small') }}" />
                            </a>
                        </td>
                        <td class="align-middle text-right">
                            <h5 class="mb-1"><a class="text-decoration-none text-dark" href="{{ $item->model->getRoute() }}">{{ $item->model->title }}</a></h5>
                            @if($item->options['vid'] ?? false)
                                <div>
                                    @foreach($item->options['attributes'] ?? [] as $item_attribute)
                                        <span class="ml-3">{{$item_attribute['title'] ?? ''}} : {{ $item_attribute['value'] ?? '' }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td class="fa-num">
                            @if($item->price)
                                <h5 class="m-0">{{ number_format($item->price) }} تومان</h5>
                            @else
                                <h5 class="m-0">---</h5>
                            @endif
                        </td>
                        <td class="fa-num align-middle text-nowrap">
                            <div class=" align-items-center justify-content-center d-flex flex-row">
                                <div class="input-group input-group-sm justify-content-center ml-2" style="width:100px;">
                                    <div class="input-group-prepend">
                                        <a class="btn btn-outline-secondary" href="{{ route('cart.decrease',$item->rowId) }}">
                                            <i class="fa fa-minus"></i>
                                        </a>
                                    </div>
                                    <input readonly type="text" class="form-control bg-light text-center" value="{{ $item->qty }}">
                                    <div class="input-group-append">
                                        <a class="btn btn-outline-secondary" href="{{ route('cart.increase',$item->rowId) }}">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <a href="{{ route('cart.remove',$item->rowId) }}" onclick="return confirm('آیا مطمئن هستید ؟')" class="btn btn-sm btn-red">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                        <td class="fa-num align-middle text-nowrap">
                            @if($item->price)
                                <h5 class="m-0">{{ $item->subtotal() }} تومان</h5>
                            @else
                                <h5 class="m-0">---</h5>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-lg-none">
            @foreach(Cart::content() as $item)
                <div class="bg-white p-3 rounded shadow-sm mb-3">
                    <div class="d-flex flex-row justify-content-between mb-3">
                        <a href="{{ $item->model->getRoute() }}">
                            <img style="height: 70px;" class="rounded shadow-sm" src="{{ getImageSrc($item->model->getImage(),'small') }}" />
                        </a>
                        <div class="mr-3 flex-grow-1">
                            <strong class="d-block mb-1"><a class="text-decoration-none text-dark" href="{{ $item->model->getRoute() }}">{{ $item->model->title }}</a></strong>
                            @if($item->options['vid'] ?? false)
                                <div>
                                    @foreach($item->options['attributes'] ?? [] as $item_attribute)
                                        <span class="ml-3 text-nowrap">{{$item_attribute['title'] ?? ''}} : {{ $item_attribute['value'] ?? '' }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-between">
                        <div class="align-items-center justify-content-center d-flex flex-row">
                            <div class="input-group input-group-sm justify-content-center ml-2" style="width:100px;">
                                <div class="input-group-prepend">
                                    <a class="btn btn-outline-secondary" href="{{ route('cart.decrease',$item->rowId) }}">
                                        <i class="fa fa-minus"></i>
                                    </a>
                                </div>
                                <input readonly type="text" class="form-control bg-light text-center" value="{{ $item->qty }}">
                                <div class="input-group-append">
                                    <a class="btn btn-outline-secondary" href="{{ route('cart.increase',$item->rowId) }}">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <a href="{{ route('cart.remove',$item->rowId) }}" onclick="return confirm('آیا مطمئن هستید ؟')" class="btn btn-sm btn-red">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                        @if($item->price)
                            <div>
                                <strong class="fa-num" style="font-size: 20px">{{ $item->subtotal() }}</strong>
                                <span>تومان</span>
                            </div>
                        @else
                            <span class="text-muted">---</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div>
                <a class="btn btn-secondary" href="{{ route('index') }}">
                    <i class="far fa-angle-right ml-2"></i>
                    صفحه اصلی
                </a>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('cart.shipping') }}">
                    اطلاعات ارسال
                    <i class="far fa-angle-left mr-2"></i>
                </a>
                @isset($order_users)
                    @if ($order_users->count() > 0)
                        <a class="btn btn-success text-white" type="button" data-toggle="modal" data-target="#merge">
                            ادغام سفارش
                        </a>
                    @endif
                @endisset



            </div>

        </div>
    @else
        <div class="bg-white shadow-sm rounded p-3">
            <div class="p-2 p-lg-5 text-center text-gray-500">
                <i class="fal fa-shopping-cart mb-4" style="font-size: 100px;"></i>
                <h2 class="mb-4">سبد خرید شما خالیست!</h2>
                <p>برای مشاهده محصولات به صفحات زیر بروید:</p>
                <div class="mb-4">
                    <a href="{{ route('products.all',['featured' => 'on']) }}">محصولات ویژه</a>
                    |
                    <a href="{{ route('products.all',['orderBy' => 'latest']) }}">جدیدترین محصولات</a>
                    |
                    <a href="{{ route('products.all') }}">همه محصولات</a>
                </div>
                <a href="{{ route('index') }}" class="d-none d-lg-inline-block btn btn-lg btn-primary">
                    رفتن به صفحه اصلی
                </a>
                <a href="{{ route('index') }}" class="d-lg-none btn btn-primary">
                    صفحه اصلی
                </a>
            </div>
        </div>
    @endif
</div>






<div class="modal fade" id="merge" tabindex="-1" role="dialog" aria-labelledby="mergeLabel" aria-hidden="true">
    <div class="modal-dialog merge-modal" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mergeLabel">ادغام سفارش</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @isset($order_users)

            @if ($order_users->count() > 0)
            <div class="row p-2">
                <p> کاربر عزیز  سفارش مورد نظر خود را انتخاب کنید و آن را به  روز رسانی کنید...</p>
            </div>
        <form id="SubmitOrderIntegration" action="{{route('cart.SubmitOrderIntegration')}}" method="post">
            @csrf
            <input type="hidden" name="order_code" id="order_code" value="">
            @foreach ($order_users as $key=>$order )
                <div class="rounded borderd w-100 p-2 merge-order-item my-2 order-box" style="font-size:12px"  data-code={{$order->code}}>
                    <div class="d-flex flex-wrap justify-content-between align-items-between py-2">
                        <span>کد سفارش : <strong class="fa-num">{{$order->code}}</strong></span>
                        <span>
                            <span>مبلغ کل</span>
                            <strong class="fa-num"> {{ number_format($order->getOrderPrice()) }}</strong>
                        </span>
                    </div>
                    <p>{{ $order->getProvince()['name'] }}-{{ $order->getCity()['name'] }} ، {{$order->address}}</p>
                </div>
                @endforeach
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"  >ادغام سفارش</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                </div>

        </form>
                @else

                @include('components.empty')

            @endif
            @endisset

      </div>
    </div>
</div>



@endsection

@section('scripts')
<script>
        $('body').on('click','#merge_btn', function() {
            let order_code = $(this).attr('data-order');
            console.log(order_code);
            $.post("{{ route('cart.SubmitOrderIntegration') }}",{
                "_token": "{{ csrf_token() }}",
                order_id: $(this).attr('data-order'),
            }).done(response => {
               $('#merge').modal('dispose');
               window.location.href="{{ route('cart.show') }}"
            }).fail(error => {
                console.log(error)
            });
        });

        $('.merge-order-item').click(function(){
            $('.merge-order-item').removeClass('active');
            $(this).addClass('active');
            var order_id=$(this).attr('id');
            $('#merge_btn').attr('data-order',order_id);
        });

        $('body').on('click' , '.order-box' , function(){
            let order_code = $(this).data('code');
            $('#order_code').val(order_code);
        }).on('submit','#SubmitOrderIntegration', function(e) {
            if(!$('#order_code').val()) {
                e.preventDefault();
                alert('لطفا سفارش مورد نظر را انتخاب کنید')
            }
        });
</script>

@endsection
