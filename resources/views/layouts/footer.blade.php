<div class="py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-3">
                @widget('footer_menu',['name' => 'footer1'])
            </div>
            <div class="col-12 col-lg-3">
                @widget('footer_menu',['name' => 'footer2'])
            </div>
            <div class="col-12 col-lg-3">
                @widget('footer_menu',['name' => 'footer3'])
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
                <div class="text-justify">{!! getOption('site_information.description',config('settings.description')) !!}</div>
            </div>
            <div class="col-12 col-lg-4">
                <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=158165&amp;Code=50NpFU49kWbs7tQ5Hu2G"><img referrerpolicy="origin" src="https://Trustseal.eNamad.ir/logo.aspx?id=158165&amp;Code=50NpFU49kWbs7tQ5Hu2G" alt="" style="cursor:pointer" id="50NpFU49kWbs7tQ5Hu2G"></a>
            </div>

        </div>

        <div class="border-top pt-4">
            <div class="row">
                @if(getOption('site_information.address'))
                    <div class="col-12 col-lg-6">
                        <i class="fal fa-map-marker-alt ml-3" style="font-size: 20px"></i>
                        <span>{{ getOption('site_information.address','') }}</span>
                    </div>
                @endif
                @if(getOption('site_information.shop_phone'))
                    <div class="col-6 col-lg-3">
                        <i class="fal fa-phone ml-3" style="font-size: 20px"></i>
                        <a class="text-dark" href="tel:{{ getOption('site_information.shop_phone','') }}">{{ getOption('site_information.shop_phone','') }}</a>
                    </div>
                @endif
                @if(getOption('site_information.shop_mobile'))
                    <div class="col-6 col-lg-3">
                        <i class="fal fa-mobile ml-3" style="font-size: 20px"></i>
                        <a class="text-dark" href="tel:{{ getOption('site_information.shop_mobile','') }}">{{ getOption('site_information.shop_mobile','') }}</a>
                    </div>
                @endif
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
