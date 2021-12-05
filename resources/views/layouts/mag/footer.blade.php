<div class="bg-deepdark text-white py-5 fa-num">
    <div class="container">
        <div class="row">
            <div class="col-6 col-lg-3 d-flex flex-column align-items-center">
                <i class="fal fa-shipping-fast text-orange mb-3 fa-2x"></i>
                <span class="mb-2">پرداخت و ارسال</span>
                <small class="text-muted">ارسال رایگان برای سفارشات بالای 50 هزار تومان</small>
            </div>
            <div class="col-6 col-lg-3 d-flex flex-column align-items-center">
                <i class="fal fa-undo text-orange mb-3 fa-2x"></i>
                <span class="mb-2">مرجوع کردن سفارشات</span>
                <small class="text-muted">گارانتی بازگرداندن وجه به صورت کامل</small>
            </div>
            <div class="col-6 col-lg-3 d-flex flex-column align-items-center">
                <i class="fal fa-shield-alt text-orange mb-3 fa-2x"></i>
                <span class="mb-2">پرداخت امن</span>
                <small class="text-muted">درگاه پرداخت مطمئن و مستقیم بانکی</small>
            </div>
            <div class="col-6 col-lg-3 d-flex flex-column align-items-center">
                <i class="fal fa-headset text-orange mb-3 fa-2x"></i>
                <span class="mb-2">پشتیبانی حرفه ای</span>
                <small class="text-muted">پشتیبانی آنلاین و سریع در 7 روز هفته</small>
            </div>
        </div>
    </div>
</div>

<div class="bg-dark py-4">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h5 class="text-orange m-0">عضویت در خبرنامه</h5>
                <span class="text-light">با عضویت در خبرنامه از جدیدترین محصولات و تخفیف ها باخبر شوید</span>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-8">
                        <input placeholder="آدرس ایمیل خود را وارد کنید" class="form-control">
                    </div>
                    <div class="col-4">
                        <button class="btn btn-block btn-deepdark">عضویت</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-3">
                @widget('footer_menu',['name' => 'limod'])
            </div>
            <div class="col-12 col-lg-3">
                @widget('footer_menu',['name' => 'services'])
            </div>
            <div class="col-12 col-lg-3">
                @widget('footer_menu',['name' => 'help'])
            </div>
            <div class="col-12 col-lg-3">
                <h5 class="mb-4">شبکه های اجتماعی</h5>
                @if(getOption('site_information.instagram',false))
                    <a href="https://www.instagram.com/{{getOption('site_information.instagram')}}/" target="_blank"
                       class="border mb-2 text-decoration-none text-dark border-2 p-1 rounded-5 border-gray-400 shadow-sm bg-white d-flex flex-row align-items-center">
                        <img height="40" src="{{ asset('images/social_instagram.png') }}" />
                        <div class="d-flex flex-grow-1 flex-column justify-content-center align-items-center">
                            <small>ما را در اینستاگرام دنبال کنید</small>
                            <span >{{getOption('site_information.instagram')}}</span>
                        </div>
                    </a>
                @endif
                @if(getOption('site_information.telegram',false))
                    <a href="https://t.me/{{getOption('site_information.telegram')}}" target="_blank"
                       class="border text-decoration-none text-dark border-2 p-1 rounded-5 border-gray-400 shadow-sm bg-white d-flex flex-row align-items-center">
                        <img height="40" src="{{ asset('images/social_telegram.png') }}" />
                        <div class="d-flex flex-grow-1 flex-column justify-content-center align-items-center">
                            <small>به کانال ما در تلگرام بپیوندید</small>
                            <span>{{getOption('site_information.telegram')}}</span>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="py-4 bg-dark">
    <div class="container text-white fa-num">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="text-center d-inline-block">
                    <h5 class="text-orange">میزبان صدای گرمتان هستیم</h5>
                    <span>7 روز هفته از ساعت 9 الی 21</span>
                </div>
            </div>
            <div class="col-12 col-lg-6 text-center d-flex flex-column justify-content-center">
                <div class="row">
                    <div class="col-6">
                        <a href="tel:{{ getOption('site_information.shop_phone','01733580503') }}" style="font-size: 20px" class="text-orange text-decoration-none">{{ getOption('site_information.shop_phone','01733580503') }}</a>
                        <i class="fal fa-2x fa-phone-alt mr-3"></i>
                    </div>
                    <div class="col-6">
                        <a href="sms:{{ getOption('site_information.shop_mobile','01733580503') }}" style="font-size: 20px" class="text-orange text-decoration-none">{{ getOption('site_information.shop_mobile','09038535404') }}</a>
                        <i class="fal fa-2x fa-comment-dots mr-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="footer" class="bg-transparent">
    <div class="container py-4">
        <div class="row">
            <div class="col-12 col-lg-8">
                @if(getOption('site_information.footer_logo'))
                    <img class="d-inline-block mb-3" src="{{ getImageSrc(getOption('site_information.footer_logo')) }}"
                         style="height: 50px;"
                         title="{{ getOption('site_information.website_name',config('settings.website_name')) }}"
                         alt="{{ getOption('site_information.website_name',config('settings.website_name')) }}"/>
                @endif
                <h4 class="text-dark">{{ getOption('site_information.website_name',config('settings.website_name')) }}</h4>
                <p>{{ getOption('site_information.description',config('settings.description'))}}</p>
            </div>
            <div class="col-12 col-lg-4">
                <a href="#" class="text-decoration-none">
                    <img src="{{ asset('images/samandehi.png') }}" />
                </a>
                <a href="#" class="text-decoration-none">
                    <img src="{{ asset('images/enamad.png') }}" />
                </a>
            </div>
        </div>
    </div>
    @if(getOption('site_information.copyright'))
        <div class="container">
            <div class=" py-3 border-top text-center">
                <small>{{ getOption('site_information.copyright') }}</small>
            </div>
        </div>
    @endif
</div>
