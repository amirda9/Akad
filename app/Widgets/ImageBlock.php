<?php

namespace App\Widgets;

use App\Option;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Http\Request;

class ImageBlock extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    public $config = [
        'title' => '',
        'id' => '',
        'order' => 0,
        'position' => '',
        'image1' => null,
        'image2' => null,
        'image3' => null,
        'image4' => null,
        'link1' => '',
        'link2' => '',
        'link3' => '',
        'link4' => '',
        'images_class' => '',
        'container_class' => '',
    ];

    public function validate(Request $request) {

        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|numeric',
            'position' => 'required|string',
            'image1' => 'required|string',
            'image2' => 'nullable|string',
            'image3' => 'nullable|string',
            'image4' => 'nullable|string',
            'link1' => 'nullable|string',
            'link2' => 'nullable|string',
            'link3' => 'nullable|string',
            'link4' => 'nullable|string',
            'images_class' => 'nullable|string',
            'container_class' => 'nullable|string',
        ],[],[
            'title' => 'عنوان ابزارک',
            'position' => 'موقعیت',
            'image1' => 'تصویر اول',
            'image2' => 'تصویر دوم',
            'image3' => 'تصویر سوم',
            'image4' => 'تصویر چهارم',
            'link1' => 'لینک اول',
            'link2' => 'لینک دوم',
            'link3' => 'لینک سوم',
            'link4' => 'لینک چهارم',
            'images_class' => 'کلاس تصاویر',
            'container_class' => 'کلاس ویجت',
        ]);
    }

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->config['id'] = array_key_exists('id',$config) ? $config['id'] : time();
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        return view('widgets.image_block', [
            'config' => $this->config,
        ]);
    }

    public function set(Request $request)
    {
        $this->validate($request);
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
        $image_blocks = [];
        $option = Option::where('name','widgets')->first();
        if($option) {
            $widgets = $option->getValue();
            $widgets = collect($widgets);
            $image_blocks = $widgets->where('name','image_block');
        }

        $image_blocks = collect($image_blocks);
        $image_blocks = $image_blocks->sortBy('order');
        $positions = Option::$positions;
        return view('panel.widgets.image_block')->with([
            'image_blocks' => $image_blocks,
            'positions' => $positions,
        ])->render();
    }
}
