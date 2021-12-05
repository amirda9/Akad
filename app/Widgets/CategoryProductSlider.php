<?php

namespace App\Widgets;

use App\Option;
use App\Product;
use App\ProductCategory;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Http\Request;

class CategoryProductSlider extends AbstractWidget
{

    protected $config = [
        'title' => '',
        'id' => '',
        'category_id' => '',
        'order' => 0,
        'position' => '',
        'link' => '',
        'link_title' => 'مشاهده بیشتر',
        'items' => [],
        'container_class' => '',
    ];

    public function validate(Request $request) {

        $request->validate([
            'order' => 'required|numeric',
            'position' => 'required|string',
            'category_id' => 'required|numeric|exists:product_categories,id',
            'container_class' => 'nullable|string',
        ],[],[
            'position' => 'موقعیت',
            'order' => 'ترتیب نمایش',
            'category_id' => 'دسته بندی',
            'container_class' => 'کلاس ویجت',
        ]);
    }

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->config['id'] = array_key_exists('id',$config) ? $config['id'] : time();
    }


    public function run()
    {
        $product_category = ProductCategory::find($this->config['category_id']);
        $all_categories = [];
        $this->config['title'] = $product_category->name;
        $this->config['link'] = $product_category->getRoute();
        getAllCategoryChildren($product_category,$all_categories);
        $products = Product::published()->whereHas('categories',function($q) use($all_categories) {
            $q->whereIn('id',$all_categories);
        })->latest()->take(20)->get();
        $this->config['items'] = $products->filter(function ($product) {
            return $product->is_in_stock;
        });
        return view('widgets.category_product_slider', [
            'config' => $this->config,
        ]);
    }

    public function set(Request $request)
    {
        $this->validate($request);
        $product_category = ProductCategory::findOrFail($request->category_id);
        $this->config['title'] = $product_category->name;
        $this->config['link'] = $product_category->getRoute();
        $option = Option::firstOrCreate(['name' => 'widgets']);
        $widgets = json_decode($option->value);
        $widgets = collect($widgets);
        $widgets = $widgets->where('id','<>',$this->config['id'])->toArray();
        $widgets[] = $this->config;
        $option->setValue($widgets);
    }

    public function delete()
    {
        $option = Option::firstOrCreate(['name' => 'widgets']);
        $widgets = $option->getValue();
        $widgets = collect($widgets);
        $widgets = $widgets->where('id','<>',$this->config['id'])->toArray();
        $option->setValue($widgets);
    }

    public static function form()
    {
        $category_product_sliders = [];
        $option = Option::where('name','widgets')->first();
        if($option) {
            $widgets = $option->getValue();
            $widgets = collect($widgets);
            $category_product_sliders = $widgets->where('name','category_product_slider');
        }
        $category_product_sliders = collect($category_product_sliders);
        $category_product_sliders = $category_product_sliders->sortBy('order');
        $positions = Option::$positions;
        $product_categories = ProductCategory::orderBy('order','asc')->get();
        return view('panel.widgets.category_product_slider')->with([
            'category_product_sliders' => $category_product_sliders,
            'positions' => $positions,
            'product_categories' => $product_categories,
        ])->render();
    }
}
