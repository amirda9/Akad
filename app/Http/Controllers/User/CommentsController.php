<?php

namespace App\Http\Controllers\user;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function index()
    {
        $comments=Auth::user()->Comments()->paginate();
        return view('user.comments.index')->with([
            'comments' => $comments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show(Comment $comment)
    {
        return view('user.comments.show')->with([
            'comment'=> $comment
        ]);
    }

    public function edit(Comment $comment)
    {
        return view('user.comments.edit')->with([
            'comment'=> $comment
        ]);
    }

    public function update(Request $request,Comment $comment)
    {
        $request->merge([
            'mobile' => convertNumbers($request->mobile, false)
        ]);
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|regex:/^09\d{9}$/',
            'email' => 'nullable|email',
            'content' => 'required|max:2000',
        ],[],[
            'name' => 'نام',
            'mobile' => 'شماره تماس',
            'email' => 'ایمیل',
            'content' => 'متن نظر',
        ]);
        $user = Auth::user();
        $comment->update([
            'user_id' => $user->id,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'content' => $request->get('content')
        ]);
        return redirect()->route('user.comments.index')->with([
            'success' => 'تغییرات با موفقیت ثبت شد'
        ]);
    }


    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect('user.comments.index')->with([
            'success' => 'تغییرات با موفقیت ثبت شد'
        ]);
    }
}
