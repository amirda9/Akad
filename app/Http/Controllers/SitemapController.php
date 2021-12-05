<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleCategory;
use App\Brand;
use App\Page;
use App\ProductCategory;
use App\Tag;
use Illuminate\Http\Request;
use App\Product;

class SitemapController extends Controller
{
    public function index()
    {
        $product = Product::published()->latest()->first();
        $page = Page::published()->latest()->first();
        $category = ProductCategory::latest()->first();
        $tag = Tag::whereHas('products',function($q) {
            $q->published();
        })->latest()->first();
        $latest_branded_product = Product::published()->whereHas('brand')->latest()->first();
        $latest_article_category = ArticleCategory::whereHas('articles',function ($q) {
            $q->published();
        })->latest()->first();
        $latest_article = Article::published()->latest()->first();


        return response()->view('sitemap.index', [
            'product' => $product,
            'category' => $category,
            'page' => $page,
            'tag' => $tag,
            'latest_branded_product' => $latest_branded_product,
            'latest_article_category' => $latest_article_category,
            'latest_article' => $latest_article,
        ])->header('Content-Type', 'text/xml');
    }

    public function products()
    {
        $products = Product::published()->latest()->get();
        return response()->view('sitemap.products', [
            'products' => $products,
        ])->header('Content-Type', 'text/xml');
    }

    public function images()
    {
        $products = Product::published()->with('images')->latest()->get();
        return response()->view('sitemap.images', [
            'products' => $products,
        ])->header('Content-Type', 'text/xml');
    }

    public function categories()
    {
        $categories = ProductCategory::latest()->get();
        return response()->view('sitemap.categories', [
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml');
    }


    public function pages()
    {
        $pages = Page::published()->latest()->get();
        return response()->view('sitemap.pages', [
            'pages' => $pages,
        ])->header('Content-Type', 'text/xml');
    }

    public function tags()
    {
        $tags = Tag::whereHas('products',function($q) {
            $q->published();
        })->latest()->get();
        return response()->view('sitemap.tags', [
            'tags' => $tags,
        ])->header('Content-Type', 'text/xml');
    }

    public function brands()
    {
        $brands = Brand::whereHas('products',function($q) {
            $q->published();
        })->latest()->get();
        return response()->view('sitemap.brands', [
            'brands' => $brands,
        ])->header('Content-Type', 'text/xml');
    }
    public function articleCategories()
    {
        $articleCategories = ArticleCategory::whereHas('articles',function($q) {
            $q->published();
        })->latest()->get();
        return response()->view('sitemap.articleCategories', [
            'articleCategories' => $articleCategories,
        ])->header('Content-Type', 'text/xml');
    }
    public function articles()
    {
        $articles = Article::published()->latest()->get();
        return response()->view('sitemap.articles', [
            'articles' => $articles,
        ])->header('Content-Type', 'text/xml');
    }


}
