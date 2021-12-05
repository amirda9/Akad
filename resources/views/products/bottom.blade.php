@if($product ?? false)
    @if($product->can_comment || $product->can_rate)
        <div class="bg-white rounded p-3 shadow-sm">
            @if($product->can_rate)
                <div class="product-rate py-4">
                    <form class="d-flex flex-row" action="{{route('products.rate' , $product)}}" method="post">
                        <strong class="text-secondary ml-3" style="font-size:20px;">ثبت امتیاز : </strong>
                        @csrf
                        <input type="hidden" id="rate" name="rate" >
                        <div id="productRateContainer" class="align-middle dir-ltr d-inline">
                            <div class="position-relative d-flex">
                                <i data-value="1" class="fas fa-star rateItemButton fa-2x cursor-pointer text-gray-300"></i>
                                <i data-value="2" class="fas fa-star rateItemButton fa-2x cursor-pointer text-gray-300"></i>
                                <i data-value="3" class="fas fa-star rateItemButton fa-2x cursor-pointer text-gray-300"></i>
                                <i data-value="4" class="fas fa-star rateItemButton fa-2x cursor-pointer text-gray-300"></i>
                                <i data-value="5" class="fas fa-star rateItemButton fa-2x cursor-pointer text-gray-300"></i>
                                <div class="d-flex overflow-hidden position-absolute rateResult" style="width : {{ $product->rate * 100 / 5 }}%">
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
            @if($product->comments_count > 0)
                <div class="py-4">
                    <h4 class="text-secondary fa-num mb-4">نظرات : ({{ $product->comments_count }})</h4>
                    @foreach($product->comments as $comment)
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
            @if($product->can_comment)
                <div class="py-4">
                    <h4 class="text-secondary mb-4">ثبت نظر : </h4>
                    <form action="{{route('products.submitComment',$product)}}" method="post">
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
    @endif
@endif
