<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Brand;
use App\Contact;
use App\Product;
use App\Slide;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class HomeController extends Controller
{
    public function __construct()
    {
    }


    public function index()
    {
        $slides = Slide::where('position', 'website')->orderBy('order', 'asc')->get();
        return view('index')->with([
            'slides' => $slides
        ]);
    }

    public function search(Request $request)
    {
        $products = null;

        if ($request->q) {
            $products = Product::published()->where('title', 'like', "%{$request->q}%")
                ->orWhere('sku', $request->q)->get();

            switch ($request->orderBy) {
                case 'latest': {
                        $products = $products->sortByDesc('created_at');
                        break;
                    }
                case 'oldest': {
                        $products = $products->sortBy('created_at');
                        break;
                    }
                case 'lcost': {
                        $products = $products->sortBy('min_price');
                        break;
                    }
                case 'hcost': {
                        $products = $products->sortByDesc('max_price');
                        break;
                    }
                default: {
                        $products = $products->sortByDesc('created_at');
                    }
            }

            $page = Paginator::resolveCurrentPage() ?: 1;
            $products = new LengthAwarePaginator($products->forPage($page, 20), $products->count(), 20, $page, [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]);
        }

        return view('search')->with([
            'products' => $products
        ]);
    }
    public function tags(Request $request, Tag $tag)
    {

        $products = Product::published()
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('id', $tag->id);
            })->select([
                'id', 'sku', 'type', 'title', 'en_title',
                'slug', 'image', 'order', 'brand_id', 'published',
                'is_featured', 'regular_price', 'sale_price',
                'created_at', 'updated_at', 'stock_status', 'stock', 'manage_stock'
            ]);

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

        $products = $products->get();

        switch ($request->orderBy) {
            case 'latest': {
                    $products = $products->sortByDesc('created_at');
                    break;
                }
            case 'oldest': {
                    $products = $products->sortBy('created_at');
                    break;
                }
            case 'lcost': {
                    $products = $products->sortBy('min_price');
                    break;
                }
            case 'hcost': {
                    $products = $products->sortByDesc('max_price');
                    break;
                }
            default: {
                    $products = $products->sortByDesc('created_at');
                }
        }


        if ($request->min_price) {
            $products = $products->where('min_price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $products = $products->where('max_price', '<=', $request->max_price);
        }

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

        $products = $products->sortByDesc('is_in_stock');


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

        return view('tags')->with([
            'tag' => $tag,
            'products' => $products,
            'brands' => $brands,
            'attributes' => $attributes,
            'max_price' => $max_price,
            'min_price' => $min_price,
        ]);
    }

    public function sendContact(Request $request)
    {
        $request->merge([
            'mobile' => convertNumbers($request->mobile, false)
        ]);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'mobile' => 'nullable|regex:/^09\d{9}$/',
            'message' => 'required|string|max:2000',
            'captcha' => 'required|captcha'
        ], [], [
            'name' => 'نام',
            'email' => 'آدرس ایمیل',
            'mobile' => 'شماره موبایل',
            'message' => 'متن پیام',
            'captcha' => 'کد کپچا',
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'message' => $request->message,
        ]);

        return back()->with([
            'success' => 'پیام شما با موفقیت ارسال شد'
        ]);
    }

    public function refereshCapcha()
    {
        return captcha_img('simple');
    }


    public function provinces(Request $request)
    {
        $provinces = collect(config('locality.provinces'));

        if ($request->name) {
            $provinces = $provinces->filter(function ($item) use ($request) {
                return false !== stristr($item['name'], $request->name);
            });
        }

        return $provinces;
    }
    public function cities(Request $request)
    {
        $cities = collect(config('locality.cities'));
        $provinces = collect(config('locality.provinces'));

        if ($request->name) {
            $cities = $cities->filter(function ($item) use ($request) {
                return false !== stristr($item['name'], $request->name);
            });
        }
        if ($request->province) {
            $province = $provinces->where('name',$request->province)->first();
            $cities = $cities->filter(function ($item) use ($province) {
                return $item['province'] == $province['id'];
            });
        }

        return $cities;
    }

    public function shippings(Request $request)
    {
        $order_price = $request->order_price;
        $province = $request->province;
        $city = $request->city;
        $result = getAvailableShippings($order_price, $province, $city);

        if ($request->render) {
            return view('components.cart.shippings')->with([
                'shippings' => $result
            ])->render();
        }
        return $result;
    }

}
