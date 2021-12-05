<?php

namespace App\Http\Controllers\Panel;

use App\ArticleCategory;
use App\Http\Controllers\Controller;
use App\Menu;
use App\MenuItem;
use App\Page;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MenuItemController extends Controller
{


    public function index(Menu $menu)
    {
        $this->authorize('view menus');
        $items = $menu->items()->where('parent_id',null)->orderBy('order','asc')->get();
        $product_categories = ProductCategory::where('parent_id',null)->orderBy('order','asc')->get();
        $article_categories = ArticleCategory::where('parent_id',null)->orderBy('order','asc')->get();
        $pages = Page::all();

        return view('panel.menus.items.index')
            ->with([
                'menuItems' => $items,
                'parents' => $items,
                'product_categories' => $product_categories,
                'article_categories' => $article_categories,
                'pages' => $pages,
                'menu' => $menu
            ]);
    }


    public function store(Request $request, Menu $menu)
    {
        $this->authorize('create menu');

        $request->validate([
            'type' => 'required|string|in:link,product_category,page,article_category'
        ],[],[
            'type' => 'نوع منو'
        ]);

        switch ($request->type) {
            case 'link': {
                return $this->add_link($request, $menu);
            }
            case 'product_category': {
                return $this->add_product_category($request, $menu);
            }
            case 'article_category': {
                return $this->add_article_category($request, $menu);
            }
            case 'page': {
                return $this->add_page($request, $menu);
            }
            default : {
                return redirect()->route('panel.menuItems.index',$menu)
                    ->withErrors('نوع منو انتخاب شده نامعتبر می باشد');
            }
        }

    }

    public function add_link(Request $request,Menu $menu)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ],[],[
            'title' => 'عنوان',
            'link' => 'لینک',
        ]);

        MenuItem::create([
            'title' => $request->title,
            'link' => $request->link,
            'menu_id' => $menu->id,
            'new_page' => $request->filled('new_page'),
        ]);

        Cache::forget('menu_'.$menu->name);

        return redirect()->route('panel.menuItems.index',$menu)
            ->with('success','آیتم منو جدید با موفقیت اضافه شد');
    }

    public function add_product_category(Request $request,Menu $menu)
    {
        $product_categories = ProductCategory::whereIn('id',$request->product_categories)->orderBy('order','asc')->get();
        $level = 0;
        while ($product_categories->count()) {
            foreach($product_categories as $product_category) {
                if($product_category->level == $level) {
                    $product_category->menu_item()->create([
                        'title' => $product_category->name,
                        'order' => $product_category->order,
                        'menu_id' => $menu->id,
                        'parent_id' => $product_category->parent ? $product_category->parent->menu_item->id : null
                    ]);
                    $product_categories = $product_categories->filter(function($item) use($product_category){
                        return $item->id != $product_category->id;
                    });
                }
            }
            $level++;
        }

        Cache::forget('menu_'.$menu->name);

        return redirect()->route('panel.menuItems.index',$menu)
            ->with('success','آیتم منو جدید با موفقیت اضافه شد');
    }
    public function add_article_category(Request $request,Menu $menu)
    {
        $article_categories = ArticleCategory::whereIn('id',$request->article_categories)->orderBy('order','asc')->get();
        $level = 0;
        while ($article_categories->count()) {
            foreach($article_categories as $article_category) {
                if($article_category->level == $level) {
                    $article_category->menu_item()->create([
                        'title' => $article_category->name,
                        'order' => $article_category->order,
                        'menu_id' => $menu->id,
                        'parent_id' => $article_category->parent ? $article_category->parent->menu_item->id : null
                    ]);
                    $article_categories = $article_categories->filter(function($item) use($article_category){
                        return $item->id != $article_category->id;
                    });
                }
            }
            $level++;
        }

        Cache::forget('menu_'.$menu->name);

        return redirect()->route('panel.menuItems.index',$menu)
            ->with('success','آیتم منو جدید با موفقیت اضافه شد');
    }

    public function add_page(Request $request,Menu $menu)
    {
        $pages = Page::whereIn('id',$request->pages)->get();
        foreach($pages as $page) {
            $page->menu_item()->create([
                'title' => $page->title,
                'menu_id' => $menu->id,
            ]);
        }

        Cache::forget('menu_'.$menu->name);

        return redirect()->route('panel.menuItems.index',$menu)
            ->with('success','آیتم منو جدید با موفقیت اضافه شد');
    }


    public function update(Request $request, Menu $menu, MenuItem $menuItem)
    {
        $this->authorize('edit menu');
        $request->validate([
            'title' => 'required|string|max:255',
            'link' => [$menuItem->link ? 'required' : 'nullable','string','max:255'],
            'order' => 'nullable|numeric',
            'icon_class' => 'nullable|string|max:191',
            'parent' => 'nullable|exists:menu_items,id',
        ],[],[
            'title' => 'عنوان',
            'link' => 'لینک',
            'order' => 'ترتیب نمایش',
            'icon_class' => 'کلاس آیکن',
            'parent' => 'آیتم والد',
        ]);

        if($request->parent) {
            $parent = MenuItem::findOrFail($request->parent);
            while($parent != null) {
                if($parent->id == $menuItem->id) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors([
                            'parent' => 'آیتم والد انتخاب شده نامعتبر می باشد'
                        ]);
                }
                $parent = $parent->parent;
            }
        }

        $menuItem->update([
            'title' => $request->title,
            'icon_class' => $request->icon_class,
            'link' => $request->link,
            'order' => $request->order ?: 0,
            'parent_id' => $request->parent,
            'new_page' => $request->filled('new_page'),
        ]);

        Cache::forget('menu_'.$menu->name);

        return redirect()->route('panel.menuItems.index',$menu)
            ->with('success','آیتم منو مورد نظر با موفقیت ویرایش شد');
    }


    public function destroy(Menu $menu, MenuItem $menuItem)
    {
        $this->authorize('delete menu');
        if($menuItem->children()->count()) {
            return redirect()->route('panel.menuItems.index',$menu)
                ->withErrors('آیتم منویی که دارای زیر شاخه باشد را نمی توان حذف کرد');
        }
        $menuItem->delete();
        Cache::forget('menu_'.$menu->name);
        return redirect()->route('panel.menuItems.index',$menu)
            ->with('success','آیتم منو مورد نظر با موفقیت حذف شد');
    }
}
