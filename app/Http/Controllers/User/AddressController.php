<?php

namespace App\Http\Controllers\User;

use App\Address;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{


    public function index(Request $request)
    {
        return view('user.addresses.index')->with([
            'user' => auth()->user(),
            'addresses' => auth()->user()->addresses
        ]);
    }

    public function create(Request $request)
    {
        return view('user.addresses.create')->with([
            'user' => auth()->user(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'string|required|max:2000',
        ],[],[
            'title' => 'عنوان',
            'address' => 'آدرس',
        ]);
        $user = auth()->user();
        $is_default = false;
        if($user->addresses->where('is_default',true)->count() == 0) {
            $is_default = true;
        }
        if($request->filled('is_default')) {
            $is_default = true;
        }
        if($is_default) {
            $user->addresses()->update([
                'is_default' => false
            ]);
        }
        $user->addresses()->create([
            'title' => $request->title,
            'address' => $request->address,
            'is_default' => $is_default,
        ]);

        return redirect()->route('user.addresses.index')->with([
            'success' => 'آدرس مورد نظر شما با موفقیت اضافه شد',
        ]);
    }

    public function edit(Request $request, Address $address)
    {
        $user = auth()->user();
        if ($address->user_id != $user->id) {
            return abort(403);
        }
        return view('user.addresses.edit')->with([
            'user' => $user,
            'address' => $address,
        ]);
    }

    public function update(Request $request, Address $address)
    {
        $user = auth()->user();
        if ($address->user_id != $user->id) {
            return abort(403);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'string|required|max:2000',
        ],[],[
            'title' => 'عنوان',
            'address' => 'آدرس',
        ]);
        $is_default = false;
        if($user->addresses->where('is_default',true)->count() == 0) {
            $is_default = true;
        }
        if($request->filled('is_default')) {
            $is_default = true;
        }
        if($is_default) {
            $user->addresses()->update([
                'is_default' => false
            ]);
        }
        $address->update([
            'title' => $request->title,
            'address' => $request->address,
            'is_default' => $is_default,
        ]);

        return redirect()->route('user.addresses.index')->with([
            'success' => 'آدرس مورد نظر شما با موفقیت ویرایش شد',
        ]);
    }

    public function destroy(Address $address)
    {
        $user = auth()->user();
        if ($address->user_id != $user->id) {
            return abort(403);
        }
        $address->delete();
        $latest_address = $user->addresses()->orderBy('created_at','desc')->first();
        if ($latest_address) {
            $latest_address->update([
                'is_default' => true
            ]);
        }
        return redirect()->route('user.addresses.index')->with([
            'success' => 'آدرس مورد نظر شما با موفقیت حذف شد',
        ]);
    }

    public function setAsDefault(Address $address)
    {
        $user = auth()->user();
        if ($address->user_id != $user->id) {
            return abort(403);
        }
        $user->addresses()->update([
            'is_default' => false
        ]);
        $address->update([
            'is_default' => true
        ]);
        return redirect()->route('user.addresses.index')->with([
            'success' => 'آدرس مورد نظر شما با موفقیت ویرایش شد',
        ]);
    }

}
