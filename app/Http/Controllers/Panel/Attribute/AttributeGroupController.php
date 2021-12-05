<?php

namespace App\Http\Controllers\Panel\Attribute;

use App\AttributeGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttributeGroupController extends Controller
{

    public function index()
    {
        $this->authorize('view attributes');
        $groups = AttributeGroup::orderBy('created_at','asc')->get();
        return view('panel.attributes.groups.index')->with([
            'groups'=> $groups
        ]);
    }



    public function store(Request $request)
    {
        $this->authorize('create attribute');
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'nullable|numeric'
        ],[],[
            'title' => 'عنوان گروه ویژگی',
            'order' => 'ترتیب نمایش'
        ]);

        AttributeGroup::updateOrCreate([
            'title' => $request->title,
        ],[
            'order' => $request->order ?: 0
        ]);

        return redirect()->route('panel.attributeGroups.index')->with([
            'success' => 'گروه ویژگی جدید با موفقیت اضافه شد'
        ]);
    }


    public function edit(AttributeGroup $attributeGroup)
    {
        $this->authorize('edit attribute');
        return view('panel.attributes.groups.edit')->with([
            'group' => $attributeGroup
        ]);
    }



    public function update(Request $request, AttributeGroup $attributeGroup)
    {
        $this->authorize('edit attribute');
        $request->validate([
            'title' => ['required','string','max:255', Rule::unique('attribute_groups','title')->ignore($attributeGroup->id)],
            'order' => 'nullable|numeric'
        ],[],[
            'title' => 'عنوان گروه ویژگی',
            'order' => 'ترتیب نمایش'
        ]);

        $attributeGroup->update([
            'title' => $request->title,
            'order' => $request->order ?: 0
        ]);

        return redirect()->route('panel.attributeGroups.index')->with([
            'success' => 'تغییرات با موفقیت ذخیره شد'
        ]);
    }



    public function destroy(AttributeGroup $attributeGroup)
    {
        $this->authorize('delete attribute');
        if($attributeGroup->attributes()->count()){
            return back()->withErrors('ابتدا ویژگی های این گروه را حذف کنید');
        }
        $attributeGroup->delete();
        return redirect()->route('panel.attributeGroups.index')->with([
            'success' => 'گروه ویژگی مورد نظر با موفقیت حذف شد'
        ]);
    }
}
