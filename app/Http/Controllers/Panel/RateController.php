<?php

namespace App\Http\Controllers\Panel;

use App\Article;
use App\Http\Controllers\Controller;
use App\Rate;
use App\Product;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function index(Request $request)
    {
        $rates = Rate::orderBy('created_at', 'desc');
        if ($request->search) {
            $rates = Rate::whereHasMorph('rateable', [Product::class], function ($query) use ($request) {
                $query->where('title', 'like', "%$request->search%")->orWhere('sku', $request->search);
            });
        }

        switch ($request->orderBy) {
            case 'max_rate': {
                    $rates = Rate::orderBy('rate', 'desc');
                    break;
                }
            case 'min_rate': {
                    $rates = Rate::orderBy('rate', 'asc');
                    break;
                }
        }


        $rates = $rates->paginate();
        $rates->appends($request->query());


        return view('panel.rates.index')->with([
            'rates' => $rates
        ]);
    }


    public function destroy(Rate $rate)
    {
        $this->authorize('delete rate');
        $rate->delete();
        return redirect()->route('panel.rates.index')->with([
            'success' => 'امتیاز مورد نظر با موفقیت حذف شد'
        ]);
    }
}
