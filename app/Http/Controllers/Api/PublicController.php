<?php

namespace App\Http\Controllers\Api;

use App\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{

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
