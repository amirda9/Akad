<?php

namespace App\Http\Controllers\Panel\Attribute;

use App\Attribute;
use App\AttributeGroup;
use App\AttributeItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttributeItemController extends Controller
{
    public function index(AttributeGroup $group, Attribute $attribute)
    {
        $this->authorize('view attributes');
        $items = $attribute->items()->orderBy('order','asc')->get();
        return view('panel.attributes.items.index')->with([
            'group' => $group,
            'attribute' => $attribute,
            'items' => $items
        ]);
    }


    public function store(Request $request,AttributeGroup $group, Attribute $attribute)
    {
        $this->authorize('create attribute');
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'nullable|numeric'
        ],[],[
            'title' => 'عنوان آیتم',
            'order' => 'ترتیب نمایش'
        ]);
        AttributeItem::updateOrCreate([
            'attribute_id' => $attribute->id,
            'title' => $request->title,
        ],[
            'order' => $request->order ?: 0
        ]);
        return redirect()->route('panel.attributeItems.index',[$group,$attribute])->with([
            'success' => 'آیتم جدید با موفقیت ذخیره شد'
        ]);
    }

    public function edit(AttributeGroup $group, Attribute $attribute, AttributeItem $attributeItem)
    {
        $this->authorize('edit attribute');
        return view('panel.attributes.items.edit')->with([
            'group' => $group,
            'attribute' => $attribute,
            'item' => $attributeItem,
        ]);
    }

    public function update(Request $request, AttributeGroup $group, Attribute $attribute, AttributeItem $attributeItem)
    {
        $this->authorize('edit attribute');
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'nullable|numeric'
        ],[],[
            'title' => 'عنوان آیتم',
            'order' => 'ترتیب نمایش'
        ]);
        if($attribute->items()->where('title',$request->title)->where('id','<>',$attributeItem->id)->count()) {
            return back()->withInput()->withErrors([
                'title' => 'عنوان انتخاب شده قبلا ثبت شده است'
            ]);
        }
        $attributeItem->update([
            'title' => $request->title,
            'order' => $request->order ?: 0
        ]);
        return redirect()->route('panel.attributeItems.index',[$group,$attribute])->with([
            'success' => 'تغییرات با موفقیت ذخیره شد'
        ]);
    }

    public function destroy(AttributeGroup $group, Attribute $attribute, AttributeItem $attributeItem)
    {
        $this->authorize('delete attribute');
        // TODO:: check for product relation
        $attributeItem->delete();
        return redirect()->route('panel.attributeItems.index',[$group,$attribute])->with([
            'success' => 'آیتم مورد نظر با موفقیت حذ شد'
        ]);
    }
}
