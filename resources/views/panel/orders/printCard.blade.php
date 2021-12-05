
    <div class="card bordred m-1 d-flex d-inline" >
        <div class="row p-2">
            <div class="col-6 " style="border-left: 1px dashed #000">
               <img src="{{asset('label.png')}}" width="100%" height="150px" alt="">
                <hr>
                <div>
                    <div class="d-flex align-items-center justify-content-between py-1">
                        <strong >گیرنده</strong>
                        <span >{{$order->name}}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between py-1">
                        <strong>شماره تماس</strong>
                        <span class="fa-num" >{{$order->mobile}}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between py-1">
                        <strong>آدرس</strong>
                        <span class="fa-num">{{ $order->getProvince()['name'] }}، {{ $order->getCity()['name'] }}، {{$order->address}}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between py-1">
                        <strong>کد پستی</strong>
                        <span class="fa-num">{{$order->postal_code}}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between py-1">
                        <div class="px-4">هزینه بسته بندی و ارسال به سراسر ایران</div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="py-1"><strong>مجموعه فروشگاه های آکاد</strong></div>
                <div class="py-1"><strong>فرستنده</strong>
                 خیابان سپاس مجموعه فروشگاه های آکاد گلستان ، گنبدکاووس، خیابان طالقای شرقی
                </div>
                <div class="py-1"><strong>کدپستی</strong> <span class="fa-num">4971734400</span></div>
                <div class="py-1"><strong>کد ملی فرستنده </strong> <span class="fa-num">5309682481</span></div>
                <div class="py-1"><strong>وب سایت</strong> http://www.akadwoman.ir</div>
                <div class="py-1"> <strong> شناسه سفارش </strong> {{$order->code}} </div>
            </div>
        </div>
    </div>

