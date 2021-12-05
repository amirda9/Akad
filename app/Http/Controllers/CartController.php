<?php

namespace App\Http\Controllers;

use App\AttributeItem;
use App\Events\Orders\OrderMerged;
use App\Events\Orders\OrderSubmitted;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Wschool\Shoppingcart\Exceptions\InvalidRowIDException;
use Wschool\Shoppingcart\Facades\Cart;

class CartController extends Controller
{

    public function show(Request $request)
    {
        $cart = Cart::content();

        $order_users = null;
        if (Auth::user()) {
            $order_users = Order::where('user_id', auth()->user()->id)->isReservable()->get();
        }
        return view('cart.show')->with([
            'cart' => $cart,
            'order_users' => $order_users
        ]);
    }

    public function add(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'qty' => 'nullable|numeric|min:1',
            'vid' => 'nullable|exists:variations,id',
        ], [], [
            'qty' => 'تعداد',
            'vid' => 'ویژگی محصول',
        ]);

        if ($validator->fails()) {
            return $this->returnError($validator->errors()->all());
        }

        if (!$product->published) {
            return $this->returnError(['product_id' => 'محصول مورد نظر یافت نشد']);
        }
        $item = null;
        if ($product->isSimple()) {
            $item = Cart::content()->where('id', $product->id)->first();
        }
        if ($product->isVariable()) {
            if (empty($request->vid)) {
                return $this->returnError(['product_id' => 'لطفا مشخصات محصول را انتخاب کنید']);
            }
            $product_items = Cart::content()->where('id', $product->id);
            foreach ($product_items as $product_item) {
                if ($product_item->options['vid'] ?? false) {
                    if ($product_item->options['vid'] == $request->vid) {
                        $item = $product_item;
                        break;
                    }
                }
            }
        }
        $qty = $request->qty ?: 1;
        if ($item) {
            $qty += $item->qty;
        }
        if ($product->sold_individually && $qty > 1) {
            return $this->returnError(['product_id' => 'حداکثر تعداد مجاز برای سفارش 1 عدد می باشد']);
        }
        if ($product->isSimple()) {
            if (!$product->canOrder($qty)) {
                return $this->returnError(['product_id' => 'متاسفانه در حال حاضر محصول مورد نظر موجود نمی باشد.']);
            }
            if ($item != null) {
                Cart::update($item->rowId, [
                    'qty' => $qty,
                    'price' => $product->getOrderPrice($qty) ?: 0
                ]);
            } else {
                Cart::add($product->id, $product->title, $qty, $product->getOrderPrice($qty) ?: 0)
                    ->associate(Product::class);
            }
        }
        if ($product->isVariable()) {
            $variation = $product->variations()->findOrFail($request->vid);
            if (!$variation->canOrder($qty)) {
                return $this->returnError(['product_id' => 'متاسفانه در حال حاضر محصول مورد نظر موجود نمی باشد.']);
            }
            if ($item != null) {
                Cart::update($item->rowId, [
                    'qty' => $qty,
                    'price' => $variation->getOrderPrice($qty) ?: 0
                ]);
            } else {
                $attributes = [];
                $attribute_item_ids = [];
                $variation_attributes = $variation->attributes;
                if($variation_attributes->count()) {
                    foreach ($variation->attributes as $variation_attribute) {
                        $attributes[] = [
                            'title' => $variation_attribute->title ?? '',
                            'value' => $variation_attribute->pivot->item->title ?? ''
                        ];
                        $attribute_item_ids[] = $variation_attribute->pivot->item->id;
                    }
                } else {
                    foreach($request->all() as $key => $attribute_item_id) {
                        if(preg_match('/^attribute_\d+$/',$key)) {
                            $attribute_item_ids[] = $attribute_item_id;
                        }
                    }
                    $selected_attribute_items = AttributeItem::whereIn('id',$attribute_item_ids)
                        ->whereHas('attribute')
                        ->with('attribute')->get();
                    foreach($selected_attribute_items as $selected_attribute_item) {
                        $attributes[] = [
                            'title' => $selected_attribute_item->attribute->title ?? '',
                            'value' => $selected_attribute_item->title ?? '',
                        ];
                    }
                }
                Cart::add($product->id, $product->title, $qty, $variation->getOrderPrice($qty) ?: 0, [
                    'vid' => $request->vid,
                    'attributes' => $attributes,
                    'attribute_ids' => $attribute_item_ids,
                ])->associate(Product::class);
            }
        }

        if ($request->ajax()) {
            return response([
                'toast' => view('components.toast')->with([
                    'title' => 'پیام موفقیت',
                    'type' => 'success',
                    'message' => 'محصول مورد نظر به سبد خرید اضافه شد'
                ])
            ], 200);
        }
        return back()->with([
            'toast' => true,
            'show_cart_dropdown' => true,
            'success' => 'محصول مورد نظر به سبد خرید اضافه شد'
        ]);
    }

    public function remove($rowId)
    {
        try {
            Cart::remove($rowId);
            return back()->with([
                'success' => 'محصول مورد نظر از سبد خرید حذف شد',
                'toast' => true
            ]);
        }
        catch (InvalidRowIDException $e) {
            Log::info($e->getMessage());
            Log::info(json_encode(Cart::content()));
            Cart::destroy();
            return back();
        }
    }

    public function increase($rowId)
    {
        try {
            $item = Cart::get($rowId);
            $product = $item->model;
            if (!$product->published) {
                return back()->withErrors(['محصول مورد نظر شما قابل سفارش نمی باشد'])->with([
                    'toast' => true
                ]);
            }
            if ($item == null) {
                return back()->withErrors(['محصول مورد نظر در سبد خرید شما یافت نشد'])->with([
                    'toast' => true
                ]);
            }
            if ($product->isSimple()) {
                if (!$product->canOrder($item->qty + 1)) {
                    return $this->returnError(['product_id' => 'متاسفانه در حال حاضر محصول مورد نظر موجود نمی باشد.']);
                }
                Cart::update($item->rowId, [
                    'qty' => $item->qty + 1,
                    'price' => $product->getOrderPrice($item->qty + 1) ?: 0,
                ]);
            }
            if ($product->isVariable()) {
                $variation = $product->variations()->findOrFail($item->options['vid']);
                if (!$variation->canOrder($item->qty + 1)) {
                    return $this->returnError(['product_id' => 'متاسفانه در حال حاضر محصول مورد نظر موجود نمی باشد.']);
                }
                Cart::update($item->rowId, [
                    'qty' => $item->qty + 1,
                    'price' => $variation->getOrderPrice($item->qty + 1) ?: 0,
                ]);
            }
            if (app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName() == 'cart.show') {
                return back()->with([
                    'success' => 'افزایش تعداد محصول در سبد خرید انجام شد',
                    'show_cart_dropdown' => false,
                    'toast' => true
                ]);
            }
            return back()->with([
                'success' => 'افزایش تعداد محصول در سبد خرید انجام شد',
                'show_cart_dropdown' => true,
                'toast' => true
            ]);
        } catch (InvalidRowIDException $e) {
            Log::info($e->getMessage());
            Log::info(json_encode(Cart::content()));
            Cart::destroy();
            return back();
        }
    }

    public function decrease($rowId)
    {
        try {
            $item = Cart::get($rowId);
            if ($item == null) {
                return back()->withErrors(['محصول مورد نظر در سبد خرید شما یافت نشد'])->with([
                    'toast' => true
                ]);
            }
            $product = $item->model;
            if ($product->published) {
                if ($product->isSimple()) {
                    Cart::update($item->rowId, [
                        'qty' => $item->qty - 1,
                        'price' => $product->getOrderPrice($item->qty - 1) ?: 0,
                    ]);
                }
                if ($product->isVariable()) {
                    $variation = $product->variations()->find($item->options['vid']);
                    if ($variation) {
                        Cart::update($item->rowId, [
                            'qty' => $item->qty - 1,
                            'price' => $variation->getOrderPrice($item->qty - 1) ?: 0,
                        ]);
                    } else {
                        Cart::remove($item->rowId);
                        return back()->with([
                            'error' => 'آیتم منقضی شده در سبد خرید حذف شد',
                            'show_cart_dropdown' => false,
                            'toast' => true
                        ]);
                    }
                }
            } else {
                Cart::remove($rowId);
            }
            return back()->with([
                'success' => 'کاهش تعداد محصول در سبد خرید انجام شد',
                'show_cart_dropdown' => false,
                'toast' => true
            ]);
        } catch (InvalidRowIDException $e) {
            Log::info($e->getMessage());
            Log::info(json_encode(Cart::content()));
            Cart::destroy();
            return back();
        }
    }

    public function shipping()
    {
        if (Cart::count() == 0) {
            return redirect()->route('cart.show');
        }
        $provinces = collect(config('locality.provinces'));
        return view('cart.shipping')->with([
            'provinces' => $provinces,
        ]);
    }
    public function submitShipping(Request $request)
    {
        if (Cart::count() == 0) {
            return redirect()->route('cart.show');
        }
        $request->merge([
            'mobile' => convertNumbers($request->mobile, false)
        ]);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|string|max:255',
            'mobile' => 'required|regex:/^09\d{9}$/',
            'province' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'nullable',
            'address' => 'required|string|max:1000',
            'description' => 'nullable|string|max:1000',
            'shipping' => 'required|string|in:free_shipping,post_shipping,bike_shipping,in_place_delivery',
        ], [], [
            'name' => 'نام و نام خانوادگی',
            'email' => 'آدرس ایمیل',
            'mobile' => 'شماره موبایل',
            'province' => 'استان',
            'city' => 'شهر',
            'postal_code' => 'کد پستی',
            'address' => 'آدرس',
            'description' => 'توضیحات',
            'shipping' => 'روش ارسال',
        ]);

        $province = $request->province;
        $city = $request->city;
        $validator->after(function ($validator) use ($request, $province, $city) {
            if (!$province) {
                $validator->errors()->add('province', 'لطفا استان را انتخاب کنید');
            }
            if (!$city) {
                $validator->errors()->add('city', 'لطفا نام شهر خود را وارد کنید');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->with(['toast' => true])->withInput();
        }

        $order_price = Cart::total(0, '', '');
        $user = Auth::user();

        $shippings = collect(getAvailableShippings($order_price, $province, $city));
        $shipping = $shippings->where('name', $request->shipping)->first();

        if (!$shipping) {
            return back()->withErrors(['shipping' => 'روش ارسال انتخاب شده نامعتبر می باشد'])->withInput();
        }

        $is_approved = true;
        $order_items = [];
        foreach (Cart::content() as $cart_item) {
            $product = $cart_item->model;
            $price = 0;
            $variation = null;
            $sub_title = '';
            if ($product->isSimple()) {
                if (!$product->canOrder($cart_item->qty)) {
                    return $this->returnError(['product_id' => 'متاسفانه در حال حاضر محصول مورد نظر موجود نمی باشد.']);
                }
                $price = $product->getOrderPrice($cart_item->qty);
            }
            if ($product->isVariable()) {
                $variation = $product->variations()->find($cart_item->options['vid']);
                if(!$variation) {
                    return $this->returnError(['product_id' => 'متاسفانه در حال حاضر محصول مورد نظر موجود نمی باشد.']);
                }
                if (!$variation->canOrder($cart_item->qty)) {
                    return $this->returnError(['product_id' => 'متاسفانه در حال حاضر محصول مورد نظر موجود نمی باشد.']);
                }
                $price = $variation->getOrderPrice($cart_item->qty);


                $order_item_attributes = [];
                $order_item_attribute_ids = $cart_item->options['attribute_ids'] ?? [];
                $selected_attribute_items = AttributeItem::whereIn('id',$order_item_attribute_ids)
                    ->whereHas('attribute')
                    ->with('attribute')->get();
                foreach($selected_attribute_items as $selected_attribute_item) {
                    $title = $selected_attribute_item->attribute->title ?? '';
                    $value = $selected_attribute_item->title ?? '';
                    $order_item_attributes[] = "$title : $value";
                }
                $sub_title = implode(" | ",$order_item_attributes);

            }
            if ($price == 0) {
                $is_approved = false;
            }

            $order_items[] = [
                'product_id' => $cart_item->id,
                'title' => $cart_item->model->title,
                'sub_title' => $sub_title,
                'variation_id' => $variation ? $variation->id : null,
                'quantity' => $cart_item->qty ?: 1,
                'price' => $price ?: null,
                'total_price' => $price ? $price * $cart_item->qty : null,
            ];
        }

        $order = Order::create([
            'code' => time(),
            'user_id' => $user ? $user->id : null,
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'province' => $province,
            'city' => $city,
            'postal_code' => $request->postal_code ?: '',
            'address' => $request->address,
            'description' => $request->description,
            'shipping' => $shipping['title'],
            'shipping_price' => $shipping['price'],
            'status' => $is_approved ? 'pending' : 'on-hold',
            'is_approved' => $is_approved,
        ]);

        foreach ($order_items as $order_item) {
            $order->items()->create($order_item);
        }
        Cart::destroy();
        event(new OrderSubmitted($order));
        return redirect()->route('orders.show', $order->code);
    }

    public function returnError($errors)
    {
        if (\request()->wantsJson()) {
            return response([
                'errors' => $errors,
                'toast' => view('components.toast')->with([
                    'title' => 'پیام خطا',
                    'type' => 'danger',
                    'messages' => $errors
                ])
            ], 422);
        }
        return back()->withErrors($errors)->with([
            'toast' => true
        ]);
    }

    public function order_integration(Request $request)
    {
        $user = auth()->user();
        $order = $user->orders()->where('code', $request->order_code)->isReservable()->first();

        if(!$order) {
            return back()->withErrors('سفارش مورد نظر برای ادغام یافت نشد');
        }

        $order_items = [];
        foreach (Cart::content() as $cart_item) {
            $product = $cart_item->model;
            $price = 0;
            $variation = null;
            $sub_title = '';

            if ($product->isSimple()) {
                if (!$product->canOrder($cart_item->qty)) {
                    return $this->returnError(['product_id' => 'متاسفانه در حال حاضر محصول مورد نظر موجود نمی باشد.']);
                }
                $price = $product->getOrderPrice($cart_item->qty);
            }
            if ($product->isVariable()) {
                $variation = $product->variations()->find($cart_item->options['vid']);
                if(!$variation) {
                    return $this->returnError(['product_id' => 'متاسفانه در حال حاضر محصول مورد نظر موجود نمی باشد.']);
                }
                if (!$variation->canOrder($cart_item->qty)) {
                    return $this->returnError(['product_id' => 'متاسفانه در حال حاضر محصول مورد نظر موجود نمی باشد.']);
                }
                $price = $variation->getOrderPrice($cart_item->qty);

                $order_item_attributes = [];
                $order_item_attribute_ids = $cart_item->options['attribute_ids'] ?? [];
                $selected_attribute_items = AttributeItem::whereIn('id',$order_item_attribute_ids)
                    ->whereHas('attribute')
                    ->with('attribute')->get();
                foreach($selected_attribute_items as $selected_attribute_item) {
                    $title = $selected_attribute_item->attribute->title ?? '';
                    $value = $selected_attribute_item->title ?? '';
                    $order_item_attributes[] = "$title : $value";
                }
                $sub_title = implode(" | ",$order_item_attributes);

            }
            if ($price == 0) {
                $is_approved = false;
            }
            $order_items[] = [
                'product_id' => $cart_item->id,
                'title' => $cart_item->model->title,
                'sub_title' => $sub_title,
                'variation_id' => $variation ? $variation->id : null,
                'quantity' => $cart_item->qty ?: 1,
                'price' => $price ?: null,
                'total_price' => $price ? $price * $cart_item->qty : null,
            ];
        }

        if(count($order_items) == 0) {
            return back()->withErrors('هیچ محصولی برای ادغام وجود ندارد');
        }
        foreach ($order_items as $order_item) {
            $order->items()->create($order_item);
        }
        Cart::destroy();
        event(new OrderMerged($order));
        return redirect()->route('user.orders.show', $order->code)->with([
            'success' => 'سفارش شما به روزرسانی شد',

        ]);
    }
}
