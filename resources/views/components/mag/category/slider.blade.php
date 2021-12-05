@if($article_category ?? false)
    <div class="d-flex mb-3 mt-2 align-items-center">
        <h4 class="m-0 text-secondary">{{ $article_category->name }}</h4>
        <hr class="flex-grow-1 mx-3"/>
        <a class="btn btn-light rounded-pill" href="{{ $article_category->getRoute() }}">مشاهده همه</a>
    </div>
    <div class="article-category-swiper-container position-relative overflow-hidden">
        <div class="article-category-swiper rounded position-relative overflow-hidden" dir="rtl">
            <div class="swiper-wrapper">
                @foreach($article_category->articles as $article)
                    <div class="swiper-slide">
                        @include('components.mag.article.sliderCard',['article' => $article])
                    </div>
                @endforeach
            </div>
        </div>
        <div class="article-category-swiper-prev"><i class="far fa-chevron-left fa-fw"></i></div>
        <div class="article-category-swiper-next"><i class="far fa-chevron-right fa-fw"></i></div>
    </div>
@endif

