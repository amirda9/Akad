<div class="card card-body p-2">
    <ul class="nav nav-pills nav-fill">
        <li class="nav-item">
            <a class="nav-link {{ checkActive(['panel.posts.articles.show']) ? 'active' : '' }}" href="{{ route('panel.posts.articles.show',$article) }}">جزئیات</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ checkActive(['panel.posts.articles.comments.index']) ? 'active' : '' }}" href="{{ route('panel.posts.articles.comments.index', $article) }}">نظرات</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ checkActive(['panel.posts.articles.rates']) ? 'active' : '' }}" href="{{ route('panel.posts.articles.rates', $article) }}">امتیازات</a>
        </li>
    </ul>
</div>
