<?php

namespace App\Http\Controllers\panel;

use App\Coupon;
use App\CouponLimit;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductCategory;
use App\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(REquest $request)
    {
        $coupons = Coupon::orderBy('created_at', 'desc');

        if ($request->search) {
            $coupons = $coupons->where('title', 'like', "%$request->search%")
                ->orWhere('code', "$request->search");
        }
        if ($request->status) {
            $coupons = $coupons->where('status', "$request->status");
        }
        if ($request->start_date) {
            $start_date = Carbon::createFromFormat('Y-m-d', Date('Y-m-d', str_limit(request('start_date'), 10, '')));
            $start_date->startOfDay();
            $coupons = $coupons->where('start_date', '>=', $start_date);
        }
        if ($request->end_date) {
            $end_date = Carbon::createFromFormat('Y-m-d', Date('Y-m-d', str_limit(request('end_date'), 10, '')));
            $end_date->endOfDay();
            $coupons = $coupons->where('end_date', '<=', $end_date);
        }

        $coupons = $coupons->paginate();
        $coupons->append($request->query());
        return view('panel.coupons.index')->with([
            'coupons' => $coupons,
        ]);
    }

    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return view('panel.coupons.create')->with([
            'users' => $users,
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'general' => 'nullable',
            'number' => 'nullable',
            'status' => 'nullable|string|max:255',
            'amount' => 'required|string',
            'shipping_discount' => 'nullable|numeric',
            'start_date' => 'nullable|digits:13',
            'end_date' => 'nullable|digits:13',

        ], [], [
            'code' => 'کد کوپن',
            'title' => 'عنوان',
            'type' => 'نوع کوپن',
            'general' => 'کوپن عمومی',
            'number' => 'تعداد کوپن',
            'status' => 'وضعیت',
            'amount' => 'مقدار تخفیف',
            'shipping_discount' => 'تخفیف هزینه ارسال',
            'start_date' => 'تاریخ شروع',
            'end_date' => 'تاریخ پایان',
        ]);

        $coupon = Coupon::create([
            'code' => $request->code,
            'title' => $request->title,
            'type' => $request->type,
            'general' => $request->filled('general'),
            'number' => $request->number,
            'is_disposable' => $request->filled('is_disposable'),
            'status' => $request->status,
            'amount' => $request->amount,
            'shipping_discount' => $request->shipping_discount,
            'description' => $request->description,
            'start_date' => $request->start_date ? Carbon::createFromTimestampMs($request->start_date) : null,
            'end_date' => $request->end_date ? Carbon::createFromTimestampMs($request->end_date) : null,
            'min_order_amount' => $request->min_order_amount,
            'max_discount_amount' => $request->max_discount_amount,
        ]);



        return redirect()->route('panel.coupons.index')->with([
            'success' => 'کوپن با موفقیت ثبت شد'
        ]);
    }

    public function show(Coupon $coupon)
    {

        return view('panel.coupons.show')->with([
            'coupon' => $coupon,
        ]);
    }

    public function edit(Coupon $coupon)
    {
        return view('panel.coupons.edit')->with([
            'coupon' => $coupon,
        ]);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'general' => 'nullable',
            'number' => 'nullable',
            'status' => 'nullable|string|max:255',
            'amount' => 'required|string',
            'shipping_discount' => 'nullable|numeric',
            'start_date' => 'nullable|digits:13',
            'end_date' => 'nullable|digits:13',

        ], [], [
            'code' => 'کد کوپن',
            'title' => 'عنوان',
            'type' => 'نوع کوپن',
            'general' => 'کوپن عمومی',
            'number' => 'تعداد کوپن',
            'status' => 'وضعیت',
            'amount' => 'درصد تخفیف',
            'shipping_discount' => 'تخفیف هزینه ارسال',
            'start_date' => 'تایخ شروع',
            'end_date' => 'تاریخ پایان',
        ]);



        $coupon->update([
            'code' => $request->code,
            'title' => $request->title,
            'type' => $request->type,
            'general' => $request->filled('general'),
            'min_order_amount' => $request->min_order_amount,
            'max_discount_amount' => $request->max_discount_amount,
            'number' => $request->number,
            'is_disposable' => $request->filled('is_disposable'),
            'status' => $request->status,
            'shipping_discount' => $request->shipping_discount,
            'amount' => $request->amount,
            'description' => $request->description,
            'start_date' => $request->start_date ? Carbon::createFromTimestampMs($request->start_date) : null,
            'end_date' => $request->end_date ? Carbon::createFromTimestampMs($request->end_date) :  null,
        ]);


        return redirect()->route('panel.coupons.index')->with([
            'success' => 'اطلاعات کوپن با موفقیت تغییر یافت'
        ]);
    }


    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('panel.coupons.index')->with([
            'success' => 'کوپن انتخابی حذف شد'
        ]);
    }

    public function viewProduct(Request $request)
    {
        if (\strlen($request->products) > 2) {
            $products = Product::where('title', 'LIKE', "%$request->products%")->get();
            return view('panel.coupons.productCard')->with(['products' => $products])->render();
        } else {
            return '';
        }
    }


    public function viewLimit(Coupon $coupon)
    {
        $users = User::all();
        $limits = CouponLimit::where('coupon_id', $coupon->id)->get();
        return view('panel.coupons.limit')->with([
            'coupon' => $coupon,
            'users' => $users,
            'limits' => $limits
        ]);
    }
    public function limitStore(Request $request, Coupon $coupon)
    {
        $request->validate([
            'model_type' => ['required', Rule::in(array_keys(Coupon::$models))],
            'model_id' => 'required|numeric',
        ], [], [
            'model_type' => 'نوع محدودیت',
            'model_id' => 'شناسه'
        ]);

        $coupon->limits()->updateOrCreate([
            'model_type' => $request->model_type,
            'model_id' => $request->model_id,
        ]);

        return \redirect()->back()->with([
            'success' => 'درخواست شما با موفقیت ثبت شد'
        ]);
    }

    public function limitDestroy(CouponLimit $limit)
    {
        $limit->delete();
        return \redirect()->back()->with([
            'success' => 'محدودیت کوپن با موفقیت حذف شد'
        ]);
    }
}
