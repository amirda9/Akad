<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\CouponLimit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function checkCoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();

        $validation = $coupon->isValid();
        if (!$validation['isValid']) {
            return $validation['message'];
        }

        $coupon_limits = CouponLimit::where('coupon_id', $coupon->id)->get();
    }
}
