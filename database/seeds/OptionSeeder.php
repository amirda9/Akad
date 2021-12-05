<?php

use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $option = \App\Option::firstOrCreate(['name' => 'site_information']);
        $value = [];
        $value['website_name'] = env('APP_NAME','');
        $option->setValue($value);

        $option = \App\Option::firstOrCreate(['name' => 'shipping']);
        $value = [];

        $free_shipping = [];
        $free_shipping['title'] = 'ارسال رایگان';
        $free_shipping['is_active'] = false;
        $free_shipping['province_min_order_price'] = 0;
        $free_shipping['all_min_order_price'] = 0;
        $free_shipping['all_cities'] = false;
        $free_shipping['show_other_shipping'] = false;
        $value['free_shipping'] = $free_shipping;

        $post_shipping = [];
        $post_shipping['title'] = 'ارسال پستی';
        $post_shipping['is_active'] = true;
        $post_shipping['province_price'] = 5000;
        $post_shipping['other_provinces_price'] = 12000;
        $value['post_shipping'] = $post_shipping;

        $bike_shipping = [];
        $bike_shipping['title'] = 'ارسال با پیک';
        $bike_shipping['is_active'] = false;
        $bike_shipping['price'] = 4000;
        $value['bike_shipping'] = $bike_shipping;

        $in_place_delivery = [];
        $in_place_delivery['title'] = 'دریافت حضوری';
        $in_place_delivery['is_active'] = false;
        $in_place_delivery['in_city'] = false;
        $in_place_delivery['in_province'] = false;
        $value['in_place_delivery'] = $in_place_delivery;
        $option->setValue($value);
    }
}
