<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Option;
use App\Widgets\ImageBlock;
use Illuminate\Http\Request;
use Mockery\Exception;

class WidgetController extends Controller
{
    public function index()
    {
        $this->authorize('view options');

        $widgets = Option::$widgets;

        return view('panel.options.widgets')->with([
            'widgets' => $widgets,
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ],[],[
            'name' => 'نام ابزارک'
        ]);
        $widget = new Option::$widgets[$request->name]($request->except(['_token','_method']));
        $widget->set($request);
        return redirect()->route('panel.widgets.index')->with([
            'success' => 'عملیات مورد نظر با موفقیت انجام شد'
        ]);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ],[],[
            'name' => 'نام ابزارک'
        ]);
        $request->merge(['id' => $id]);
        $widget = new Option::$widgets[$request->name]($request->except(['_token']));
        $widget->set($request);
        return redirect()->route('panel.widgets.index')->with([
            'success' => 'عملیات مورد نظر با موفقیت انجام شد'
        ]);
    }



    public function destroy(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ],[],[
            'name' => 'نام ابزارک'
        ]);

        $request->merge([
            'id' => $id
        ]);

        $widget = new Option::$widgets[$request->name]($request->except(['name','_token']));
        $widget->delete();
        return redirect()->route('panel.widgets.index')->with([
            'success' => 'عملیات مورد نظر با موفقیت انجام شد'
        ]);
    }
}
