<?php

namespace App\Http\Controllers\Panel\Product;

use App\Attribute;
use App\Events\Variation\VariationCreated;
use App\Events\Variation\VariationDeleted;
use App\Product;
use App\Variation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VariationController extends Controller
{
    public function index(Product $product)
    {
        $this->authorize('edit product');
        $attributes = $product->attributes()->wherePivot('variation',true)->get();
        $variations = $product->variations()->with(['attributes' => function($q) use($product){
            $q->with(['items' => function($q) use($product){
                $q->whereHas('products',function($q) use($product) {
                    $q->where('id',$product->id);
                });
            }]);
        }])->get();
        $variation_attribute_items = $product->attribute_items()
            ->whereIn('attribute_id',$attributes->pluck('id'))->get();
        $invalid_variations = Variation::where('product_id',$product->id)
            ->where(function($q) use($attributes, $variation_attribute_items){
                $q->whereHas('attribute_items', function($q) use($variation_attribute_items){
                    $q->whereNotIn('id',$variation_attribute_items->pluck('id'));
                })->orWhere(function ($q) use($attributes){
                    $q->has('attribute_items','<>',$attributes->count());
                });
            })
            ->with('attribute_items')
            ->get();
        return view('panel.products.edit.variations')->with([
            'product' => $product,
            'attributes' => $attributes,
            'variations' => $variations,
            'invalid_variations' => $invalid_variations,
        ]);
    }

    public function deleteInvalids(Product $product)
    {
        $this->authorize('edit product');
        $attributes = $product->attributes()->wherePivot('variation',true)->get();
        $variation_attribute_items = $product->attribute_items()
            ->whereIn('attribute_id',$attributes->pluck('id'))->get();
        $product->variations()->whereHas('attribute_items', function($q) use($variation_attribute_items){
            $q->whereNotIn('id',$variation_attribute_items->pluck('id'));
        })->delete();
        return back()->with([
            'success' => 'متغیرهای نامعتبر با موفقیت حذف شدند'
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $this->authorize('edit product');
        $request->validate([
            'attributes.*' => 'required|exists:attribute_items,id',
            'regular_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'sku' => 'nullable|string|max:100',
            'weight' => 'nullable|numeric',
            'stock' => 'required|numeric',
            'stock_status' => 'required|string'
        ],[],[
            'attributes.*' => 'ویژگی',
            'regular_price' => 'قیمت اصلی',
            'sale_price' => 'قیمت فروش فوق العاده',
            'sku' => 'کد محصول',
            'weight' => 'وزن',
            'stock' => 'موجودی',
            'stock_status' => 'وضعیت موجودی'
        ]);

        $has_variation = false;

        foreach($product->variations as $v) {
            if(array_equal(array_values($request->get('attributes')),$v->conditions)) {
                $has_variation = true;
                break;
            }
        }
        if($has_variation) {
            return back()->withErrors('این متغیر قبلا تعریف شده است');
        }

        $variation = $product->variations()->create([
            'conditions' => array_values($request->get('attributes')),
            'regular_price' => $request->get('regular_price'),
            'sale_price' => $request->get('sale_price'),
            'sku' => $request->get('sku'),
            'weight' => $request->get('weight'),
            'manage_stock' => $request->filled('manage_stock'),
            'stock' => $request->get('stock'),
            'stock_status' => $request->get('stock_status'),
        ]);

        foreach ($request->get('attributes') as $attribute_id => $item_id) {
            $variation->attributes()->attach($attribute_id,[
                'attribute_item_id' => $item_id
            ]);
        }
        event(new VariationCreated($variation, Auth::id()));
        return redirect()->route('panel.products.variations', $product)
            ->with('success', 'متغیر مورد نظر با موفقیت اضافه شد');
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('edit product');
        $variation = $product->variations()->findOrFail($request->get('variation_id'));
        $has_variation = false;
        foreach($product->variations()->where('id','<>',$variation->id)->get() as $v) {
            if(array_equal(array_values($request->get('attributes')),$v->conditions)) {
                $has_variation = true;
                break;
            }
        }
        if($has_variation) {
            return back()->withErrors('این متغیر قبلا تعریف شده است');
        }
        $old_variation = clone $variation;
        $old_variation->load('attribute_items');
        $variation->update([
            'conditions' => array_values($request->get('attributes')),
            'regular_price' => $request->get('regular_price'),
            'sale_price' => $request->get('sale_price'),
            'sku' => $request->get('sku'),
            'weight' => $request->get('weight'),
            'manage_stock' => $request->filled('manage_stock'),
            'stock' => $request->get('stock'),
            'stock_status' => $request->get('stock_status'),
        ]);

        $variation->attributes()->detach();
        foreach ($request->get('attributes') as $attribute_id => $item_id) {
            $variation->attributes()->attach($attribute_id,[
                'attribute_item_id' => $item_id
            ]);
        }
        $variation->submitLog($old_variation);
        return redirect()->route('panel.products.variations', $product)
            ->with('success', 'متغیر مورد نظر با موفقیت ویرایش شد');
    }

    public function destroy(Request $request,Product $product)
    {
        $this->authorize('edit product');
        $variation = Variation::findOrfail($request->get('variation_id'));
        $variation->attributes()->detach();
        $old_variation = clone $variation;
        $variation->delete();
        event(new VariationDeleted($old_variation,Auth::id()));
        return redirect()->route('panel.products.variations', $product)
            ->with('success', 'متغیر مورد نظر شما با موفقیت حذف شد');
    }

    public function createAll(Product $product)
    {
        $this->authorize('edit product');
        $attributes = $product->attributes()->wherePivot('variation',true)->get();

        $selected_attributes = [];
        $total_forms = 0;
        if($attributes->count() > 0) {
            $total_forms = 1;
            foreach ($attributes as $attribute) {
                $total_forms *= $attribute->pivot->items->count();
            }
        }
        $data = [];
        for ($i=0; $i < $total_forms; $i++) {
            $d = $total_forms;
            $row = [];
            foreach($attributes as $j => $attribute) {
                $items = $attribute->pivot->items;
                $d = $d/$items->count();
                foreach($items as $k => $item) {
                    if($k == floor(($i)/$d)%$items->count()){
                        $row[$attribute->id] = $item->id;
                    }
                }
            }
            $data[] = $row;
        }

        foreach ($data as $row) {
            $has_variation = false;
            foreach($product->variations as $v) {
                if(array_equal(array_values($row),$v->conditions)) {
                    $has_variation = true;
                    break;
                }
            }
            if (!$has_variation) {
                $variation = $product->variations()->create([
                    'conditions' => array_values($row),
                    'regular_price' => $product->regular_price,
                    'sale_price' => $product->sale_price,
                    'sku' => null,
                    'weight' => null,
                    'manage_stock' => true,
                    'stock' => null,
                    'stock_status' => 'instock',
                ]);
                foreach ($row as $attribute_id => $item_id) {
                    $variation->attributes()->attach($attribute_id,[
                        'attribute_item_id' => $item_id
                    ]);
                }
            }
        }
        return redirect()->route('panel.products.variations', $product)
            ->with('success', 'متغیرها با موفقیت اضافه شد');
    }



}
