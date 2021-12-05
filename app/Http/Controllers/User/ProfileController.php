<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{


    public function index(Request $request)
    {
        return view('user.profile.index')->with([
            'user' => auth()->user(),
        ]);
    }

    public function edit(Request $request)
    {
        $user = auth()->user();
        return view('user.profile.edit')->with([
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable','max:190','string','email',
                Rule::unique('users')->ignore($user->id)
            ],
            'image' => 'nullable|file|image|max:500',
        ],[],[
            'name' => 'نام',
            'email' => 'آدرس ایمیل',
            'image' => 'تصویر',
        ]);

        $image = $user->image;
        if($request->image) {
            File::delete($image);
            $image = $request->file('image')->store('images/users','local');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'image' => $image,
        ]);

        return redirect()->route('user.profile.index')->with([
            'success' => 'حساب کاربری شما با موفقیت ویرایش شد',
        ]);

    }

}
