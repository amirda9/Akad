<?php

namespace App\Widgets;

use App\MenuItem;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Cache;
use App\Menu as MenuModel;

class Menu extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'menu' => ''
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $items = MenuItem::whereHas('menu', function($query){
            $query->where('name', $this->config['name']);
        })->orderBy('order','asc')->where('parent_id',null)->with(['children' => function($q) {
            $q->orderBy('order','asc');
    }])->get();
        return view('widgets.menu', [
            'config' => $this->config,
            'items' => $items
        ]);
    }
}
