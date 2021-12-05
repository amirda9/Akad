<?php

namespace App\Widgets;

use App\Product;
use Arrilot\Widgets\AbstractWidget;

class HorizontalSlider extends AbstractWidget
{
    protected $config = [
        'type' => '',
        'title' => '',
        'link' => '',
        'link_title' => 'مشاهده بیشتر',
        'items' => [],
        'count' => 15,
        'colored' => false,
        'text_color' => 'white',
        'background_color' => 'success',
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        switch ($this->config['type']) {
            case 'latest_products' : {
                if(!$this->config['title']) {
                    $this->config['title'] = 'آخرین محصولات';
                }
                $products = Product::published()->latest()
                    ->take($this->config['count'])->get();
                $this->config['items'] = $products->filter(function($product) {
                    return $product->is_in_stock;
                });
                break;
            }
            case 'featured_products' : {
                if(!$this->config['title']) {
                    $this->config['title'] = 'محصولات ویژه';
                }
                $products = Product::published()->latest()
                    ->where('is_featured',true)->take($this->config['count'])->get();
                $this->config['items'] = $products->filter(function($product) {
                    return $product->is_in_stock;
                });
                break;
            }
        }



        return view('widgets.horizontal_slider', [
            'config' => $this->config,
        ]);
    }
}
