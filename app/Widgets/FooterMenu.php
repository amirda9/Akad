<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class FooterMenu extends AbstractWidget
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
        $menu = \App\Menu::where('name',$this->config['name'])->with(['items' => function($q) {
            $q->orderBy('order','asc');
        }])->first();

        return view('widgets.footer_menu', [
            'config' => $this->config,
            'menu' => $menu
        ]);
    }
}
