<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Brand;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function show(Request $request, $slug)
    {
        $category = ProductCategory::whereSlug($slug)->firstOrFail();

        $category_ids = [];
        getAllCategoryChildren($category, $category_ids);

        $products = Product::published()->whereHas('categories',function ($q) use($category_ids) {
            $q->whereIn('id',$category_ids);
        })->select([
            'id','sku','type','title','en_title',
            'slug','image','order','brand_id','published',
            'is_featured','regular_price','sale_price',
            'created_at','updated_at', 'stock_status','stock','manage_stock'
        ]);

        $product_ids = $products->pluck('id');

        $selected_attribtues = (array) $request->get('attributes');

        if(is_array($selected_attribtues) && !empty($selected_attribtues)) {
            $products = $products->whereHas('attribute_items',function ($q) use($selected_attribtues) {
                $q->whereIn('id',$selected_attribtues);
            });
        }

        $selected_brands = (array) $request->get('brands');
        if(is_array($selected_brands) && !empty($selected_brands)) {
            $products = $products->whereIn('brand_id',$selected_brands);
        }

        if($request->product_name) {
            $products = $products->where('title', "like", "%$request->product_name%");
        }
        if($request->filled('featured')) {
            $products = $products->where('is_featured',true);
        }

        $products = $products->get();

        switch ($request->orderBy) {
            case 'latest' : {
                $products = $products->sortByDesc('created_at');
                break;
            }
            case 'oldest' : {
                $products = $products->sortBy('created_at');
                break;
            }
            case 'lcost' : {
                $products = $products->sortBy('min_price');
                break;
            }
            case 'hcost' : {
                $products = $products->sortByDesc('max_price');
                break;
            }
            default : {
                $products = $products->sortByDesc('created_at');
            }
        }

        if($request->min_price) {
            $products = $products->where('min_price','>=',$request->min_price);
        }
        if($request->max_price) {
            $products = $products->where('max_price','<=',$request->max_price);
        }


        $attributes = Attribute::whereHas('products', function($q) use($product_ids) {
            $q->whereIn('id',$product_ids);
        })->where('show_as_filter',true)->whereHas('items',function ($q) use($product_ids) {
            $q->whereHas('products',function($q2) use($product_ids) {
                $q2->whereIn('id',$product_ids);
            });
        })->with(['items' => function($q) use($product_ids) {
            $q->whereHas('products', function ($q2) use($product_ids) {
                $q2->whereIn('id',$product_ids);
            });
        }])->get();

        $brands = Brand::whereHas('products', function($q) use($product_ids) {
            $q->whereIn('id',$product_ids);
        })->get();

        $products = $products->sortByDesc('is_in_stock');

        $page = Paginator::resolveCurrentPage() ?: 1;
        $products = new LengthAwarePaginator($products->forPage($page, 16), $products->count(), 16, $page, [
            'path'  => $request->url(),
            'query' => $request->query(),
        ]);

        $parents = [];
        $parent = $category->parent;
        while ($parent != null) {
            $parents[] = $parent;
            $parent = $parent->parent;
        }
        $parents = collect($parents);
        $parents = $parents->sortBy(function($parent){
            return $parent->level;
        });

        $max_price = 0;
        $category_products = Product::published()->whereIn('id',$product_ids)->whereHas('categories',function($q) use($category_ids) {
            $q->whereIn('id', $category_ids);
        })->get();
        $max_price_product = $category_products->sortByDesc('max_price')->first();
        if($max_price_product) {
            $max_price = $max_price_product->max_price;
        }
        $min_price = 0;
        $min_price_product = $category_products->sortBy('min_price')->first();
        if($min_price_product) {
            $min_price = $min_price_product->min_price;
        }
        if(!($min_price < $max_price)) {
            $min_price = 0;
        }

        return view('category')->with([
            'products' => $products,
            'brands' => $brands,
            'attributes' => $attributes,
            'parents' => $parents,
            'max_price' => $max_price,
            'min_price' => $min_price,
            'category' => $category,
        ]);
    }

}
