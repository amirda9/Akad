<?php

namespace App\Http\Controllers\Panel;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request) {
        $this->authorize('view users');

        $users = User::orderBy('created_at','desc');

        if(request('search')) {
            $users = $users->where(function($query) use($request) {
                $query->where('name','LIKE',"%$request->search%")
                    ->orWhere('email','LIKE',"%$request->search%")
                    ->orWhere('mobile','LIKE',"%$request->search%");
            });
        }

        if ($request->role){
            $users = $users->whereHas('roles',function($query) use ($request){
                $query->where('id',$request->role);
            });
        }
        if (!($request->active === null)){
            $users = $users->where('is_active',$request->active == 1);
        }

        $users = $users->paginate();
        $users->appends(request()->query());

        return view('panel.users.index')
            ->with('roles',Role::all())
            ->with('users',$users);
    }

    public function create()
    {
        $this->authorize('create user');
        return view('panel.users.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create user');
        $request->merge([
            'mobile' => convertNumbers($request->mobile, false)
        ]);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [config('settings.username') == 'email' ? 'required' : 'nullable','email','max:255','unique:users'],
            'mobile' => [config('settings.username') == 'mobile' ? 'required' : 'nullable','regex:/^09\d{9}$/','unique:users'],
            'image' => 'nullable|file|image|max:300'
        ],[],[
            'name' => 'نام کاربر',
            'email' => 'آدرس ایمیل',
            'mobile' => 'شماره موبایل',
            'image' => 'تصویر',
        ]);

        $image = null;
        if($request->image){
            $image = $request->file('image')->store('images/users/', 'local');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'image' => $image,
            'is_active' => $request->is_active == 'on',
        ]);

        return redirect()->route('panel.users.index')->with([
            'success' => 'کاربر جدید با موفقیت اضافه شد'
        ]);

    }

    public function show(User $user)
    {
        $this->authorize('view users');
        return view('panel.users.show')->with([
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            'user' => $user,
        ]);
    }

    public function edit(User $user)
    {
        $this->authorize('edit user');
        return view('panel.users.edit')->with([
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('edit user');
        $request->merge([
            'mobile' => convertNumbers($request->mobile, false)
        ]);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                config('settings.username') == 'email' ? 'required' : 'nullable',
                'email',
                'max:255',
                Rule::unique('users','email')->ignore($user->id)
            ],
            'mobile' => [
                config('settings.username') == 'mobile' ? 'required' : 'nullable',
                'regex:/^09\d{9}$/',
                Rule::unique('users','mobile')->ignore($user->id)
            ],
            'image' => 'nullable|file|image|max:100',
        ],[],[
            'name' => 'نام کاربر',
            'email' => 'آدرس ایمیل',
            'mobile' => 'شماره موبایل',
            'image' => 'تصویر',
        ]);

        $image = $user->image;
        if ($request->image) {
            File::delete($image);
            $image = $request->file('image')->store('images/users', 'local');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'image' => $image,
            'is_active' => $request->is_active == 'on',
        ]);

        return redirect()->route('panel.users.index')->with([
            'success' => 'اطلاعات حساب کاربری با موفقیت ویرایش شد'
        ]);
    }

    public function changeActive(Request $request, User $user)
    {
        $this->authorize('edit user');
        if ($user->id == Auth::id()) {
            return redirect()->route('panel.users.index')
                ->withErrors('وضعیت حساب کاربری خود را نمی توانید تغییر دهید');
        } else {
            $user->update([
                'is_active' => !$user->is_active
            ]);
            return redirect()->route('panel.users.index')->with([
                'success' => 'وضعیت حساب کاربری مورد نظر با موفقیت تغییر کرد'
            ]);
        }
    }

    public function destroy(User $user)
    {
        $this->authorize('delete user');
        // todo: check for relations
        $user->delete();
        return redirect()->route('panel.users.index')->with([
            'success' => 'کاربر مورد نظر با موفقیت حذف شد'
        ]);
    }

    public function deleteImage(User $user)
    {
        $this->authorize('edit user');
        File::delete($user->image);
        $user->update([
            'image' => null
        ]);
        return redirect()->route('panel.users.show',$user)->with([
            'success' => 'تصویر کاربر مورد نظر با موفقیت حذف شد'
        ]);
    }

    public function addRole(Request $request, User $user)
    {
        $this->authorize('edit user permissions');
        $request->validate([
            'role' => 'required|exists:roles,name'
        ],[],[
            'role' => 'نقش'
        ]);

        $user->assignRole($request->role);
        return redirect()->route('panel.users.show',$user)->with([
            'success' => 'نقش مورد نظر به کاربر داده شد'
        ]);
    }

    public function removeRole(User $user, Role $role)
    {
        $this->authorize('edit user permissions');
        $user->removeRole($role->name);
        return redirect()->route('panel.users.show',$user)->with([
            'success' => 'نقش مورد نظر از کاربر گرفته شد'
        ]);
    }

    public function addPermission(Request $request, User $user)
    {
        $this->authorize('edit user permissions');
        $request->validate([
            'permission' => 'required|exists:permissions,name'
        ],[],[
            'permission' => 'دسترسی'
        ]);

        $user->givePermissionTo($request->permission);
        return redirect()->route('panel.users.show',$user)->with([
            'success' => 'دسترسی مورد نظر به کاربر داده شد'
        ]);
    }

    public function revokePermission(User $user, Permission $permission)
    {
        $this->authorize('edit user permissions');
        $user->revokePermissionTo($permission->name);
        return redirect()->route('panel.users.show',$user)->with([
            'success' => 'دسترسی مورد نظر از کاربر گرفته شد'
        ]);
    }

}
