<?php

namespace App\Http\Controllers\Panel;

use App\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ProductCategoryController extends Controller
{

    public function index()
    {
        $this->authorize('view product categories');

        if(request('search')) {
            $categories = ProductCategory::where('name','LIKE','%'.request('search').'%');
            $categories = $categories->paginate();
            $categories->appends(request()->query());
        } else {
            $list = [];
            getProductCategoriesList($list);
            $list = collect($list);
            $categories = paginate($list);
            $categories->appends(request()->query());
            $categories->withPath(request()->url());
        }

        return view('panel.productCategories.index')->with([
            'categories' => $categories
        ]);
    }


    public function create()
    {
        $this->authorize('create product category');
        $categories = ProductCategory::where('parent_id',null)->orderBy('order','asc')->get();

        return view('panel.productCategories.create')->with('categories',$categories);
    }


    public function store(Request $request)
    {
        $this->authorize('create product category');
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'image' => 'nullable|file|image|max:500',
            'icon' => 'nullable|file|image|max:500',
            'parent' => 'nullable|exists:product_categories,id',
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
        if(ProductCategory::where('slug',$slug)->count()) {
            $slug = $slug . '-' . time();
        }

        $image = null;
        if($request->image) {
            $image = $request->file('image')->store('images/categories');
        }
        $icon = null;
        if($request->icon) {
            $icon = $request->file('icon')->store('images/categories');
        }

        ProductCategory::create([
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

        return redirect()->route('panel.productCategories.index')
            ->with([
                'success' => 'دسته بندی جدید اضافه شد'
            ]);

    }


    public function show(ProductCategory $productCategory)
    {
        $this->authorize('view product categories');
        return view('panel.productCategories.show')
            ->with([
                'category' => $productCategory
            ]);
    }


    public function edit(ProductCategory $productCategory)
    {
        $this->authorize('edit product category');
        $categories = ProductCategory::where('parent_id',null)
            ->where('id','<>',$productCategory->id)
            ->orderBy('order','asc')
            ->get();
        return view('panel.productCategories.edit')
            ->with([
                'categories' => $categories,
                'category' => $productCategory
            ]);
    }


    public function update(Request $request, ProductCategory $productCategory)
    {
        $this->authorize('edit product category');

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'image' => 'nullable|file|image|max:500',
            'icon' => 'nullable|file|image|max:500',
            'parent' => 'nullable|exists:product_categories,id',
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

        $slug = $productCategory->slug;
        if($slug != $request->slug) {
            $slug = remove_spec($request->name);
            if($request->slug) {
                $slug = remove_spec($request->slug);
            }
            if(ProductCategory::where('slug',$slug)->where('id','<>',$productCategory->id)->count()) {
                $slug = $slug . '-' . time();
            }
        }

        if($productCategory->parent_id != $request->parent){
            if($request->parent) {
                if($request->parent == $productCategory->id) {
                    return back()->withInput()->withErrors(['parent' => 'دسته بندی والد انتخاب شده نامعتبر است']);
                }
                $parent = ProductCategory::find($request->parent);
                if($parent->hasParent($productCategory->id)){
                    return back()->withInput()->withErrors(['parent' => 'دسته بندی والد انتخاب شده نامعتبر است']);
                }
            }
        }

        $image = $productCategory->image;
        if($request->image) {
            File::delete($image);
            $image = $request->file('image')->store('images/categories');
        }
        $icon = $productCategory->icon;
        if($request->icon) {
            File::delete($icon);
            $icon = $request->file('icon')->store('images/categories');
        }
        $productCategory->update([
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

        return redirect()->route('panel.productCategories.index')
            ->with([
                'success' => 'تغییرات ذخیره شد'
            ]);
    }

    public function destroy(ProductCategory $productCategory)
    {
        $this->authorize('delete product category');
        if($productCategory->products()->count()) {
            return redirect()->route('panel.productCategories.index')
                ->withErrors('ابتدا محصولات های این دسته بندی را حذف کنید');
        }
        $productCategory->children()->update([
            'parent_id' => $productCategory->parent_id
        ]);
        File::delete([$productCategory->image,$productCategory->icon]);
        $productCategory->delete();
        return redirect()->route('panel.productCategories.index')
            ->with([
                'success' => 'دسته بندی مورد نظر حذف شد'
            ]);
    }

    public function deleteImage(ProductCategory $category)
    {
        $this->authorize('edit product category');
        File::delete($category->image);
        $category->update([
            'image' => null
        ]);
        return redirect()->route('panel.productCategories.show',$category)
            ->with([
                'success' => 'تصویر دسته بندی با موفقیت حذف شد'
            ]);
    }

    public function deleteIcon(ProductCategory $category)
    {
        $this->authorize('edit product category');
        File::delete($category->icon);
        $category->update([
            'icon' => null
        ]);
        return redirect()->route('panel.productCategories.show',$category)
            ->with([
                'success' => 'آیکن دسته بندی با موفقیت حذف شد'
            ]);
    }

}
