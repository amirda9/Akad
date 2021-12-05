<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributeGroup;
use App\Brand;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function show(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)
            ->with('images')
            ->withCount(['comments' => function ($q) {
                $q->published();
            }])
            ->with(['comments' => function ($q) {
                $q->published();
            }])
            ->where('published', true)
            ->firstOrFail();

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

    public function all(Request $request)
    {

        $products = Product::published()
            ->select([
                'id', 'sku', 'type', 'title', 'en_title',
                'slug', 'image', 'order', 'brand_id', 'published',
                'is_featured', 'regular_price', 'sale_price',
                'created_at', 'updated_at', 'stock_status', 'stock', 'manage_stock'
            ]);

        switch ($request->orderBy) {
            case 'latest': {
                $products = $products->orderBy('created_at','desc');
                break;
            }
            case 'oldest': {
                $products = $products->orderBy('created_at','asc');
                break;
            }
            case 'lcost': {
                $products = $products->orderBy('regular_price','asc');
                break;
            }
            case 'hcost': {
                $products = $products->orderBy('regular_price','desc');
                break;
            }
            default: {
                $products = $products->orderBy('created_at','desc');
            }
        }
        if ($request->product_name) {
            $products = $products->where('title', "like", "%$request->product_name%");
        }
        if ($request->filled('featured')) {
            $products = $products->where('is_featured', true);
        }

        $product_ids = $products->pluck('id');

        $selected_attribtues = (array) $request->get('attributes');

        if (is_array($selected_attribtues) && !empty($selected_attribtues)) {
            $products = $products->whereHas('attribute_items', function ($q) use ($selected_attribtues) {
                $q->whereIn('id', $selected_attribtues);
            });
        }

        $selected_brands = (array) $request->get('brands');
        if (is_array($selected_brands) && !empty($selected_brands)) {
            $products = $products->whereIn('brand_id', $selected_brands);
        }
        if ($request->min_price > 0) {
            $products = $products->where('regular_price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $products = $products->where('regular_price', '<=', $request->max_price);
        }

        $products = $products->get();

        $attributes = Attribute::whereHas('products', function ($q) use ($product_ids) {
            $q->whereIn('id', $product_ids);
        })->where('show_as_filter', true)->whereHas('items', function ($q) use ($product_ids) {
            $q->whereHas('products', function ($q2) use ($product_ids) {
                $q2->whereIn('id', $product_ids);
            });
        })->with(['items' => function ($q) use ($product_ids) {
            $q->whereHas('products', function ($q2) use ($product_ids) {
                $q2->whereIn('id', $product_ids);
            });
        }])->get();

        $brands = Brand::whereHas('products', function ($q) use ($product_ids) {
            $q->whereIn('id', $product_ids);
        })->get();


        $page = Paginator::resolveCurrentPage() ?: 1;
        $products = new LengthAwarePaginator($products->forPage($page, 16), $products->count(), 16, $page, [
            'path'  => $request->url(),
            'query' => $request->query(),
        ]);


        $max_price = 0;
        $all_products = Product::published()->whereIn('id', $product_ids)->get();
        $max_price_product = $all_products->sortByDesc('max_price')->first();
        if ($max_price_product) {
            $max_price = $max_price_product->max_price;
        }
        $min_price = 0;
        $min_price_product = $all_products->sortBy('min_price')->first();
        if ($min_price_product) {
            $min_price = $min_price_product->min_price;
        }
        if (!($min_price < $max_price)) {
            $min_price = 0;
        }

        return view('products.all')->with([
            'products' => $products,
            'brands' => $brands,
            'attributes' => $attributes,
            'max_price' => $max_price,
            'min_price' => $min_price,
        ]);
    }

    public function price(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $items = [];
        if($request->items != null) {
            if(is_array($request->items)) {
                $items = $request->items;
            }
        }
        $product_variations = $product->variations;
        $selected_variation = null;
        $not_available_attribute_items = [];
        foreach($product_variations as $product_variation) {
            if(array_equal($product_variation->conditions, $items)) {
                $selected_variation = $product_variation;
            }
        }

        foreach($product->variation_attribute_items as $available_attribute_item) {
            $is_in_stock = false;
            foreach($product_variations as $product_variation) {
                if($product_variation->stock > 0) {
                    if (count($items) > 0) {
                        if(count($items) == count($product_variation->conditions)) {
                            $new_items = array_diff($items, [$available_attribute_item->id]);
                            if(count($new_items) > 0) {
                                $new_condition = array_diff($product_variation->conditions, $new_items);
                                if(array_equal($new_condition, [$available_attribute_item->id])) {
                                    $is_in_stock = true;
                                    break;
                                }
                            } else {
                                if(in_array($available_attribute_item->id,$product_variation->conditions)) {
                                    $is_in_stock = true;
                                    break;
                                }
                            }
                        } else {
                            if(in_array($available_attribute_item->id, $product_variation->conditions)) {
                                $is_in_stock = true;
                                break;
                            }
                        }
                    } else {
                        if(in_array($available_attribute_item->id,$product_variation->conditions)) {
                            $is_in_stock = true;
                            break;
                        }
                    }
                }
            }
            if(!$is_in_stock) {
                $not_available_attribute_items[] = $available_attribute_item->id;
            }
        }
        return [
            'not_available_items' => $not_available_attribute_items,
            'variation_id' => $selected_variation ? $selected_variation->id : null,
            'can_order' => $selected_variation ? $selected_variation->stock > 0 : null,
            'price' => $selected_variation ? $selected_variation->getOrderPrice() : '',
            'formatted_price' => $selected_variation ? number_format($selected_variation->getOrderPrice()) : '',
        ];
    }

    public function rate(Request  $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->rates()->where('ip', $request->ip())->delete();
        $product->rates()->create([
            'rate' => $request->rate,
            'ip' => $request->ip(),
        ]);
        return response([
            'rate' => $product->rate,
            'message' => 'امتیاز شما با موفقیت ثبت شد'
        ]);
    }

    public function submitComment(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
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
        $product->comments()->create([
            'user_id' => $user ? $user->id : null,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'content' => $request->get('content')
        ]);
        return redirect($product->getRoute())->with([
            'success' => 'نظر شما با موفقیت ثبت شد و پس از تایید مدیریت نمایش داده خواهد شد.',
            'toast' => true
        ]);
    }
}
