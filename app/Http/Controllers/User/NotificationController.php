<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function all()
    {
        $notifications = Auth::user()->notifications()->paginate();

        return view('user.notifications.index')
            ->with([
                'notifications' => $notifications,
                'user' => Auth::user()
            ]);
    }

    public function deleteRead()
    {
        Auth::user()->notifications()->whereNotNull('read_at')->delete();
        return redirect()->route('user.notifications')->with([
            'success' => 'اعلان های خوانده شده با موفقیت حذف شدند'
        ]);
    }

    public function readAll()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with([
            'success' => 'همه اعلان ها خوانده شدند'
        ]);
    }


    public function delete($id)
    {
        Auth::user()->notifications()->where('id',$id)->delete();
        return back();
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->where('id',$id)->get();
        if ($notification){
            $notification->markAsRead();
        }
        return back();
    }

    public function show($id)
    {
        $notification = Auth::user()->notifications()->where('id',$id)->firstOrFail();
        $notification->markAsRead();
        if($notification->data['link']) {
            return redirect($notification->data['link']);
        }
        return back();
    }
}
