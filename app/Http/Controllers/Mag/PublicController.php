<?php

namespace App\Http\Controllers\Mag;

use App\ArticleCategory;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    public function index()
    {
        $article_categories = ArticleCategory::orderBy('order','asc')->with(['articles' => function($q) {
            $q->published()->orderBy('created_at','desc')->take(10);
        }])->whereHas('articles',function($q) {
            $q->published();
        })->get();
        return view('mag.index')->with([
            'article_categories' => $article_categories
        ]);
    }
}
