<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function dashboard()
    {
        $user = auth()->user();
        $unread_notifications = $user->unreadNotifications()->paginate(5);

        return view('user.dashboard')
            ->with([
                'user' => $user,
                'unread_notifications' => $unread_notifications,
            ]);
    }
}
