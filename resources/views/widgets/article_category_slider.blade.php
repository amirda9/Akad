@if(count($config['items']))
    <div class="container mb-5">
        <div class="d-flex mb-3 mt-2 align-items-center">
            <h4 class="m-0 text-secondary">{{ $config['title'] }}</h4>
            <hr class="flex-grow-1 mx-3"/>
            @if($config['link'])
                <a class="btn btn-light rounded-pill" href="{{$config['link']}}">{{$config['link_title']}}</a>
            @endif
        </div>
        <div class="article-category-swiper-container position-relative overflow-hidden">
            <div class="article-category-swiper rounded position-relative overflow-hidden" dir="rtl">
                <div class="swiper-wrapper">
                    @foreach($config['items'] as $item)
                        <div class="swiper-slide">
                            @include('components.mag.article.sliderCard',['article' => $item])
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="article-category-swiper-prev"><i class="far fa-chevron-left fa-fw"></i></div>
            <div class="article-category-swiper-next"><i class="far fa-chevron-right fa-fw"></i></div>
        </div>
    </div>
@endif


@push('scripts')
    <script>
        var mySwiper = new Swiper('.article-category-swiper', {
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                nextEl: '.article-category-swiper-next',
                prevEl: '.article-category-swiper-prev',
            },
            breakpoints: {
                640: {
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
