@if(count($config['items']))
    <div class="{{$config['container_class'] ?? ''}}">
        <div class="bg-white p-2 px-lg-4 rounded shadow-sm mb-3">
            <div class="d-flex mb-3 mt-2 flex-wrap justify-content-between align-items-center border-bottom pb-3">
                <h4 class="m-0 text-secondary">{{ $config['title'] }}</h4>
                @if($config['link'])
                    <a class="text-decoration-none text-dark" href="{{$config['link']}}">{{$config['link_title']}}</a>
                @endif
            </div>
            <div class="category-product-slider rounded position-relative overflow-hidden" dir="rtl">
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
@endif
