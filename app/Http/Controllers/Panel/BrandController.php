<?php

namespace App\Http\Controllers\Panel;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{

    public function index()
    {
        $this->authorize('view brands');

        $brands = Brand::orderBy('created_at','desc');

        if(request('search')) {
            $brands = $brands->where('name','LIKE','%'.request('search').'%');
        }

        $brands = $brands->paginate();
        $brands->appends(request()->query());

        return view('panel.brands.index')->with([
            'brands' => $brands
        ]);
    }



    public function create()
    {
        $this->authorize('create brand');
        return view('panel.brands.create');
    }



    public function store(Request $request)
    {
        $this->authorize('create brand');
        $request->validate([
            'name' => 'required|string|max:255',
            'en_name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:1000',
            'image' => 'nullable|file|image|max:500',
            'logo' => 'nullable|file|image|max:500',
            'short_description' => 'nullable|string|max:1000',
            'published' => 'required|boolean',
            'full_description' => 'nullable|string',
            'order' => 'nullable|numeric',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ],[],[
            'name' => 'نام برند',
            'en_name' => 'نام انگلیسی',
            'slug' => 'اسلاگ',
            'image' => 'تصویر برند',
            'logo' => 'لوگو برند',
            'order' => 'ترتیب نمایش',
            'short_description' => 'توضیحات کوتاه',
            'published' => 'وضعیت انتشار',
            'full_description' => 'توضیحات کامل',
            'meta_title' => 'عنوان متا',
            'meta_description' => 'توضیحات متا',
        ]);

        $slug = remove_spec($request->name);
        if($request->slug) {
            $slug = remove_spec($request->slug);
        }
        if(Brand::whereSlug($slug)->count()) {
            $slug = $slug . '-' . time();
        }

        $image = null;
        if($request->image) {
            $image = $request->file('image')->store('images/brands');
        }
        $logo = null;
        if($request->logo) {
            $logo = $request->file('logo')->store('images/brands');
        }

        Brand::create([
            'name' => $request->name,
            'en_name' => $request->en_name,
            'slug' => $slug,
            'image' => $image,
            'logo' => $logo,
            'order' => $request->order ?: 0,
            'published' => $request->published == 1,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'meta_title' => $request->meta_title ,
            'meta_description' => $request->meta_description ,
        ]);

        return redirect()->route('panel.brands.index')
            ->with([
                'success' => 'برند جدید اضافه شد'
            ]);
    }



    public function show(Brand $brand)
    {
        return view('brands.show')->with([
            'brand' => $brand
        ]);
    }



    public function edit(Brand $brand)
    {
        $this->authorize('edit brand');
        return view('panel.brands.edit')->with('brand',$brand);
    }



    public function update(Request $request, Brand $brand)
    {
        $this->authorize('edit brand');
        $request->validate([
            'name' => 'required|string|max:255',
            'en_name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brands,slug',
            'image' => 'nullable|file|image|max:500',
            'logo' => 'nullable|file|image|max:500',
            'short_description' => 'nullable|string|max:1000',
            'full_description' => 'nullable|string',
            'published' => 'required|boolean',
            'order' => 'nullable|numeric',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ],[],[
            'name' => 'نام برند',
            'slug' => 'اسلاگ',
            'image' => 'تصویر برند',
            'logo' => 'لوگو برند',
            'order' => 'ترتیب نمایش',
            'short_description' => 'توضیحات کوتاه',
            'published' => 'وضعیت انتشار',
            'full_description' => 'توضیحات کامل',
            'meta_title' => 'عنوان متا',
            'meta_description' => 'توضیحات متا',
        ]);

        $image = $brand->image;
        if($request->image) {
            File::delete($image);
            $image = $request->file('image')->store('images/brands','local');
        }
        $logo = $brand->logo;
        if($request->logo) {
            File::delete($logo);
            $logo = $request->file('logo')->store('images/brands','local');
        }

        $slug = $brand->slug;
        if($request->slug != $brand->slug) {
            $slug = remove_spec($request->name);
            if ($request->slug != null) {
                $slug = remove_spec($request->slug);
            }
            if(Brand::whereSlug($slug)->where('id','<>',$brand->id)->count()) {
                $slug = $slug . '-' . time();
            }
        }

        $brand->update([
            'name' => $request->name,
            'en_name' => $request->en_name,
            'slug' => $slug,
            'image' => $image,
            'logo' => $logo,
            'order' => $request->order ?: 0,
            'published' => $request->published == 1,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'meta_title' => $request->meta_title ,
            'meta_description' => $request->meta_description ,
        ]);

        return redirect()->route('panel.brands.index')
            ->with([
                'success' => 'تغییرات برند با موفقیت ذخیره شد'
            ]);
    }



    public function destroy(Brand $brand)
    {
        $this->authorize('delete brand');
        // TODO:: check for menu
        if($brand->products()->count()){
            return back()->withErrors('لطف ابتدا محصولات این برند را حذف کنید');
        }
        File::delete([$brand->image, $brand->logo]);
        $brand->delete();
        return redirect()->route('panel.brands.index')
            ->with('success','برند مورد نظر شما با موفقیت حذف شد');
    }

    public function deleteImage(Brand $brand)
    {
        $this->authorize('edit brand');
        File::delete($brand->image);
        $brand->update([
            'image' => null
        ]);
        return redirect()->route('panel.brands.index')
            ->with('success','تصویر برند مورد نظر شما با موفقیت حذف شد');
    }
    public function deleteLogo(Brand $brand)
    {
        $this->authorize('edit brand');
        File::delete($brand->logo);
        $brand->update([
            'logo' => null
        ]);
        return redirect()->route('panel.brands.index')
            ->with('success','لوگو برند مورد نظر شما با موفقیت حذف شد');
    }
}
