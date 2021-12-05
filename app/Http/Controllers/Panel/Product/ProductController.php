<?php

namespace App\Http\Controllers\Panel\Product;

use App\AttributeGroup;
use App\Brand;
use App\Events\Product\ProductCreated;
use App\Events\Product\ProductDeleted;
use App\Events\Product\ProductUpdated;
use App\Listeners\Product\ProductDeletedListener;
use App\Product;
use App\ProductCategory;
use App\ProductImage;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view products');
        $list = getCategoryChildren();
        $order = 'created_at';
        switch ($request->order) {
            case 'date': {
                    $order = 'created_at';
                    break;
                }
            case 'price': {
                    $order = 'regular_price';
                    break;
                }
            case 'views': {
                    $order = 'views';
                    break;
                }
            default: {
                    $order = 'created_at';
                }
        }
        $direction = $request->direction == 'asc' ? 'asc' : 'desc';

        $products = Product::orderBy($order, $direction);

        if ($request->title) {
            $products = $products->where('title', 'LIKE', '%' . $request->title . '%');
        }

        if ($request->category) {
            $category = ProductCategory::findOrFail($request->category);
            $list = getCategoryChildren($category);
            $products = $products->whereHas('categories', function ($q) use ($list) {
                $q->whereIn('id', $list);
            });
        }

        if ($request->status) {
            if ($request->status == 'published') {
                $products = $products->where('published', true);
            }
            if ($request->status == 'unpublished') {
                $products = $products->where('published', false);
            }
        }
        if ($request->featured) {
            if ($request->featured == 'featured') {
                $products = $products->where('is_featured', true);
            }
            if ($request->featured == 'not_featured') {
                $products = $products->where('is_featured', false);
            }
        }

        $products = $products->paginate();
        $products->appends(request()->query());

        $categories = ProductCategory::where('parent_id', null)->orderBy('order', 'asc')->get();

        return view('panel.products.index')->with([
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $this->authorize('create product');
        $categories = ProductCategory::where('parent_id', null)->orderBy('order', 'asc')->get();
        $brands = Brand::orderBy('order', 'asc')->get();
        $attribute_groups = AttributeGroup::orderBy('order', 'asc')->with(['attributes' => function ($q) {
            $q->orderBy('order', 'asc');
        }])->get();
        return view('panel.products.create', [
            'categories' => $categories,
            'brands' => $brands,
            'attribute_groups' => $attribute_groups,
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create product');
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'categories' => 'required|array',
            'categories.*' => 'exists:product_categories,id',
            'brand' => 'nullable|exists:brands,id',
            'short_description' => 'nullable|string|max:2000',
            'full_description' => 'nullable|string',
            'product_type' => ['required', Rule::in(array_keys(Product::$types))],
            'regular_price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:regular_price',
            'sku' => 'nullable|unique:products,sku|unique:variations,sku|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
            'min_stock' => 'nullable|numeric|min:0',
            'stock_status' => 'required|string|in:instock,outofstock',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|max:500',
            'image' => 'nullable|file|image|max:2000',
            'gallery' => 'nullable|array',
            'gallery.*' => 'file|image|max:2000',
            'tags' => 'nullable|string|max:2000',
        ], [], [
            'title' => 'عنوان محصول',
            'slug' => 'آدرس محصول',
            'categories' => 'دسته بندی ها',
            'categories.*' => 'دسته بندی',
            'brand' => 'برند',
            'short_description' => 'توضیحات کوتاه',
            'full_description' => 'توضیحات کامل',
            'product_helper' => 'راهنمای محصول',
            'product_type' => 'نوع محصول',
            'regular_price' => 'قیمت اصلی',
            'sale_price' => 'قیمت فروش فوق العاده',
            'sku' => 'کد محصول',
            'weight' => 'وزن',
            'stock' => 'موجودی',
            'min_stock' => 'حداقل موجودی',
            'stock_status' => 'وضعیت انبار',
            'meta_title' => 'عنوان متا',
            'meta_description' => 'توضیحات متا',
            'image' => 'تصویر اصلی',
            'gallery' => 'گالری تصاویر',
            'gallery.*' => 'تصویر گالری',
            'tags' => 'برچسب ها',
        ]);

        $image = null;
        $gallery = [];
        $date = new Carbon();
        $year = $date->format('Y');
        $month = $date->format('m');
        if ($request->image) {
            $image = $request->file('image')->store("images/products/$year/$month", 'local');
        }
        if ($request->gallery) {
            foreach ($request->gallery as $gallery_item) {
                $gallery[] = $gallery_item->store("images/products/$year/$month", 'local');
            }
        }

        $slug = remove_spec($request->title);
        if ($request->slug != null) {
            $slug = remove_spec($request->slug);
        }
        if (Product::whereSlug($slug)->count()) {
            $slug = $slug . '-' . time();
        }


        $product = Product::create([
            'title' => $request->title,
            'slug' => $slug,
            'brand_id' => $request->brand,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'product_helper' => $request->product_helper,
            'type' => $request->product_type,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'is_featured' => $request->filled('is_featured'),
            'sku' => $request->sku,
            'weight' => $request->weight,
            'manage_stock' => $request->filled('manage_stock'),
            'stock' => $request->stock,
            'min_stock' => $request->min_stock,
            'stock_status' => $request->stock_status,
            'sold_individually' => $request->filled('sold_individually'),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'published' => $request->published == 1,
            'image' => $image,
        ]);

        foreach ($gallery as  $gallery_item) {
            $product->images()->create([
                'src' => $gallery_item,
            ]);
        }
        $product->categories()->sync($request->categories);
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
            $product->tags()->sync($tags_id);
        }

        event(new ProductCreated($product, Auth::id()));

        return redirect()->route('panel.products.index')
            ->with('success', 'محصول جدید با موفقیت اضافه شد');
    }

    public function show(Product $product)
    {
        $product->load(['images','comments' => function ($q) {
                $q->published();
            }])
            ->loadCount(['comments' => function ($q) {
                $q->published();
            }]);

        $related_products = Product::whereHas('categories', function ($q) use ($product) {
            $q->whereIn('id', $product->categories()->pluck('id')->toArray());
        })->where('id', '<>', $product->id)->published()->inRandomOrder()->take(4)->get();

        $attribute_groups = AttributeGroup::orderBy('order', 'asc')->whereHas('attributes', function ($query) use ($product) {
            $query->whereHas('products', function ($query) use ($product) {
                $query->where('id', $product->id);
            });
        })->with(['attributes' => function ($query) use ($product) {
            $query->whereHas('products', function ($query) use ($product) {
                $query->where('id', $product->id);
            })->with(['items' => function ($query) use ($product) {
                $query->whereHas('products', function ($query) use ($product) {
                    $query->where('id', $product->id);
                })->select(['id', 'title', 'attribute_id']);
            }])->select(['id', 'title', 'group_id']);
        }])->select(['id', 'title'])->get();

        $comments = $product->comments()->orderBy('created_at', 'asc')->where('published', true)->paginate();

        return view('products.show')->with([
            'product' => $product,
            'related_products' => $related_products,
            'attribute_groups' => $attribute_groups,
        ]);
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::where('parent_id', null)->orderBy('order', 'asc')->get();
        $brands = Brand::orderBy('order', 'asc')->get();

        return view('panel.products.edit.product')->with([
            'product' => $product,
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('edit product');
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'categories' => 'required|array',
            'categories.*' => 'exists:product_categories,id',
            'brand' => 'nullable|exists:brands,id',
            'short_description' => 'nullable|string|max:2000',
            'full_description' => 'nullable|string',
            'product_type' => ['required', Rule::in(array_keys(Product::$types))],
            'regular_price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:regular_price',
            'sku' => [
                'nullable',
                Rule::unique('products', 'sku')->ignore($product->id),
                Rule::unique('variations', 'sku')->ignore($product->id, 'product_id'),
                'string', 'max:255'
            ],
            'weight' => 'nullable|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
            'min_stock' => 'nullable|numeric|min:0',
            'stock_status' => 'required|string|in:instock,outofstock',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|max:500',
            'image' => 'nullable|file|image|max:2000',
            'gallery' => 'nullable|array',
            'gallery.*' => 'file|image|max:2000',
            'tags' => 'nullable|string|max:2000',
        ], [], [
            'title' => 'عنوان محصول',
            'slug' => 'آدرس محصول',
            'categories' => 'دسته بندی ها',
            'categories.*' => 'دسته بندی',
            'brand' => 'برند',
            'short_description' => 'توضیحات کوتاه',
            'full_description' => 'توضیحات کامل',
            'product_helper' => 'راهنمای سایز',
            'product_type' => 'نوع محصول',
            'regular_price' => 'قیمت اصلی',
            'sale_price' => 'قیمت فروش فوق العاده',
            'sku' => 'کد محصول',
            'weight' => 'وزن',
            'stock' => 'موجودی',
            'min_stock' => 'حداقل موجودی',
            'stock_status' => 'وضعیت انبار',
            'meta_title' => 'عنوان متا',
            'meta_description' => 'توضیحات متا',
            'image' => 'تصویر اصلی',
            'gallery' => 'گالری تصاویر',
            'gallery.*' => 'تصویر گالری',
            'tags' => 'برچسب ها',
        ]);

        $image = $product->image;
        $gallery = [];
        $date = new Carbon();
        $year = $date->format('Y');
        $month = $date->format('m');
        if ($request->image) {
            File::delete($image);
            $image = $request->file('image')->store("images/products/$year/$month", 'local');
        }
        if ($request->gallery) {
            foreach ($request->gallery as $gallery_item) {
                $gallery[] = $gallery_item->store("images/products/$year/$month", 'local');
            }
        }

        $slug = remove_spec($request->title);
        if ($request->slug != null) {
            $slug = remove_spec($request->slug);
        }
        if (Product::whereSlug($slug)->where('id', '<>', $product->id)->count()) {
            $slug = $slug . '-' . time();
        }

        $old_product = clone $product;

        $product->update([
            'title' => $request->title,
            'slug' => $slug,
            'brand_id' => $request->brand,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'product_helper' => $request->product_helper,
            'type' => $request->product_type,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'is_featured' => $request->filled('is_featured'),
            'sku' => $request->sku,
            'weight' => $request->weight,
            'manage_stock' => $request->filled('manage_stock'),
            'stock' => $request->stock,
            'min_stock' => $request->min_stock,
            'stock_status' => $request->stock_status,
            'sold_individually' => $request->filled('sold_individually'),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'published' => $request->published == 1,
            'image' => $image,
        ]);

        foreach ($gallery as  $gallery_item) {
            $product->images()->create([
                'src' => $gallery_item,
            ]);
        }

        $product->categories()->sync($request->categories);

        $tags_id = [];
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
        }
        $product->tags()->sync($tags_id);
        $product->submitLog($old_product);
        return redirect()->route('panel.products.edit', $product)
            ->with('success', 'محصول مورد نظر با موفقیت ویرایش شد');
    }
    public function destroy(Product $product)
    {
        $this->authorize('delete product');
        $errorMessage = $product->canDelete();
        if($errorMessage) {
            return back()->withErrors($errorMessage);
        }
        File::delete($product->image);
        File::delete($product->images()->pluck('src')->toArray());
        $product->categories()->detach();
        $product->tags()->detach();
        $product->attributes()->detach();
        foreach ($product->variations as $variation) {
            $variation->attributes()->detach();
        }
        $product->variations()->delete();
        $old_product = clone $product;
        $product->delete();
        event(new ProductDeleted($old_product, Auth::id()));
        return redirect()->route('panel.products.index')->with('success', 'محصول مورد نظر شما با موفقیت حذف شد');
    }
    public function deleteImage(Product $product)
    {
        $this->authorize('edit product');
        if ($product->image) {
            File::delete($product->image);
        }
        $old_product = clone $product;
        $product->update([
            'image' => null
        ]);

        event(new ProductUpdated($old_product, $product, Auth::id(),'تصویر محصول حذف شد'));
        return redirect()->route('panel.products.edit', $product)->with('success', 'تصویر شاخص مورد نظر شما با موفقیت حذف شد');
    }
    public function changePublished(Product $product)
    {
        $this->authorize('edit product');
        $old_product = clone $product;
        $product->update([
            'published' => !$product->published
        ]);
        event(new ProductUpdated($old_product, $product, Auth::id(),'وضعیت انتشار محصول تغییر کرد'));
        return redirect()->route('panel.products.index')->with('success', 'وضعیت محصول مورد نظر تغییر کرد');
    }
    public function changeFeatured(Product $product)
    {
        $this->authorize('edit product');
        $old_product = clone $product;
        $product->update([
            'is_featured' => !$product->is_featured
        ]);

        event(new ProductUpdated($old_product, $product, Auth::id(),'وضعیت ویژه بودن محصول تغییر کرد'));
        return redirect()->route('panel.products.index')->with('success', 'وضعیت محصول مورد نظر تغییر کرد');
    }
    public function deleteGalleryImage(Product $product, ProductImage $image)
    {
        $this->authorize('edit product');
        File::delete($image->src);
        $image->delete();
        $old_product = clone $product;
        event(new ProductUpdated($old_product, $product, Auth::id(),'تصویر از گالری تصاویر محصول حذف شد'));
        return redirect()->route('panel.products.edit', $product)->with('success', 'تصویر مورد نظر شما با موفقیت حذف شد');
    }
}
