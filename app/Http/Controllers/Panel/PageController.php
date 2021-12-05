<?php

namespace App\Http\Controllers\Panel;

use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class PageController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('view pages');
        $pages = Page::orderBy('created_at','desc');

        if($request->search) {
            $pages = $pages->where('title','LIKE',"%$request->search%");
        }

        $pages = $pages->paginate();
        $pages->appends(request()->query());

        return view('panel.pages.index')->with('pages',$pages);

    }


    public function create()
    {
        $this->authorize('create page');
        return view('panel.pages.create');
    }


    public function store(Request $request)
    {
        $this->authorize('create page');
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'short_description' => 'required|string|max:1000',
            'full_description' => 'nullable|string',
            'image' => 'nullable|file|image|max:1000',
            'published' => 'required|boolean',
            'meta_title' => 'nullable|string|255,',
            'meta_description' => 'nullable|string|255,',
        ],[],[
            'title' => 'عنوان',
            'slug' => 'اسلاگ',
            'short_description' => 'توضیحات کوتاه',
            'full_description' => 'توضیحات کامل',
            'image' => 'تصویر',
            'published' => 'وضعیت انتشار',
        ]);

        $image = null;
        if($request->image) {
            $image = $request->file('image')->store('images/pages','local');
        }

        $slug = remove_spec($request->title);
        if ($request->slug != null) {
            $slug = remove_spec($request->slug);
        }
        if(Page::whereSlug($slug)->count()) {
            $slug = $slug . '-' . time();
        }

        Page::create([
            'title' => $request->title,
            'slug' => $slug,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'image' => $image,
            'published' => $request->published == 1,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->route('panel.pages.index')
            ->with('success','صفحه جدید با موفقیت اضافه شد');
    }


    public function show(Page $page)
    {
        return view('page')->with([
            'page' => $page
        ]);
    }


    public function edit(Page $page)
    {
        $this->authorize('edit page');
        return view('panel.pages.edit')->with('page',$page);
    }


    public function update(Request $request, Page $page)
    {
        $this->authorize('edit page');
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['nullable','string','max:255',Rule::unique('pages','slug')->ignore($page->id)],
            'short_description' => 'required|string|max:1000',
            'full_description' => 'nullable|string',
            'image' => 'nullable|file|image|max:1000',
            'published' => 'required|boolean',
            'meta_title' => 'nullable|string|255,',
            'meta_description' => 'nullable|string|255,',
        ],[],[
            'title' => 'عنوان',
            'slug' => 'اسلاگ',
            'short_description' => 'توضیحات کوتاه',
            'full_description' => 'توضیحات کامل',
            'image' => 'تصویر',
            'published' => 'وضعیت انتشار',
        ]);

        $image = $page->image;
        if($request->image) {
            File::delete($image);
            $image = $request->file('image')->store('images/pages','local');
        }

        $slug = $page->slug;
        if($request->slug != $page->slug) {
            $slug = remove_spec($request->title);
            if ($request->slug != null) {
                $slug = remove_spec($request->slug);
            }
            if(Page::whereSlug($slug)->where('id','<>',$page->id)->count()) {
                $slug = $slug . '-' . time();
            }
        }

        $page->update([
            'title' => $request->title,
            'slug' => $slug,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'image' => $image,
            'published' => $request->published == 1,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->route('panel.pages.index')
            ->with('success','صفحه مورد نظر شما با موفقیت ویرایش شد');
    }


    public function destroy(Page $page)
    {
        $this->authorize('delete page');
        if($page->image) {
            File::delete($page->image);
        }
        $page->delete();
        return redirect()->route('panel.pages.index')->with('success','صفحه مورد نظر شما با موفقیت حذف شد');
    }


    public function deleteImage(Page $page)
    {
        $this->authorize('edit page');
        if($page->image) {
            File::delete($page->image);
        }
        $page->update([
            'image' => null
        ]);
        return redirect()->route('panel.pages.index')->with('success','تصویر شاخص مورد نظر شما با موفقیت حذف شد');
    }


    public function changePublished(Page $page)
    {
        $this->authorize('edit page');
        $page->update([
            'published' => !$page->published
        ]);

        return redirect()->route('panel.pages.index')->with('success','وضعیت صفحه مورد نظر تغییر کرد');
    }
}
