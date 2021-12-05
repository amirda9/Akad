@if($comment ?? false)
    <div class="bg-white p-1 border rounded shadow-sm comment-container {{ $comment->published ? 'published' : '' }}">
        <div class="row">
            <div class="col-12">
                <div class="p-2 bg-light rounded text-muted">
                    <div class="row">
                        <div class="col-12 col-lg-3">نام: {{ $comment->name ?: '---' }}</div>
                        <div class="col-12 col-lg-3">ایمیل: {{ $comment->email ?: '---' }}</div>
                        <div class="col-12 col-lg-3">موبایل: {{ $comment->mobile ?: '---' }}</div>
                        <div class="col-12 col-lg-3">تاریخ: {{ jd($comment->created_at) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="px-3 py-2">
                    <div>
                        @if($comment->title)
                            <span class="badge badge-pill badge-light">
                                <a href="{{ $comment->route }}" target="_blank">{{ $comment->title }}</a>
                            </span>
                        @endif
                        @if($comment->published)
                            <span class="badge badge-pill badge-success">منتشر شده</span>
                        @else
                            <span class="badge badge-pill badge-danger">منتشر نشده</span>
                        @endif
                        @if($comment->reply)
                            <span class="badge badge-pill badge-primary">پاسخ دارد</span>
                        @endif
                    </div>
                    <div class="py-2">
                        <p class="m-0">{{ $comment->content }}</p>
                        <div class="collapse" id="replyComment{{$comment->id}}">
                            <form method="post" action="{{ route('panel.comments.reply',$comment) }}">
                                @csrf
                                <textarea class="form-control mt-2" name="reply" placeholder="متن پاسخ را بنویسید">{{ $comment->reply }}</textarea>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-sm btn-success">ذخیره</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="p-2 text-left">
                    <button class="btn btn-sm btn-outline-primary" type="button" data-toggle="collapse" data-target="#replyComment{{$comment->id}}"
                            aria-expanded="false" aria-controls="replyComment{{$comment->id}}">
                        پاسخ
                    </button>
                    @if($comment->published)
                        <a href="{{ route('panel.comments.approve',$comment) }}"
                           class="btn btn-sm btn-outline-secondary">عدم انتشار</a>
                    @else
                        <a href="{{ route('panel.comments.approve',$comment) }}"
                           class="btn btn-sm btn-outline-success">انتشار</a>
                    @endif
                    <form class="d-inline-block" action="{{ route('panel.comments.destroy',$comment) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit"
                           onclick="return confirm('آیا مطمئن هستید؟')"
                           class="btn btn-sm btn-outline-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
