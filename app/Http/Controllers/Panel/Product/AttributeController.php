<?php

namespace App\Http\Controllers\Panel\Product;

use App\AttributeGroup;
use App\Product;
use App\Variation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    public function index(Product $product)
    {
        $attribute_groups = AttributeGroup::orderBy('order','asc')->with(['attributes' => function($q){
            $q->orderBy('order','asc')->with(['items' => function($q) {
                $q->orderBy('order','asc');
            }]);
        }])->get();
        $this->authorize('edit product');
        return view('panel.products.edit.attributes')->with([
            'product' => $product,
            'attribute_groups' => $attribute_groups,
            'attributes' => $product->attributes,
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $this->authorize('edit product');
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'items' => 'required|array',
            'items.*' => 'numeric|exists:attribute_items,id'
        ],[],[
            'attribute_id' => 'ویژگی',
            'items' => 'مقدار ویژگی',
            'items.*' => 'مقدار ویژگی'
        ]);
        if($product->attributes()->where('id',$request->get('attribute_id'))->count()) {
            return back()->withErrors('این ویژگی قبلا تعریف شده است');
        }
        $product->attributes()->attach($request->get('attribute_id'), [
            'value' => $request->get('items'),
            'visibility' => $request->filled('visibility'),
            'variation' => $request->filled('variation')
        ]);
        $product->attribute_items()->attach($request->get('items'));
        return redirect()->route('panel.products.attributes', $product)
            ->with('success', 'ویژگی مورد نظر با موفقیت اضافه شد');
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('edit product');
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'items' => 'required|array',
            'items.*' => 'numeric|exists:attribute_items,id'
        ],[],[
            'attribute_id' => 'ویژگی',
            'items' => 'مقدار ویژگی',
            'items.*' => 'مقدار ویژگی'
        ]);
        $prev_attribute_item_ids = $product->attribute_items()->where('attribute_id',$request->get('attribute_id'))
            ->pluck('id')->toArray();
        $product->attribute_items()->detach($prev_attribute_item_ids);
        $product->attributes()->updateExistingPivot($request->get('attribute_id'),[
            'value' => $request->get('items'),
            'visibility' => $request->filled('visibility'),
            'variation' => $request->filled('variation')
        ]);
        $product->attribute_items()->attach($request->get('items'));
        return redirect()->route('panel.products.attributes', $product)
            ->with('success', 'ویژگی مورد نظر با موفقیت ویرایش شد');
    }

    public function destroy(Request $request, Product $product)
    {
        $this->authorize('edit product');
        $prev_attribute_item_ids = $product->attribute_items()->where('attribute_id',$request->get('attribute_id'))
            ->pluck('id')->toArray();
        $product->attribute_items()->detach($prev_attribute_item_ids);
        $product->attributes()->detach($request->get('attribute_id'));
        return redirect()->route('panel.products.attributes', $product)
            ->with('success', 'ویژگی مورد نظر شما با موفقیت حذف شد');
    }

}
