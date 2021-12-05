@if(count($config['items']))
    @if($config['colored'] == false)
        <div class="container">
            <div class="bg-white p-2 px-lg-4 rounded shadow-sm mb-3">
                <div class="d-flex mb-3 mt-2 flex-wrap justify-content-between align-items-center border-bottom pb-3">
                    <h4 class="m-0 text-secondary">{{ $config['title'] }}</h4>
                    @if($config['link'])
                        <a class="text-decoration-none" href="{{$config['link']}}">{{$config['link_title']}}</a>
                    @endif
                </div>
                <div class="horizontal-slider-container rounded position-relative overflow-hidden" dir="rtl">
                    <div class="swiper-wrapper">
                        @foreach($config['items'] as $item)
                            <div class="swiper-slide">
                                @include('components.productCard',['product' => $item])
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    @else
        <div class="position-relative mb-4 bg-{{ $config['background_color'] }} inner-shadow-y py-4 bg-rounded-lines-left-dark bg-rounded-lines-right-dark">
            <div class="container position-relative z-index-1">
                <div class="mb-3">
                    <div class="d-flex mb-3 mt-2 flex-wrap justify-content-between align-items-center pb-3">
                        <h4 class="m-0 text-{{ $config['text_color'] }}">{{ $config['title'] }}</h4>
                        @if($config['link'])
                            <a class="text-decoration-none text-{{ $config['text_color'] }}" href="{{$config['link']}}">
                                {{$config['link_title']}}
                                <i class="fal fa-angle-left mr-2"></i>
                            </a>
                        @endif
                    </div>
                    <div class="horizontal-slider-container rounded overflow-hidden position-relative bg-white" dir="rtl">
                        <div class="swiper-wrapper">
                            @foreach($config['items'] as $item)
                                <div class="swiper-slide p-2">
                                    @include('components.productCard',['product' => $item])
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif


@push('scripts')
    <script>
        var mySwiper = new Swiper('.horizontal-slider-container', {
            slidesPerView: 2,
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                400: {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 15,
                },
                1024: {
                    slidesPerView: 4,
                        spaceBetween: 20,
                },
            }
        })
    </script>
@endpush
