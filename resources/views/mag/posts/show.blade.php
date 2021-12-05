@extends('layouts.app')

@section('meta')
    @include('components.meta',[
        'title' => getOption('site_information.website_name',config('settings.website_name')) . ' | ' . $article->title,
        'description' => $article->meta_description ?: ($article->short_description ?: getOption('site_information.description',config('settings.meta_description'))),
        'url' => $article->getRoute()
    ])
@endsection
@section('title')
     <title>{{ getOption('site_information.website_name',config('settings.website_name')) .' | ' . ($article->meta_title ?: $article->title) }}</title>
@endsection

@section('content')
    <div class="container py-3">
         {{ Breadcrumbs::render('article', $article) }}
        @include('components.messages')
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="">
                    <div class="article-container p-4 bg-white shadow-sm">
                        <div class="">
                            <div class="d-flex flex-row align-items-center mb-4">
                                <h1 class="text-dark flex-grow-1" style="font-size:26px;">{{$article->title}}</h1>
                                <div class="fa-num text-gray-600 dir-ltr text-nowrap d-none d-sm-block">
                                    <span><i class="fal fa-star"></i> {{ $article->rate }}</span>
                                    <span class="ml-3"><i class="fal fa-comment"></i> {{ $article->comments_count }}</span>
                                </div>
                            </div>
                            <div class="text-gray-500 mb-4 d-flex flex-row align-items-center flex-wrap">
                                <div class="flex-grow-1">
                                    <div class="d-inline ml-5">
                                        <i class="fal fa-user ml-1"></i>
                                        <span>{{ $article->user->name }}</span>
                                    </div>
                                    <div class="d-inline ml-4">
                                        <i class="fal fa-angle-left ml-1"></i>
                                        @foreach($article->categories as $selected_article_category)
                                            @if(!$loop->first)
                                                <span> | </span>
                                            @endif
                                            <a class="text-gray-500" href="{{ $selected_article_category->getRoute() }}">{{ $selected_article_category->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <span class="text-nowrap">
                            <i class="fal fa-clock ml-1"></i>
                            {{ jd($article->created_at,'d F Y | G:i') }}
                        </span>
                            </div>
                        </div>
                        <div class="article-content mt-2">
                            @if($article->image)
                                <img class="w-100 mb-4" style="max-height: 400px; object-fit: cover" src="{{ getImageSrc($article->image) }}" />
                            @endif
                            <div class="article-short-description text-justify mb-4">
                                {!!$article->short_description!!}
                            </div>
                            <div class="article-full-description text-justify">
                                {!!$article->full_description!!}
                            </div>
                        </div>

                        @if($article->tags->count())
                        <div class="pt-3 border-top text-gray-500 fa-num mt-4">
                            @foreach($article->tags as $article_tag)
                                <a class="btn btn-sm btn-light text-gray-500 rounded-5 mb-1" style="min-width:75px;" href="{{ $article_tag->getRoute() }}" target="_blank">
                                    {{ $article_tag->title }}
                                </a>
                            @endforeach
                        </div>
                    @endif


                        @if($article->isRateable())
                            <hr class="my-5"/>
                            <div class="article-rate">
                                <form class="d-flex flex-row" action="{{route('mag.articles.rate' , $article->slug)}}" method="post">
                                    <strong class="text-secondary ml-3" style="font-size:20px;">ثبت امتیاز : </strong>
                                    @csrf
                                    <input type="hidden" id="rate" name="rate" >
                                    <div id="articleRateContainer" class="align-middle dir-ltr d-inline">
                                        <div class="position-relative d-flex">
                                            <i data-value="1" class="fas fa-star rateItemButton fa-2x cursor-pointer text-gray-300"></i>
                                            <i data-value="2" class="fas fa-star rateItemButton fa-2x cursor-pointer text-gray-300"></i>
                                            <i data-value="3" class="fas fa-star rateItemButton fa-2x cursor-pointer text-gray-300"></i>
                                            <i data-value="4" class="fas fa-star rateItemButton fa-2x cursor-pointer text-gray-300"></i>
                                            <i data-value="5" class="fas fa-star rateItemButton fa-2x cursor-pointer text-gray-300"></i>
                                            <div class="d-flex overflow-hidden position-absolute rateResult" style="width : {{ $article->rate * 100 / 5 }}%">
                                                <i class="fas fa-star fa-2x cursor-pointer text-gold"></i>
                                                <i class="fas fa-star fa-2x cursor-pointer text-gold"></i>
                                                <i class="fas fa-star fa-2x cursor-pointer text-gold"></i>
                                                <i class="fas fa-star fa-2x cursor-pointer text-gold"></i>
                                                <i class="fas fa-star fa-2x cursor-pointer text-gold"></i>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                        @if($comments->count())
                            <hr class="my-5"/>
                            <div>
                                <h4 class="text-secondary fa-num mb-4">نظرات : ({{ $comments->count() }})</h4>
                                @foreach($comments as $comment)
                                    <div class="p-3 border rounded {{ $loop->last ? '' : 'mb-4' }}">
                                        <div class="text-gray-500 mb-4">
                                            <span class="d-inline-block"><i class="fal fa-user"></i> {{$comment->name}}</span>
                                            <span class="mr-4 d-inline-block"><i class="fal fa-clock"></i> {{ jd($comment->created_at,'d F Y | G:i') }}</span>
                                        </div>
                                        <p class="text-justify m-0">{{ $comment->content }}</p>
                                        @if($comment->reply)
                                            <p class="p-3 rounded border-right border-3 m-0 mt-3 bg-light">{{ $comment->reply }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if($article->isCommentable())
                            <hr class="my-5"/>
                            <div>
                                <h4 class="text-secondary mb-4">ثبت نظر : </h4>
                                <form action="{{route('mag.articles.submitComment',$article->slug)}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <input
                                                    autocomplete="off"
                                                    type="text"
                                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                    id="name"
                                                    required
                                                    placeholder="نام *"
                                                    name="name"
                                                    value="{{ old('name') }}"
                                                >
                                            </div>
                                            <div class="form-group">
                                                <input
                                                    autocomplete="off"
                                                    type="text"
                                                    class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}"
                                                    id="mobile"
                                                    placeholder="موبایل"
                                                    name="mobile"
                                                    value="{{ old('mobile') }}"
                                                >
                                            </div>
                                            <div class="form-group">
                                                <input
                                                    autocomplete="off"
                                                    type="email"
                                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                    id="email"
                                                    name="email"
                                                    placeholder="ایمیل"
                                                    value="{{ old('email') }}"
                                                >
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group rounded overflow-hidden">
                                                    <input placeholder="کپچا *"
                                                           type="text" name="captcha" required
                                                           class="form-control">
                                                    <div class="input-group-append">
                                                        <div class="captcha-container" style="cursor:pointer;">
                                                            {!! captcha_img('simple') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-8">
                                            <div class="form-group">
                                                <textarea required name="content" class="form-control" id="" placeholder="متن نظر" rows="5"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">ثبت نظر</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                @if($related_articles->count())
                    <div class="bg-white shadow-sm p-3 mb-4">
                        <h5 class="mb-4">مقالات مشابه</h5>
                        @foreach($related_articles as $related_article)
                            <a class="d-flex flex-row text-decoration-none text-gray-600 {{ $loop->last ? '' : 'mb-4' }}" href="{{ $related_article->getRoute() }}">
                                @if($related_article->image)
                                    <img src="{{ getImageSrc($related_article->image,'avatar') }}"
                                         style="width:60px; height: 60px; border-radius: 30px; object-fit: cover"/>
                                @endif
                                <div class="mr-3">
                                    <span>{{ $related_article->title }}</span>
                                    <div class="text-gray-400">{{ jd($related_article->created_at,'d F Y | G:i') }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
                @if($latest_articles->count())
                    <div class="bg-white shadow-sm p-3 mb-4">
                        <h5 class="mb-4">آخرین مقالات</h5>
                        @foreach($latest_articles as $latest_article)
                            <a class="d-flex flex-row text-decoration-none text-gray-600 {{ $loop->last ? '' : 'mb-4' }}" href="{{ $latest_article->getRoute() }}">
                                @if($latest_article->image)
                                    <img src="{{ getImageSrc($latest_article->image,'avatar') }}"
                                         style="width:60px; height: 60px; border-radius: 30px; object-fit: cover"/>
                                @endif
                                <div class="mr-3">
                                    <span>{{ $latest_article->title }}</span>
                                    <div class="text-gray-400">{{ jd($latest_article->created_at,'d F Y | G:i') }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
                @if($latest_products->count())
                    <div class="bg-white shadow-sm p-3 mb-4">
                        <h5 class="mb-4">آخرین محصولات</h5>
                        @foreach($latest_products as $latest_product)
                            <a class="d-flex flex-row text-decoration-none text-gray-600 {{ $loop->last ? '' : 'mb-4' }}" href="{{ $latest_product->getRoute() }}">
                                @if($latest_product->image)
                                    <img src="{{ getImageSrc($latest_product->image,'avatar') }}"
                                         style="width:60px; height: 60px; border-radius: 30px; object-fit: cover"/>
                                @endif
                                <div class="mr-3">
                                    <span>{{ $latest_product->title }}</span>
                                    <div class="text-gray-400">{{ jd($latest_product->created_at,'d F Y | G:i') }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        $('body').on('click','.captcha-container',() => {
            refreshCaptcha();
        })
        function refreshCaptcha(){
            $.ajax({
                url: "{{ route('captcha.refresh') }}",
                type: 'get',
                dataType: 'html',
                success: function(json) {
                    $('.captcha-container').html(json);
                },
                error: function(data) {
                    alert('Try Again.');
                }
            });
        }
    </script>
    <script>
         $('.rateItemButton').mouseenter(function(){
            var value = $(this).data('value');
            $(this).parent().find('.rateItemButton').each(function() {
                if($(this).data('value') > value) {
                    $(this).removeClass('fas').addClass('far');
                } else {
                    $(this).addClass('fas').removeClass('far');
                }
            });
        })

        $('.rateItemButton').mouseout(function(){
            value = $(this).parent().find('input[type="hidden"]').val();
            $(this).parent().find('.rateItemButton').each(function() {
                if($(this).data('value') > value) {
                    $(this).removeClass('fas').addClass('far');
                } else {
                    $(this).addClass('fas').removeClass('far');
                }
            });
        })

        $('.rateItemButton').click(function(){
            var value = $(this).data('value');
            var form = $(this).closest('form');

            form.find('input[name="rate"]').val(value);

            var url = form.attr('action');
            $.post(url, form.serialize()).done(function( data ) {
                $('#snackMessageContainer .ajaxSuccess .message').html(data.message);
                $('#snackMessageContainer .ajaxSuccess').addClass('show');
                $('#articleRateContainer .rateResult').width(`${data.rate/5*100}%`);
            }).fail(function( data ) {
                console.log('error');
            });
        })

    </script>

@endsection
