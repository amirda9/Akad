<?php

namespace App\Http\Controllers\Panel;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('view comments');
        $comments = Comment::orderBy('created_at','desc');
        if($request->search) {
            $comments = $comments->where(function($q) use($request){
                $q->where('mobile','like',"%$request->search%")
                    ->orWhere('name','like',"%$request->search%")
                    ->orWhere('email','like',"%$request->search%");
            });
        }
        if($request->type == 'published') {
            $comments = $comments->where('published',true);
        }
        if($request->type == 'not_published') {
            $comments = $comments->where('published',false);
        }
        $comments = $comments->paginate();
        return view('panel.comments.index')->with([
            'comments' => $comments,
        ]);
    }

    public function reply(Request $request, Comment $comment)
    {
        $this->authorize('edit comment');
        $request->validate([
            'reply' => 'nullable|string|max:5000',
        ],[],[
            'reply' => 'پاسخ'
        ]);
        $comment->update([
            'reply' => $request->reply
        ]);
        return back()->with([
            'success' => 'پاسخ شما با موفقیت ثبت شد'
        ]);
    }

    public function toggleApprove( Comment $comment)
    {
        $this->authorize('edit comment');
        $comment->update([
            'published' => !$comment->published
        ]);
        return back()->with([
            'success' => 'وضعیت انتشار نظر تغییر یافت'
        ]);
    }


    public function destroy(Comment $comment)
    {
        $this->authorize('delete comment');
        $comment->delete();
        return back()->with([
            'success' => 'نظر مورد نظر شما با موفقیت حذف شد'
        ]);
    }
}
