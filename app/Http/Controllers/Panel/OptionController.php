<?php

namespace App\Http\Controllers\Panel;

use App\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{

    public function index()
    {
        $this->authorize('view options');
        $options = Option::all();

        $site_information_option = $options->where('name','site_information')->first();
        $shipping_option = $options->where('name','shipping')->first();

        $site_information = $site_information_option ? $site_information_option->getValue() : [];
        $shippings = $shipping_option ? $shipping_option->getValue() : [];

        $provinces = collect(config('locality.provinces'));
        $cities = null;

        $selected_province = null;
        $selected_city = null;

        if($site_information['province'] ?? false) {
            $selected_province = $provinces->where('id',$site_information['province']['id'])->first();
        }
        if($site_information['city'] ?? false) {
            if($selected_province) {
                $cities = collect(config('locality.cities'));
                $cities = $cities->where('province',$selected_province['id']);
                $selected_city = $cities->where('id',$site_information['city']['id'])->first();
            }
        }



        return view('panel.options.index')->with([
            'site_information' => $site_information,
            'shippings' => $shippings,
            'provinces' => $provinces,
            'cities' => $cities,
            'selected_province' => $selected_province,
            'selected_city' => $selected_city,
        ]);
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|file|image|max:2000',
        ],[],[
            'logo' => 'لوگو وبسایت'
        ]);

        $value = [];
        $logo = $request->file('logo')->store('images/logos');
        $option = Option::firstOrCreate(['name' => 'site_information']);
        $value = $option->getValue();
        if($value) {
            $prev_logo = $value['logo'] ?? false;
            if($prev_logo) {
                File::delete($prev_logo);
            }
        }
        $value['logo'] = $logo;
        $option->setValue($value);
        return redirect()->route('panel.options.index')->with([
            'success' => 'تغییر لوگو با موفقیت انجام شد'
        ]);
    }
    public function deleteLogo()
    {
        $option = Option::where('name', 'site_information')->firstOrFail();
        $value = $option->getValue();
        if($value) {
            $logo = $value['logo'] ?? false;
            if($logo) {
                File::delete($logo);
            }
        }
        $value['logo'] = '';
        $option->setValue($value);
        return redirect()->route('panel.options.index')->with([
            'success' => 'حذف لوگو با موفقیت انجام شد'
        ]);
    }
    public function updateFooterLogo(Request $request)
    {
        $request->validate([
            'footer_logo' => 'required|file|image|max:2000',
        ],[],[
            'footer_logo' => 'لوگو وبسایت'
        ]);

        $value = [];
        $logo = $request->file('footer_logo')->store('images/logos');
        $option = Option::firstOrCreate(['name' => 'site_information']);
        $value = $option->getValue();
        if($value) {
            $prev_logo = $value['footer_logo'] ?? false;
            if($prev_logo) {
                File::delete($prev_logo);
            }
        }
        $value['footer_logo'] = $logo;
        $option->setValue($value);
        return redirect()->route('panel.options.index')->with([
            'success' => 'تغییر لوگوی فوتر با موفقیت انجام شد'
        ]);
    }
    public function deleteFooterLogo()
    {
        $option = Option::where('name', 'site_information')->firstOrFail();
        $value = $option->getValue();
        if($value) {
            $logo = $value['footer_logo'] ?? false;
            if($logo) {
                File::delete($logo);
            }
        }
        $value['footer_logo'] = '';
        $option->setValue($value);
        return redirect()->route('panel.options.index')->with([
            'success' => 'حذف لوگوی فوتر با موفقیت انجام شد'
        ]);
    }
    public function updateFavicon(Request $request)
    {
        $request->validate([
            'favicon' => 'required|file|image|max:2000',
        ],[],[
            'favicon' => 'لوگو وبسایت'
        ]);

        $value = [];
        $favicon = $request->file('favicon')->store('images/favicons');
        $option = Option::firstOrCreate(['name' => 'site_information']);
        $value = $option->getValue();
        if($value) {
            $prev_favicon = $value['favicon'] ?? false;
            if($prev_favicon) {
                File::delete($prev_favicon);
            }
        }
        $value['favicon'] = $favicon;
        $option->setValue($value);
        return redirect()->route('panel.options.index')->with([
            'success' => 'تغییر آیکن مرورگر با موفقیت انجام شد'
        ]);
    }
    public function deleteFavicon()
    {
        $option = Option::where('name', 'site_information')->firstOrFail();
        $value = $option->getValue();
        if($value) {
            $favicon = $value['favicon'] ?? false;
            if($favicon) {
                File::delete($favicon);
            }
        }
        $value['favicon'] = '';
        $option->setValue($value);
        return redirect()->route('panel.options.index')->with([
            'success' => 'حذف آیکن مرورگر با موفقیت انجام شد'
        ]);
    }

    public function siteInformation(Request $request)
    {
        $request->merge([
            'shop_mobile' => convertNumbers($request->shop_mobile, false)
        ]);
        $request->validate([
            'website_name' => 'required|string|max:255',
            'main_title' => 'nullable|string|max:255',
            'shop_mobile' => 'nullable|regex:/^09\d{9}$/',
            'shop_phone' => 'nullable|numeric',
            'instagram' => 'nullable|string',
            'telegram' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'copyright' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:3000',
            'province' => 'required|numeric',
            'city' => 'required|numeric'
        ],[],[
            'website_name' => 'نام وبسایت',
            'main_title' => 'عنوان صفحه اصلی',
            'shop_mobile' => 'موبایل فروشگاه',
            'shop_phone' => 'تلفن فروشگاه',
            'address' => 'آدرس',
            'copyright' => 'متن کپی رایت',
            'description' => 'توضیحات وبسایت',
            'province' => 'استان',
            'instagram' => 'اینستاگرام',
            'telegram' => 'تلگرام',
            'city' => 'شهر',
        ]);

        $option = Option::firstOrCreate(['name' => 'site_information']);
        $value = $option->getValue();
        $value['website_name'] = $request->website_name;
        $value['main_title'] = $request->main_title;
        $value['shop_mobile'] = $request->shop_mobile;
        $value['shop_phone'] = $request->shop_phone;
        $value['instagram'] = $request->instagram;
        $value['telegram'] = $request->telegram;
        $value['address'] = $request->address;
        $value['copyright'] = $request->copyright;
        $value['description'] = $request->description;

        $provinces = collect(config('locality.provinces'));
        $province = $provinces->where('id',$request->province)->first();
        if(!$province) {
            return redirect()->route('panel.options.index')->withErrors('استان انتخاب شده نامعتبر می باشد');
        }
        $cities = collect(config('locality.cities'));
        $cities = $cities->where('province',$province['id']);
        $city = $cities->where('id',$request->city)->first();
        if(!$city) {
            return redirect()->route('panel.options.index')->withErrors('شهر انتخاب شده نامعتبر می باشد');
        }
        $value['province'] = $province;
        $value['city'] = $city;
        $option->setValue($value);
        return redirect()->route('panel.options.index')->with([
            'success' => 'اطلاعات وبسایت با موفقیت ثبت شد'
        ]);

    }

    public function updateShipping(Request $request)
    {

        $option = Option::firstOrCreate(['name' => 'shipping']);
        $value = $option->getValue() ?? [];

        switch ($request->type) {
            case 'in_place_delivery' :{
                $value['in_place_delivery']['is_active'] = $request->is_active ? true : false;
                $value['in_place_delivery']['in_city'] = $request->filled('in_city');
                $value['in_place_delivery']['in_province'] = $request->filled('in_province');
                break;
            }
            case 'bike_shipping' :{
                $request->validate([
                    'price' => 'nullable|numeric|min:0'
                ],[],[
                    'price' => 'مبلغ'
                ]);
                $value['bike_shipping']['is_active'] = $request->is_active ? true : false;
                $value['bike_shipping']['price'] = $request->price ?: 0;
                break;
            }
            case 'post_shipping' :{
                $request->validate([
                    'province_price' => 'nullable|numeric|min:0',
                    'other_provinces_price' => 'nullable|numeric|min:0',
                ],[],[
                    'province_price' => 'قیمت برای استان',
                    'other_provinces_price' => 'قیمت برای سایر شهرها',
                ]);
                $value['post_shipping']['is_active'] = $request->is_active ? true : false;
                $value['post_shipping']['province_price'] = $request->province_price ?: 0;
                $value['post_shipping']['other_provinces_price'] = $request->other_provinces_price ?: 0;
                break;
            }
            case 'free_shipping' :{
                $request->validate([
                    'province_min_order_price' => 'nullable|numeric|min:0',
                    'all_min_order_price' => 'nullable|numeric|min:0',
                ],[],[
                    'province_min_order_price' => 'قیمت برای استان',
                    'all_min_order_price' => 'قیمت برای سایر شهرها',
                ]);
                $value['free_shipping']['is_active'] = $request->is_active ? true : false;
                $value['free_shipping']['province_min_order_price'] = $request->province_min_order_price ?: 0;
                $value['free_shipping']['all_min_order_price'] = $request->all_min_order_price ?: 0;
                $value['free_shipping']['all_cities'] = $request->filled('all_cities');
                $value['free_shipping']['show_other_shipping'] = $request->filled('show_other_shipping');
                break;
            }
        }

        $option->setValue($value);

        return redirect()->route('panel.options.index')->with([
            'success' => 'تنظیمات ارسال با موفقیت به روز شد'
        ]);

    }


}
