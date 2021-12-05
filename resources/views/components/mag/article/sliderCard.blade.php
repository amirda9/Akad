@if($article)
    <div class="w-100 overflow-hidden shadow-md-hover bg-white d-flex">
        <div class="w-100 position-relative d-flex flex-column flex-grow-1"
             style="margin-right: -1px;">
            <a href="{{ $article->getRoute() }}" class="text-center p-2">
                <div class="article-slider-card-image-container overflow-hidden d-flex flex-column ">
                    <img style="object-fit: cover"
                         src="{{ getImageSrc($article->getImage(),'mag_card') }}"
                         alt="{{ $article->title }}" />
                </div>
            </a>
            <div class="p-2 px-lg-3 d-flex flex-column flex-grow-1 ">
                <div class="mb-2 mb-lg-3 d-flex align-items-center" style="height: 75px">
                    <a class="d-block text-dark text-decoration-none text-center"
                        style="font-size: 16px;"
                        href="{{ $article->getRoute() }}">
                        {{ str_limit($article->title) }}
                    </a>
                </div>
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <small class="bg-light text-muted px-1 py-1 d-inline-block rounded-pill fa-num">
                        <i class="far fa-clock" aria-hidden="true"></i> {{ $article->created_at->diffForHumans() }}
                    </small>
                    <small class="bg-light text-muted px-1 py-1 d-inline-block rounded-pill fa-num">
                        <i class="far fa-user" aria-hidden="true"></i> {{ $article->user->name }}
                    </small>
                </div>
            </div>
        </div>
    </div>
@endif
