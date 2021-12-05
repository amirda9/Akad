<?php

namespace App\Http\Controllers\Panel;

use App\Article;
use App\ArticleCategory;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view articles');
        $articles = Article::withCount(['comments', 'rates']);
        $dir = $request->dir == 'asc' ? 'asc' : 'desc';
        switch ($request->order) {
            case 'view': {
                    $articles = $articles->orderBy('views', $dir);
                    break;
                }
            case 'comment': {
                    $articles = $articles->orderBy('comments_count', $dir);
                    break;
                }
            case 'rate': {
                    $articles = $articles->orderBy('rates_count', $dir);
                    break;
                }
            default: {
                    $articles = $articles->orderBy('created_at', $dir);
                    break;
                }
        }
        if ($request->search) {
            $articles = $articles->where('title', 'like', "%$request->search%")
                ->orWhereHas('categories', function ($q) use ($request) {
                    $q->where('name', 'like', "%$request->search%");
                })->orWhere('id', $request->search);;
        }
        $articles = $articles->paginate();

        return view('panel.articles.index')->with([
            'articles' => $articles
        ]);
    }

    public function create()
    {
        $this->authorize('create article');
        $categories = ArticleCategory::where('parent_id', null)->orderBy('order', 'asc')->get();
        return view('panel.articles.create')->with('categories', $categories);
    }

    public function store(Request $request)
    {
        $this->authorize('create article');
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'short_description' => 'required|string|max:1000',
            'full_description' => 'nullable|string',
            'image' => 'nullable|file|image|max:1000',
            'published' => 'required|boolean',
            'can_comment' => 'nullable|boolean',
            'can_rate' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'tags' => 'nullable|string|max:2000',

        ], [], [
            'title' => 'عنوان',
            'slug' => 'اسلاگ',
            'short_description' => 'توضیحات کوتاه',
            'full_description' => 'توضیحات کامل',
            'image' => 'تصویر',
            'published' => 'وضعیت انتشار',
            'can_comment' => 'وضعیت نظرات',
            'can_rate' => 'وضعیت امتیاز',
            'tags' => 'برچسب ها',

        ]);

        $image = null;
        if ($request->image) {
            $image = $request->file('image')->store('images/articles', 'local');
        }

        $slug = remove_spec($request->title);

        if ($request->slug != null) {
            $slug = remove_spec($request->slug);
        }

        if (Article::whereSlug($slug)->count()) {
            $slug = $slug . '-' . time();
        }

        $article = Article::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'slug' => $slug,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'image' => $image,
            'published' => $request->published == 1,
            'can_comment' => $request->can_comment,
            'can_rate' => $request->can_rate,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        $article->categories()->sync($request->categories);


        if (!empty($request->get('tags'))) {
            $selected_tags = explode(',', $request->tags);
            $exists_tags = Tag::whereIn('title', $selected_tags)->get();
            $remain_tags = array_diff($selected_tags, $exists_tags->pluck('title')->toArray());
            $tags_id = $exists_tags->pluck('id')->toArray();
            foreach ($remain_tags as $remain_tag) {
                $tag = Tag::updateOrCreate([
                    'title' => $remain_tag
                ]);
                $tags_id[] = $tag->id;
            }
            $article->tags()->sync($tags_id);
        }



        return redirect()->route('panel.posts.articles.index')
            ->with('success', 'مقاله جدید با موفقیت اضافه شد');
    }

    public function show(Article $article)
    {
        $this->authorize('view articles');
        return view('panel.articles.show.index')->with([
            'article' => $article
        ]);
    }

    public function comments(Request $request, Article $article)
    {
        $this->authorize('view articles');
        $this->authorize('view comments');
        $comments = $article->comments();
        if ($request->search) {
            $comments = $comments->where(function ($q) use ($request) {
                $q->where('mobile', 'like', "%$request->search%")
                    ->orWhere('name', 'like', "%$request->search%")
                    ->orWhere('email', 'like', "%$request->search%");
            });
        }
        if ($request->type == 'published') {
            $comments = $comments->where('published', true);
        }
        if ($request->type == 'not_published') {
            $comments = $comments->where('published', false);
        }
        $comments = $comments->paginate();
        return view('panel.articles.show.comments')->with([
            'article' => $article,
            'comments' => $comments,
        ]);
    }

    public function rates(Article $article)
    {
        $this->authorize('view articles');
        $this->authorize('view rates');
        $rates = $article->rates()->orderBy('created_at', 'desc')->paginate();
        return view('panel.articles.show.rates')->with([
            'article' => $article,
            'rates' => $rates,
        ]);
    }

    public function edit(Article $article)
    {
        $this->authorize('edit article');
        $categories = ArticleCategory::where('parent_id', null)->orderBy('order', 'asc')->get();
        $selected_categories = $article->categories()->pluck('id')->toArray();
        return view('panel.articles.edit')->with([
            'article' => $article,
            'categories' => $categories,
            'selected_categories' => $selected_categories
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('edit article');
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'short_description' => 'required|string|max:1000',
            'full_description' => 'nullable|string',
            'image' => 'nullable|file|image|max:1000',
            'published' => 'required|boolean',
            'can_comment' => 'nullable|boolean',
            'can_rate' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'tags' => 'nullable|string|max:2000',

        ], [], [
            'title' => 'عنوان',
            'slug' => 'اسلاگ',
            'short_description' => 'توضیحات کوتاه',
            'full_description' => 'توضیحات کامل',
            'image' => 'تصویر',
            'published' => 'وضعیت انتشار',
            'can_comment' => 'وضعیت نظرات',
            'can_rate' => 'وضعیت امتیاز',
            'meta_title' => 'عنوان متا',
            'meta_description' => 'تضیحات متا',
            'tags' => 'برچسب ها',

        ]);


        $image = $article->image;
        if ($request->image) {
            File::delete($image);
            $image = $request->file('image')->store('images/articles', 'local');
        }

        $slug = $article->slug;
        if ($request->slug != $article->slug) {
            $slug = remove_spec($request->title);
            if ($request->slug != null) {
                $slug = remove_spec($request->slug);
            }
            if (Article::whereSlug($slug)->where('id', '<>', $article->id)->count()) {
                $slug = $slug . '-' . time();
            }
        }

        $article->update([
            'title' => $request->title,
            'slug' => $slug,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'image' => $image,
            'published' => $request->published == 1,
            'can_comment' => $request->can_comment,
            'can_rate' => $request->can_rate,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        $article->categories()->sync($request->categories);

        if (!empty($request->get('tags'))) {
            $selected_tags = explode(',', $request->tags);
            $exists_tags = Tag::whereIn('title', $selected_tags)->get();
            $remain_tags = array_diff($selected_tags, $exists_tags->pluck('title')->toArray());
            $tags_id = $exists_tags->pluck('id')->toArray();
            foreach ($remain_tags as $remain_tag) {
                $tag = Tag::updateOrCreate([
                    'title' => $remain_tag
                ]);
                $tags_id[] = $tag->id;
            }
            $article->tags()->sync($tags_id);
        }

        return redirect()->route('panel.posts.articles.index')
            ->with('success', 'مقاله جدید با موفقیت اضافه شد');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete article');
        if ($article->image) {
            File::delete($article->image);
        }
        $article->delete();
        return redirect()->route('panel.posts.articles.index')
            ->with('success', 'مقاله مورد نظر شما با موفقیت حذف شد');
    }

    public function deleteImage(Article $article)
    {
        $this->authorize('edit article');
        if ($article->image) {
            File::delete($article->image);
        }
        $article->update([
            'image' => null
        ]);
        return redirect()->route('panel.posts.articles.index')->with('success', 'تصویر شاخص مورد نظر شما با موفقیت حذف شد');
    }
}
