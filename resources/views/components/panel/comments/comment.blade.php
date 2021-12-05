@if($comment ?? false)
    @switch($comment->commentable_type)
        @case('App\Article')
            @include('components.panel.comments.article',['comment' => $comment])
            @break
        @case('App\Product')
            @include('components.panel.comments.product',['comment' => $comment])
            @break
    @endswitch
@endif
