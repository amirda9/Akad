<?php

namespace App\Http\Controllers\Mag;

use App\Article;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{

    public function show(Request $request, $slug)
    {
        $article = Article::published($slug)->with('categories')->withCount('comments')->firstOrFail();
        $article->increment('views');
        $comments = $article->comments()->orderBy('created_at', 'asc')->where('published', true)->paginate();

        $category_ids = $article->categories->pluck('id')->toArray();
        $related_articles = Article::published()->where('id', '<>', $article->id)
            ->whereHas('categories', function ($q) use ($category_ids) {
                $q->whereIn('id', $category_ids);
            })->take(5)->get();

        $latest_products = Product::published()->orderBy('created_at', 'desc')->take(6)->get();

        $exclude_from_latest = $related_articles->pluck('id')->toArray();
        $exclude_from_latest[] = $article->id;
        $latest_articles = Article::published()->orderBy('created_at', 'desc')
            ->whereNotIn('id', $exclude_from_latest)
            ->take(5)->get();

        return view('mag.posts.show')->with([
            'article' => $article,
            'comments' => $comments,
            'related_articles' => $related_articles,
            'latest_articles' => $latest_articles,
            'latest_products' => $latest_products,
        ]);
    }

    public function rate(Request  $request, $slug)
    {
        $article = Article::whereSlug($slug)->firstOrFail();
        $article->rates()->where('ip', $request->ip())->delete();
        $article->rates()->create([
            'rate' => $request->rate,
            'ip' => $request->ip(),
        ]);
        return response([
            'rate' => $article->rate,
            'message' => 'امتیاز شما با موفقیت ثبت شد'
        ]);
    }

    public function submitComment(Request $request, $slug)
    {
        $article = Article::whereSlug($slug)->firstOrFail();
        $request->merge([
            'mobile' => convertNumbers($request->mobile, false)
        ]);
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|regex:/^09\d{9}$/',
            'email' => 'nullable|email',
            'content' => 'required|max:2000',
            'captcha' => 'required|captcha'
        ], [], [
            'name' => 'نام',
            'mobile' => 'شماره تماس',
            'email' => 'ایمیل',
            'content' => 'متن نظر',
            'captcha' => 'کپچا',
        ]);
        $user = Auth::user();
        $article->comments()->create([
            'user_id' => $user->id,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'content' => $request->get('content')
        ]);
        return redirect($article->getRoute())->with([
            'success' => 'نظر شما با موفقیت ثبت شد',
            'toast' => true
        ]);
    }
}
