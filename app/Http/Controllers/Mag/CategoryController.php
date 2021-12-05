<?php

namespace App\Http\Controllers\Mag;

use App\Article;
use App\ArticleCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, $slug)
    {
        $category = ArticleCategory::whereSlug($slug)->firstOrFail();
        $category->increment('views');
        $categories_ids = getCategoryChildren($category);
        $articles = Article::whereHas('categories',function($q) use($categories_ids){
            $q->whereIn('id',$categories_ids);
        })->paginate(20);
        return view('mag.categories.show')->with([
            'articles' => $articles,
            'category' => $category,
        ]);
    }
}
