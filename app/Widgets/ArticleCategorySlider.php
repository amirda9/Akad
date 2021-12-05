<?php

namespace App\Widgets;

use App\Article;
use App\Option;
use App\ArticleCategory;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Http\Request;

class ArticleCategorySlider extends AbstractWidget
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
    ];

    public function validate(Request $request) {

        $request->validate([
            'order' => 'required|numeric',
            'position' => 'required|string',
            'category_id' => 'required|numeric|exists:article_categories,id',
        ],[],[
            'position' => 'موقعیت',
            'order' => 'ترتیب نمایش',
            'category_id' => 'دسته بندی',
        ]);
    }

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->config['id'] = array_key_exists('id',$config) ? $config['id'] : time();
    }


    public function run()
    {
        $article_category = ArticleCategory::find($this->config['category_id']);
        $all_categories = [];
        $this->config['title'] = $article_category->name;
        $this->config['link'] = $article_category->getRoute();
        getAllCategoryChildren($article_category,$all_categories);
        $this->config['items'] = Article::published()->whereHas('categories',function($q) use($all_categories) {
            $q->whereIn('id',$all_categories);
        })->latest()->take(20)->get();
        return view('widgets.article_category_slider', [
            'config' => $this->config,
        ]);
    }

    public function set(Request $request)
    {
        $this->validate($request);
        $article_category = ArticleCategory::findOrFail($request->category_id);
        $this->config['title'] = $article_category->name;
        $this->config['link'] = $article_category->getRoute();
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
        $article_category_sliders = [];
        $option = Option::where('name','widgets')->first();
        if($option) {
            $widgets = $option->getValue();
            $widgets = collect($widgets);
            $article_category_sliders = $widgets->where('name','article_category_slider');
        }
        $article_category_sliders = collect($article_category_sliders);
        $article_category_sliders = $article_category_sliders->sortBy('order');
        $positions = Option::$positions;
        $article_categories = ArticleCategory::orderBy('order','asc')->get();
        return view('panel.widgets.article_category_slider')->with([
            'article_category_sliders' => $article_category_sliders,
            'positions' => $positions,
            'article_categories' => $article_categories,
        ])->render();
    }
}
