<?php

namespace App\Widgets;

use App\MenuItem;
use Arrilot\Widgets\AbstractWidget;

class DrawerMenu extends AbstractWidget
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
        })->where('parent_id',null)->with('children')->get();
        return view('widgets.drawer_menu', [
            'config' => $this->config,
            'items' => $items
        ]);
    }
}
