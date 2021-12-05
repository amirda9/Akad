<?php

namespace App\Http\Controllers\Panel\Product;

use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function index(Request $request, Product $product)
    {
        $this->authorize('view products');
        $logs = $product->logs()->orderBy('created_at','desc');
        if ($request->start_date) {
            $start_date = Carbon::createFromFormat('Y-m-d', Date('Y-m-d', str_limit(request('start_date'), 10, '')));
            $start_date->startOfDay();
            $logs = $logs->where('created_at', '>=', $start_date);
        }
        if ($request->end_date) {
            $end_date = Carbon::createFromFormat('Y-m-d', Date('Y-m-d', str_limit(request('end_date'), 10, '')));
            $end_date->endOfDay();
            $logs = $logs->where('created_at', '<=', $end_date);
        }
        $logs = $logs->paginate();
        $logs->appends($request->query());

        return view('panel.products.logs.index')->with([
            'logs' => $logs,
            'product' => $product
        ]);
    }
}
