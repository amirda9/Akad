<?php

namespace App;

use App\Widgets\ArticleCategorySlider;
use App\Widgets\CategoryProductSlider;
use App\Widgets\ImageBlock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Option extends Model
{
    protected $table = 'options';
    protected $guarded = [];
    public $timestamps = false;

    public static $positions = [
        'right_main_slider' => 'سمت راست اسلاید اصلی',
        'bottom_main_slider' => 'پایین اسلاید اصلی',
        'top_featured_products' => 'بالای محصولات ویژه',
        'bottom_featured_products' => 'پایین محصولات ویژه',
        'top_latest_products' => 'بالای آخرین محصولات',
        'bottom_latest_products' => 'پایین آخرین محصولات',
        'top_footer' => 'بالای فوتر',
        'top_product_full_description' => 'بالای توضیحات کامل محصول',
        'bottom_product_full_description' => 'پایین توضیحات کامل محصول',
        'top_related_products' => 'بالای محصولات مرتبط',
        'bottom_related_products' => 'پایین محصولات مرتبط',
    ];
    public static $widgets = [
        'image_block' => ImageBlock::class,
        'category_product_slider' => CategoryProductSlider::class,
        'article_category_slider' => ArticleCategorySlider::class,
    ];

    public function setValue($data)
    {
        Cache::forget("options_$this->name");
        $this->update([
            'value' => json_encode($data)
        ]);
    }

    public function getValue()
    {
        return json_decode($this->value,true);
    }

}
