<?php

namespace App\Http\Controllers\Panel;

use App\Attribute;
use App\AttributeGroup;
use App\AttributeItem;
use App\Brand;
use App\Pivots\ProductAttribute;
use App\Product;
use App\ProductCategory;
use App\ProductImage;
use App\Tag;
use App\Variation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
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

    public function createValidation(Request $request)
    {
        $this->authorize('create product');
        $validator = Validator::make($request->all(), [
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
            'attributes' => 'nullable|array',
            'attributes.*.values' => 'nullable|array',
            'attributes.*.values.*' => 'exists:attribute_items,id',
            'variations' => 'nullable|array',
            'variations.*.conditions' => 'nullable|array',
            'variations.*.conditions.*' => 'nullable|exists:attribute_items,id',
            'variations.*.regular_price' => 'nullable|numeric|min:0',
            'variations.*.sale_price' => 'nullable|numeric|min:0',
            'variations.*.sku' => 'nullable|unique:products,sku|unique:variations,sku|string|max:255',
            'variations.*.weight' => 'nullable|numeric|min:0',
            'variations.*.stock' => 'nullable|numeric|min:0',
            'variations.*.stock_status' => 'required|string|in:instock,outofstock',
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
            'product_type' => 'نوع محصول',
            'regular_price' => 'قیمت اصلی',
            'sale_price' => 'قیمت فروش فوق العاده',
            'sku' => 'کد محصول',
            'weight' => 'وزن',
            'stock' => 'موجودی',
            'min_stock' => 'حداقل موجودی',
            'stock_status' => 'وضعیت انبار',
            'attributes' => 'ویزگی ها',
            'attributes.*.values' => 'مقدار ویژگی',
            'attributes.*.values.*' => 'exists:attribute_items,id',
            'variations' => 'متغیرها',
            'variations.*.conditions' => 'شرایط متغیر',
            'variations.*.conditions.*' => 'مقدار شرایط متغیر',
            'variations.*.regular_price' => 'قیمت اصلی متغیر',
            'variations.*.sale_price' => 'قیمت فروش فوق العاده متغیر',
            'variations.*.sku' => 'شناسه متغیر',
            'variations.*.weight' => 'وزن متغغیر',
            'variations.*.stock' => 'موجودی متغیر',
            'variations.*.stock_status' => 'وضعیت متغیر',
            'meta_title' => 'عنوان متا',
            'meta_description' => 'توضیحات متا',
            'image' => 'تصویر اصلی',
            'gallery' => 'گالری تصاویر',
            'gallery.*' => 'تصویر گالری',
            'tags' => 'برچسب ها',
        ]);

        if ($validator->fails()) {
            return response(view('components.messages', [
                'errors' => $validator->errors()
            ])->render(), 422);
        } else {
            return response(true);
        }
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
            'product_helper' => 'nullable|string',
            'product_type' => ['required', Rule::in(array_keys(Product::$types))],
            'regular_price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:regular_price',
            'sku' => 'nullable|unique:products,sku|unique:variations,sku|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
            'min_stock' => 'nullable|numeric|min:0',
            'stock_status' => 'required|string|in:instock,outofstock',
            'attributes' => 'nullable|array',
            'attributes.*.values' => 'nullable|array',
            'attributes.*.values.*' => 'exists:attribute_items,id',
            'variations' => 'nullable|array',
            'variations.*.conditions' => 'nullable|array',
            'variations.*.conditions.*' => 'nullable|exists:attribute_items,id',
            'variations.*.regular_price' => 'nullable|numeric|min:0',
            'variations.*.sale_price' => 'nullable|numeric|min:0',
            'variations.*.sku' => 'nullable|unique:products,sku|unique:variations,sku|string|max:255',
            'variations.*.weight' => 'nullable|numeric|min:0',
            'variations.*.stock' => 'nullable|numeric|min:0',
            'variations.*.stock_status' => 'required|string|in:instock,outofstock',
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
            'attributes' => 'ویزگی ها',
            'attributes.*.values' => 'مقدار ویژگی',
            'attributes.*.values.*' => 'exists:attribute_items,id',
            'variations' => 'متغیرها',
            'variations.*.conditions' => 'شرایط متغیر',
            'variations.*.conditions.*' => 'مقدار شرایط متغیر',
            'variations.*.regular_price' => 'قیمت اصلی متغیر',
            'variations.*.sale_price' => 'قیمت فروش فوق العاده متغیر',
            'variations.*.sku' => 'شناسه متغیر',
            'variations.*.weight' => 'وزن متغغیر',
            'variations.*.stock' => 'موجودی متغیر',
            'variations.*.stock_status' => 'وضعیت متغیر',
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
        $product->attribute_items()->detach();
        foreach ($request->get('attributes', []) as $key => $attribute) {
            if($attribute['values'] ?? false) {
                $product->attributes()->attach($key, [
                    'value' => ($attribute['values'] ?? false) ? $attribute['values'] : null,
                    'visibility' => ($attribute['visibility'] ?? false) ? true : false,
                    'variation' => ($attribute['variation'] ?? false) ? true : false,
                ]);
            }
            $product->attribute_items()->syncWithoutDetaching($attribute['values'] ?? []);
        }


        if($product->isVariable()) {
            foreach ($request->get('variations', []) ?? [] as $variation) {
                $product_variation = $product->variations()->create([
                    'conditions' => $variation['conditions'],
                    'regular_price' => $variation['regular_price'],
                    'sale_price' => $variation['sale_price'],
                    'sku' => $variation['sku'],
                    'weight' => $variation['weight'],
                    'manage_stock' => filled($variation['manage_stock'] ?? ''),
                    'stock' => $variation['stock'],
                    'stock_status' => $variation['stock_status'],
                ]);
                $product_variation->attributes()->detach();
                $attribute_items = AttributeItem::whereIn('id', $product_variation->conditions)->get();
                foreach ($attribute_items as $attribute_item) {
                    $product_variation->attributes()->attach($attribute_item->attribute_id, [
                        'attribute_item_id' => $attribute_item->id
                    ]);
                }
            }
        }

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

        return redirect()->route('panel.products.index')
            ->with('success', 'محصول جدید با موفقیت اضافه شد');
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::where('parent_id', null)->orderBy('order', 'asc')->get();
        $brands = Brand::orderBy('order', 'asc')->get();
        $attribute_groups = AttributeGroup::orderBy('order', 'asc')->with(['attributes' => function ($q) {
            $q->orderBy('order', 'asc');
        }])->get();
        $selected_attributes = $product->attributes()->withPivot(['value', 'visibility', 'variation'])
            ->using(ProductAttribute::class)->get();

        $selected_variations = [];
        $product->with('variations');
        $variation_data = $product->variations->toArray();
        foreach ($selected_attributes as $key => $selected_attribute) {
            if ($selected_attribute->pivot->variation) {
                $selected_variations[] = [
                    'attribute_id' => $selected_attribute->id,
                    'selected_values' => is_array($selected_attribute->pivot->value) ? $selected_attribute->pivot->value : [],
                ];
            }
        }

        return view('panel.products.edit')->with([
            'product' => $product,
            'brands' => $brands,
            'categories' => $categories,
            'attribute_groups' => $attribute_groups,
            'selected_attributes' => $selected_attributes,
            'selected_variations' => $selected_variations,
            'variation_data' => $variation_data,
        ]);
    }

    public function updateValidation(Request $request, Product $product)
    {
        $this->authorize('edit product');
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'categories' => 'required|array',
            'categories.*' => 'exists:product_categories,id',
            'brand' => 'nullable|exists:brands,id',
            'short_description' => 'nullable|string|max:2000',
            'full_description' => 'nullable|string',
            'product_helper' => 'nullable|max:8000',
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
            'attributes' => 'nullable|array',
            'attributes.*.values' => 'nullable|array',
            'attributes.*.values.*' => 'exists:attribute_items,id',
            'variations' => 'nullable|array',
            'variations.*.conditions' => 'nullable|array',
            'variations.*.conditions.*' => 'nullable|exists:attribute_items,id',
            'variations.*.regular_price' => 'nullable|numeric|min:0',
            'variations.*.sale_price' => 'nullable|numeric|min:0',
            'variations.*.sku' => [
                'nullable', 'string', 'max:255',
                Rule::unique('products', 'sku')->ignore($product->id),
                Rule::unique('variations', 'sku')->ignore($product->id, 'product_id'),
            ],
            'variations.*.weight' => 'nullable|numeric|min:0',
            'variations.*.stock' => 'nullable|numeric|min:0',
            'variations.*.stock_status' => 'required|string|in:instock,outofstock',
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
            'attributes' => 'ویزگی ها',
            'attributes.*.values' => 'مقدار ویژگی',
            'attributes.*.values.*' => 'exists:attribute_items,id',
            'variations' => 'متغیرها',
            'variations.*.conditions' => 'شرایط متغیر',
            'variations.*.conditions.*' => 'مقدار شرایط متغیر',
            'variations.*.regular_price' => 'قیمت اصلی متغیر',
            'variations.*.sale_price' => 'قیمت فروش فوق العاده متغیر',
            'variations.*.sku' => 'شناسه متغیر',
            'variations.*.weight' => 'وزن متغغیر',
            'variations.*.stock' => 'موجودی متغیر',
            'variations.*.stock_status' => 'وضعیت متغیر',
            'meta_title' => 'عنوان متا',
            'meta_description' => 'توضیحات متا',
            'image' => 'تصویر اصلی',
            'gallery' => 'گالری تصاویر',
            'gallery.*' => 'تصویر گالری',
            'tags' => 'برچسب ها',
        ]);

        if ($validator->fails()) {
            return response(view('components.messages', [
                'errors' => $validator->errors()
            ])->render(), 422);
        } else {
            return response(true);
        }
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
            'product_helper' => 'nullable|max:8000',
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
            'attributes' => 'nullable|array',
            'attributes.*.values' => 'nullable|array',
            'attributes.*.values.*' => 'exists:attribute_items,id',
            'variations' => 'nullable|array',
            'variations.*.conditions' => 'nullable|array',
            'variations.*.conditions.*' => 'nullable|exists:attribute_items,id',
            'variations.*.regular_price' => 'nullable|numeric|min:0',
            'variations.*.sale_price' => 'nullable|numeric|min:0',
            'variations.*.sku' => [
                'nullable', 'string', 'max:255',
                Rule::unique('products', 'sku')->ignore($product->id),
                Rule::unique('variations', 'sku')->ignore($product->id, 'product_id'),
            ],
            'variations.*.weight' => 'nullable|numeric|min:0',
            'variations.*.stock' => 'nullable|numeric|min:0',
            'variations.*.stock_status' => 'required|string|in:instock,outofstock',
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
            'attributes' => 'ویزگی ها',
            'attributes.*.values' => 'مقدار ویژگی',
            'attributes.*.values.*' => 'exists:attribute_items,id',
            'variations' => 'متغیرها',
            'variations.*.conditions' => 'شرایط متغیر',
            'variations.*.conditions.*' => 'مقدار شرایط متغیر',
            'variations.*.regular_price' => 'قیمت اصلی متغیر',
            'variations.*.sale_price' => 'قیمت فروش فوق العاده متغیر',
            'variations.*.sku' => 'شناسه متغیر',
            'variations.*.weight' => 'وزن متغغیر',
            'variations.*.stock' => 'موجودی متغیر',
            'variations.*.stock_status' => 'وضعیت متغیر',
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
        $new_attributes = [];
        $new_attributes_items = [];
        foreach ($request->get('attributes', []) as $key => $attribute) {
            if($attribute['values']){
                $new_attributes[$key] = [
                    'value' => ($attribute['values'] ?? false) ? $attribute['values'] : false,
                    'visibility' => ($attribute['visibility'] ?? false) ? true : false,
                    'variation' => ($attribute['variation'] ?? false) ? true : false,
                ];
            }
            $new_attributes_items = array_merge($new_attributes_items, $attribute['values']) ;
        }
        $product->attributes()->sync($new_attributes);
        $product->attribute_items()->sync($new_attributes_items);


        if($product->isVariable()) {
            $product_variation_ids = [];
            foreach ($request->get('variations', []) ?? [] as $variation) {
                $product_variation = null;
                foreach($product->variations as $item) {
                    if(array_equal($item->conditions,$variation['conditions'])) {
                        $product_variation = $item;
                        break;
                    }
                }
                if($product_variation) {
                    $product_variation->update([
                        'regular_price' => $variation['regular_price'],
                        'sale_price' => $variation['sale_price'],
                        'sku' => $variation['sku'],
                        'weight' => $variation['weight'],
                        'manage_stock' => filled($variation['manage_stock'] ?? ''),
                        'stock' => $variation['stock'],
                        'stock_status' => $variation['stock_status'],
                    ]);
                } else {
                    $product_variation = $product->variations()->create([
                        'conditions' => $variation['conditions'],
                        'regular_price' => $variation['regular_price'],
                        'sale_price' => $variation['sale_price'],
                        'sku' => $variation['sku'],
                        'weight' => $variation['weight'],
                        'manage_stock' => filled($variation['manage_stock'] ?? ''),
                        'stock' => $variation['stock'],
                        'stock_status' => $variation['stock_status'],
                    ]);
                }
                $attribute_items = AttributeItem::whereIn('id', $variation['conditions'])->get();
                $product_variation_attributes = [];
                foreach ($attribute_items as $attribute_item) {
                    $product_variation_attributes[$attribute_item->attribute_id] = [
                        'attribute_item_id' => $attribute_item->id
                    ];
                }
                $product_variation->attributes()->sync($product_variation_attributes);
                $product_variation_ids[] = $product_variation->id;
            }
            $removed_variations = $product->variations()->whereNotIn('id',$product_variation_ids)->get();
            foreach($removed_variations as $removed_variation) {
                $removed_variation->attributes()->detach();
            }
            $product->variations()->whereNotIn('id',$product_variation_ids)->delete();
        }
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
        $product->delete();
        return redirect()->route('panel.products.index')->with('success', 'محصول مورد نظر شما با موفقیت حذف شد');
    }

    public function deleteImage(Product $product)
    {
        $this->authorize('edit product');
        if ($product->image) {
            File::delete($product->image);
        }
        $product->update([
            'image' => null
        ]);
        return redirect()->route('panel.products.edit', $product)->with('success', 'تصویر شاخص مورد نظر شما با موفقیت حذف شد');
    }

    public function changePublished(Product $product)
    {
        $this->authorize('edit product');
        $product->update([
            'published' => !$product->published
        ]);

        return redirect()->route('panel.products.index')->with('success', 'وضعیت محصول مورد نظر تغییر کرد');
    }
    public function changeFeatured(Product $product)
    {
        $this->authorize('edit product');
        $product->update([
            'is_featured' => !$product->is_featured
        ]);

        return redirect()->route('panel.products.index')->with('success', 'وضعیت محصول مورد نظر تغییر کرد');
    }

    public function deleteGalleryImage(Product $product, ProductImage $image)
    {
        $this->authorize('edit product');
        File::delete($image->src);
        $image->delete();
        return redirect()->route('panel.products.edit', $product)->with('success', 'تصویر مورد نظر شما با موفقیت حذف شد');
    }
}
