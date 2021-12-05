<?php

namespace App\Http\Controllers\Panel\Attribute;

use App\Attribute;
use App\AttributeGroup;
use App\AttributeItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AttributeController extends Controller
{

    public function index(AttributeGroup $group)
    {
        $this->authorize('view attributes');
        $attributes = $group->attributes()->orderBy('order','asc')->get();
        return view('panel.attributes.attributes.index')->with([
            'group' => $group,
            'attributes' => $attributes
        ]);
    }




    public function store(Request $request,AttributeGroup $group)
    {
        $this->authorize('create attribute');
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'nullable|numeric'
        ],[],[
            'title' => 'عنوان ویژگی',
            'order' => 'ترتیب نمایش'
        ]);

        Attribute::updateOrCreate([
            'group_id' => $group->id,
            'title' => $request->title,
        ],[
            'order' => $request->order ?: 0,
            'show_as_filter' => $request->filled('show_as_filter'),
        ]);
        return redirect()->route('panel.attributes.index',$group)->with([
            'success' => 'ویژگی جدید با موفقیت ذخیره شد'
        ]);
    }



    public function edit(AttributeGroup $group, Attribute $attribute)
    {
        $this->authorize('edit attribute');
        return view('panel.attributes.attributes.edit')->with([
            'group' => $group,
            'attribute' => $attribute
        ]);
    }



    public function update(Request $request,AttributeGroup $group, Attribute $attribute)
    {
        $this->authorize('create attribute');
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'nullable|numeric'
        ],[],[
            'title' => 'عنوان ویژگی',
            'order' => 'ترتیب نمایش'
        ]);

        if($group->attributes()->where('title',$request->title)
            ->where('id','<>',$attribute->id)->count()) {
            return back()->withInput()->withErrors([
                'title' => 'عنوان انتخاب شده قبلا ثبت شده است'
            ]);
        }

        $attribute->update([
            'title' => $request->title,
            'order' => $request->order ?: 0,
            'show_as_filter' => $request->filled('show_as_filter'),
        ]);
        return redirect()->route('panel.attributes.index',$group)->with([
            'success' => 'تغییرات با موفقیت ذخیره شد'
        ]);
    }


    public function destroy(AttributeGroup $group, Attribute $attribute)
    {
        $this->authorize('delete attribute');
        if($attribute->items()->count()) {
            return back()->withErrors('ابتدا آیتم های این ویژگی را حذف کنید');
        }
        $attribute->delete();
        return redirect()->route('panel.attributes.index',$group)->with([
            'success' => 'ویژگی مورد نظر با موفقیت حذف شد'
        ]);

    }

    public function getForm(Request $request)
    {
        $attribute = Attribute::findOrFail($request->attribute_id);
        return view('panel.products.attributeForm',[
            'attribute' => $attribute,
            'values' => !empty($request->values) ? $request->values : [],
            'visibility' => $request->visibility == 1,
            'variation' => $request->variation == 1,
        ])->render();
    }

    public function getVariationForm(Request $request)
    {
        $selected_attributes = [];
        $total_forms = 1;
        foreach ($request->variations ?: [] as $variation) {
            $attribute = Attribute::find($variation['attribute_id']);
            if($attribute) {
                $values = $attribute->items()->whereIn('id',$variation['selected_values'] ?? [])->get();
                $total_forms *= $values->count() > 0 ? $values->count() : 1;
                $selected_attributes[] = [
                    'attribute' => $attribute,
                    'values' => $values
                ];
            }
        }

        return view('panel.products.createVariationsForm',[
            'variations' => $selected_attributes,
            'total_forms' => $total_forms,
            'default_regular_price' => $request->get('regular_price'),
            'default_sale_price' => $request->get('sale_price'),
            'variation_data' => $request->variation_data,
        ])->render();
    }
    public function addSingleVariation(Request $request)
    {
        $selected_attributes = [];
        foreach ($request->variations ?: [] as $variation) {
            $attribute = Attribute::find($variation['attribute_id']);
            if($attribute) {
                $values = $attribute->items()->whereIn('id',$variation['selected_values'] ?? [])->get();
                $selected_attributes[] = [
                    'attribute' => $attribute,
                    'values' => $values
                ];
            }
        }
        $index = Str::random();

        return view('panel.products.singleVariationRow',[
            'variations' => $selected_attributes,
            'index' => $index,
            'variation_data' => $request->variation_data,
        ])->render();
    }

    public function addNewValue(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'new_value' => 'required|string|max:255'
        ]);
        $attribute = Attribute::findOrFail($request->attribute_id);
        $attribute->items()->updateOrCreate([
            'title' => $request->new_value
        ]);
        return view('panel.products.attributeForm',[
            'attribute' => $attribute
        ])->render();
    }
}
