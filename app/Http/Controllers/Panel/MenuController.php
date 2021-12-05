<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class MenuController extends Controller
{

    public function index()
    {
        $this->authorize('view menus');
        $menus = Menu::all();
        return view('panel.menus.index')
            ->with('menus',$menus);
    }




    public function create()
    {
        $this->authorize('create menu');
        return view('panel.menus.create');
    }




    public function store(Request $request)
    {
        $this->authorize('create menu');
        $request->validate([
            'title' => 'required|string|max:255',
            'name' => ['required','string','regex:/^\w+$/','unique:menus,name'],
        ],[],[
            'title' => 'عنوان',
            'name' => 'نام'
        ]);

        Menu::create([
            'name' => $request->name,
            'title' => $request->title
        ]);

        return redirect()->route('panel.menus.index')
            ->with('success','منو جدید با موفقیت اضافه شد');
    }




    public function show(Menu $menu)
    {
        $this->authorize('view menus');
        return redirect()->route('panel.menuItems.index',$menu);
    }




    public function edit(Menu $menu)
    {
        $this->authorize('edit menu');
        return view('panel.menus.edit',$menu)
            ->with('menu',$menu);
    }




    public function update(Request $request, Menu $menu)
    {
        $this->authorize('edit menu');
        $request->validate([
            'title' => 'required|string|max:255',
            'name' => ['required','string','regex:/^\w+$/',Rule::unique('menus','name')->ignore($menu->id)],
        ],[],[
            'title' => 'عنوان',
            'name' => 'نام'
        ]);

        $menu->update([
            'name' => $request->name,
            'title' => $request->title
        ]);

        return redirect()->route('panel.menus.index')
            ->with('success','منوی مورد نظر با موفقیت ویرایش شد');
    }




    public function destroy(Menu $menu)
    {
        $this->authorize('delete menu');
        if ($menu->items()->count()) {
            return redirect()->route('panel.menus.index')
                ->withErrors('لطفا ابتدا آیتم های این منو را حذف کنید');
        }
        $menu->delete();
        return redirect()->route('panel.menus.index')
            ->with('success','منوی مورد نظر با موفقیت حذف شد');
    }
}
