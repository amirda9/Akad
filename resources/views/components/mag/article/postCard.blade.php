@if($article)
    <div class="w-100 overflow-hidden shadow-md-hover bg-white d-flex mb-4">
        <div class="w-100 position-relative d-flex flex-column flex-grow-1"
             style="margin-right: -1px;">
            <a href="{{ $article->getRoute() }}" class="d-block text-center p-2">
                <div class="article-post-card-image-container overflow-hidden d-flex flex-column ">
                    <img style="object-fit: cover"
                         src="{{ getImageSrc($article->getImage(),'mag_card') }}"
                         alt="{{ $article->title }}" />
                </div>
            </a>
            <div class="p-2 px-lg-3 d-flex flex-column flex-grow-1 ">
                <div class="flex-grow-1">
                    <a class="d-block mb-2 mb-lg-3 flex-grow-1 text-dark text-decoration-none"
                       style="font-size: 16px;"
                        href="{{ $article->getRoute() }}">
                        {{ $article->title }}
                    </a>
                    <p class="text-secondary">
                        {{  str_limit($article->short_description , 100) }}
                    </p>

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
