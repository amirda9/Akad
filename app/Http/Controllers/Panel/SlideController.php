<?php

namespace App\Http\Controllers\Panel;

use App\Slide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class SlideController extends Controller
{
    
    public function index()
    {
        $this->authorize('view slides');
        $slides = Slide::orderBy('order','asc')->get();
        return view('panel.slides.index')->with('slides',$slides);
    }
    public function create()
    {
        $this->authorize('create slide');
        return view('panel.slides.create');
    }
    public function store(Request $request)
    {
        $this->authorize('create slide');
        $request->validate([
            'image' => 'required|file|image|max:2000',
            'link' => 'nullable|string|max:255',
            'position' => ['required', 'in:website,application'],
            'order' => 'nullable|numeric'
        ],[],[
            'image' => 'تصویر',
            'link' => 'لینک',
            'position' => 'موقعیت نمایش',
            'order' => 'ترتیب نمایش',
        ]);

        $image = $request->file('image')->store('images/slides/', 'local');

        Slide::create([
            'image' => $image,
            'link' => $request->link,
            'position' => $request->position,
            'order' => $request->order ?: 0
        ]);

        return redirect()->route('panel.slides.index')->with('success','اسلاید جدید با موفقیت اضافه شد');
    }
    public function edit(Slide $slide)
    {
        $this->authorize('edit slide');
        return view('panel.slides.edit')->with('slide' ,$slide);
    }
    public function update(Request $request, Slide $slide)
    {
        $this->authorize('edit slide');
        $request->validate([
            'image' => 'nullable|file|image|max:2000',
            'link' => 'nullable|string|max:255',
            'position' => ['required', 'in:website,application'],
            'order' => 'nullable|numeric'
        ],[],[
            'image' => 'تصویر',
            'link' => 'لینک',
            'position' => 'موقعیت نمایش',
            'order' => 'ترتیب نمایش',
        ]);

        $image = $slide->image;
        if($request->image) {
            File::delete($image);
            $image = $request->file('image')->store('images/slides/', 'local');
        }

        $slide->update([
            'image' => $image,
            'link' => $request->link,
            'position' => $request->position,
            'order' => $request->order ?: 0
        ]);

        return redirect()->route('panel.slides.index')->with('success','تغییرات با موفقیت ذخیره شد');
    }
    public function destroy(Slide $slide)
    {
        $this->authorize('delete slide');
        File::delete($slide->image);
        $slide->delete();
        return redirect()->route('panel.slides.index')->with('success','اسلاید مورد نظر با موفقیت حذف شد');
    }
}
