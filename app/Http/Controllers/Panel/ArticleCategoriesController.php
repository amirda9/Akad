<?php

namespace App\Http\Controllers\Panel;

use App\ArticleCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ArticleCategoriesController extends Controller
{

    public function index()
    {
        $this->authorize('view article categories');
        if(request('search')) {
            $categories = ArticleCategory::where('name','LIKE','%'.request('search').'%');
            $categories = $categories->paginate();
            $categories->appends(request()->query());
        } else {
            $list = [];
            getArticleCategoriesList($list);
            $list = collect($list);
            $categories = paginate($list);
            $categories->appends(request()->query());
            $categories->withPath(request()->url());
        }

        return view('panel.articleCategories.index')->with([
            'categories' => $categories
        ]);
    }


    public function create()
    {
        $this->authorize('create article category');
        $categories = ArticleCategory::where('parent_id',null)->orderBy('order','asc')->get();

        return view('panel.articleCategories.create')->with('categories',$categories);
    }



    public function store(Request $request)
    {
        $this->authorize('create article category');
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'image' => 'nullable|file|image|max:500',
            'icon' => 'nullable|file|image|max:500',
            'parent' => 'nullable|exists:article_categories,id',
            'order' => 'nullable|numeric',
            'description' => 'nullable|string|max:1000',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ],[],[
            'name' => 'نام دسته بندی',
            'slug' => 'اسلاگ',
            'image' => 'تصویر دسته بندی',
            'icon' => 'آیکن دسته بندی',
            'parent' => 'دسته بندی والد',
            'order' => 'ترتیب نمایش',
            'description' => 'توضیحات',
        ]);

        $slug = remove_spec($request->name);
        if($request->slug) {
            $slug = remove_spec($request->slug);
        }
        if(ArticleCategory::where('slug',$slug)->count()) {
            $slug = $slug . '-' . time();
        }

        $image = null;
        if($request->image) {
            $image = $request->file('image')->store('images/articlesCategories');
        }
        $icon = null;
        if($request->icon) {
            $icon = $request->file('icon')->store('images/articlesCategories');
        }

        ArticleCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $image,
            'icon' => $icon,
            'parent_id' => $request->parent,
            'order' => $request->order ?: 0,
            'description' => $request->description ,
            'meta_title' => $request->meta_title ,
            'meta_description' => $request->meta_description ,
        ]);

        return redirect()->route('panel.posts.categories.index')
            ->with([
                'success' => 'دسته بندی جدید اضافه شد'
            ]);

    }



    public function show(ArticleCategory $category)
    {
        $this->authorize('view article categories');
        return view('panel.articleCategories.show')
            ->with([
                'category' => $category
            ]);
    }



    public function edit(ArticleCategory $category)
    {
        $this->authorize('edit article category');
        $categories = ArticleCategory::where('parent_id',null)
            ->where('id','<>',$category->id)
            ->orderBy('order','asc')
            ->get();
        return view('panel.articleCategories.edit')
            ->with([
                'categories' => $categories,
                'category' => $category
            ]);
    }



    public function update(Request $request,ArticleCategory $category)
    {
        $this->authorize('edit article category');

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'image' => 'nullable|file|image|max:500',
            'icon' => 'nullable|file|image|max:500',
            'parent' => 'nullable|exists:article_categories,id',
            'order' => 'nullable|numeric',
            'description' => 'nullable|string|max:1000',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ],[],[
            'name' => 'نام دسته بندی',
            'slug' => 'اسلاگ',
            'image' => 'تصویر دسته بندی',
            'icon' => 'آیکن دسته بندی',
            'parent' => 'دسته بندی والد',
            'order' => 'ترتیب نمایش',
            'description' => 'توضیحات',
        ]);

        $slug = $category->slug;
        if($slug != $request->slug) {
            $slug = remove_spec($request->name);
            if($request->slug) {
                $slug = remove_spec($request->slug);
            }
            if(ArticleCategory::where('slug',$slug)->where('id','<>',$category->id)->count()) {
                $slug = $slug . '-' . time();
            }
        }

        if($category->parent_id != $request->parent){
            if($request->parent) {
                if($request->parent == $category->id) {
                    return back()->withInput()->withErrors(['parent' => 'دسته بندی والد انتخاب شده نامعتبر است']);
                }
                $parent = ArticleCategory::find($request->parent);
                if($parent->hasParent($category->id)){
                    return back()->withInput()->withErrors(['parent' => 'دسته بندی والد انتخاب شده نامعتبر است']);
                }
            }
        }

        $image = $category->image;
        if($request->image) {
            File::delete($image);
            $image = $request->file('image')->store('images/articleCategories');
        }
        $icon = $category->icon;
        if($request->icon) {
            File::delete($icon);
            $icon = $request->file('icon')->store('images/articleCategories');
        }
        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $image,
            'icon' => $icon,
            'parent_id' => $request->parent,
            'order' => $request->order ?: 0,
            'description' => $request->description,
            'meta_title' => $request->meta_title ,
            'meta_description' => $request->meta_description ,
        ]);

        return redirect()->route('panel.posts.categories.index')
            ->with([
                'success' => 'تغییرات ذخیره شد'
            ]);
    }



    public function destroy(ArticleCategory $category)
    {
        $this->authorize('delete article category');
        if($category->articles()->count()) {
            return redirect()->route('panel.posts.categories.index')
                ->withErrors('ابتدا محصولات های این دسته بندی را حذف کنید');
        }
        $category->children()->update([
            'parent_id' => $category->parent_id
        ]);
        File::delete([$category->image,$category->icon]);
        $category->delete();
        return redirect()->route('panel.posts.categories.index')
            ->with([
                'success' => 'دسته بندی مورد نظر حذف شد'
            ]);
    }

    public function deleteImage(ArticleCategory $category)
    {
        $this->authorize('edit article category');
        File::delete($category->image);
        $category->update([
            'image' => null
        ]);
        return redirect()->route('panel.posts.categories.show',$category)
            ->with([
                'success' => 'تصویر دسته بندی با موفقیت حذف شد'
            ]);
    }

    public function deleteIcon(ArticleCategory $category)
    {
        $this->authorize('edit article category');
        File::delete($category->icon);
        $category->update([
            'icon' => null
        ]);
        return redirect()->route('panel.posts.categories.show',$category)
            ->with([
                'success' => 'آیکن دسته بندی با موفقیت حذف شد'
            ]);
    }
}
