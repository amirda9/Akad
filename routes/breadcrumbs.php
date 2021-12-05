<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('صفحه اصلی', route('index'));
});
Breadcrumbs::for('search', function ($trail, $q) {
    $trail->parent('home');
    $trail->push($q ? 'جستجو "' . str_limit($q,30) . '"' : 'جستجو', route('search'));
});
Breadcrumbs::for('mag', function ($trail) {
    $trail->parent('home');
    $trail->push('مجله', route('mag.index'));
});
Breadcrumbs::for('cart.show', function ($trail) {
    $trail->parent('home');
    $trail->push('سبد خرید', route('cart.show'));
});
Breadcrumbs::for('cart.checkout', function ($trail) {
    $trail->parent('cart.show');
    $trail->push('ثبت سفارش', route('cart.checkout'));
});
Breadcrumbs::for('products.all', function ($trail) {
    $trail->parent('home');
    $trail->push('فروشگاه', route('products.all'));
});
Breadcrumbs::for('tags', function ($trail,$tag) {
    $trail->parent('products.all');
    $trail->push("برچسب: $tag->title",route('tags',$tag));
});
Breadcrumbs::for('category', function ($trail, $category) {
    if($category->parent_id) {
        $trail->parent('category',$category->parent);
        $trail->push($category->name, $category->getRoute());
    } else {
        $trail->parent('products.all');
        $trail->push($category->name, $category->getRoute());
    }
});
Breadcrumbs::for('article_category', function ($trail, $category) {
    if($category->parent_id) {
        $trail->parent('article_category',$category->parent);
        $trail->push($category->name, $category->getRoute());
    } else {
        $trail->parent('home');
        $trail->push($category->name, $category->getRoute());
    }
});
Breadcrumbs::for('product', function ($trail, $product) {
    $trail->parent('category',$product->categories()->first());
    $trail->push($product->title, $product->getRoute());
});
Breadcrumbs::for('article', function ($trail, $article) {
    $trail->parent('category',$article->categories()->first());
    $trail->push($article->title, $article->getRoute());
});

Breadcrumbs::for('pages.show', function ($trail, $page) {
    $trail->parent('home');
    $trail->push($page->title, $page->getRoute());
});

Breadcrumbs::for('orders.index', function ($trail) {
    $trail->parent('home');
    $trail->push('جستجو سفارش', route('orders.index'));
});

Breadcrumbs::for('orders.show', function ($trail, \App\Order $order) {
    $trail->parent('orders.index');
    $trail->push('مشاهده سفارش', route('orders.show',$order->code));
});
