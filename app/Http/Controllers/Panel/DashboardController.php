<?php

namespace App\Http\Controllers\Panel;

use App\Contact;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $user_count = null;
        $orders_count = null;
        $latest_orders = null;
        $contacts_count = null;
        $latest_contacts = null;
        $views_count = null;
        $latest_products = null;

        if ($user->can('view users')) {
            $user_count = User::whereBetween('created_at', [Carbon::today()->addDays(-30), Carbon::today()->addDays(30)])->count();
        }
        if ($user->can('view orders')) {
            $orders_count = Order::whereBetween('created_at', [Carbon::today()->addDays(-30), Carbon::today()->addDays(30)])->count();
            $latest_orders = Order::orderBy('created_at', 'desc')->take(10)->get();
        }
        if ($user->can('view contacts')) {
            $contacts_count = Contact::whereBetween('created_at', [Carbon::today()->addDays(-30), Carbon::today()->addDays(30)])->count();
            $latest_contacts = Contact::orderBy('created_at')->take(10)->get();
        }
        if ($user->can('view products')) {
            $views_count = Product::whereBetween('updated_at', [Carbon::today()->addDays(-30), Carbon::today()->addDays(30)])->sum('views');
        }
         if ($user->can('view products')) {
            $latest_products = Product::orderBy('created_at','desc')->take(10)->get();
         }



        return view('panel.dashboard')->with([
            'user_count' => $user_count,
            'orders_count' => $orders_count,
            'contacts_count' => $contacts_count,
            'views_count' => $views_count,
            'latest_orders' => $latest_orders,
            'latest_contacts' => $latest_contacts,
            'latest_products' => $latest_products,
        ]);
    }
}
