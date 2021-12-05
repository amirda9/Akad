<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view tags');
        $tags = Tag::orderBy('created_at','desc');

        if($request->search) {
            $tags = $tags->where('title','like',"%$request->search%");
        }

        $tags = $tags->paginate();
        $tags->appends($request->query());
        return view('panel.tags.index',[
            'tags' => $tags
        ]);
    }

    public function search(Request $request)
    {
        $this->authorize('view tags');
        $tags = Tag::orderBy('created_at','desc');

        if($request->get('q')) {
            $tags = $tags->where('title','like',"%$request->q%");
        }

        $tags = $tags->get();
        return $tags;
    }

    public function store(Request $request)
    {
        $this->authorize('create tag');
        $request->validate([
            'title' => 'required|string|max:255',
        ],[],[
            'title' => 'عنوان'
        ]);

        Tag::updateOrCreate([
            'title' => $request->title
        ]);

        return redirect()->route('panel.tags.index')->with([
            'success' => 'برچسب جدید با موفقیت اضافه شد'
        ]);
    }


    public function edit(Request $request, Tag $tag)
    {
        $this->authorize('edit tag');
        return view('panel.tags.edit',[
            'tag' => $tag
        ]);
    }

    public function update(Request $request, Tag $tag)
    {
        $this->authorize('edit tag');
        $request->validate([
            'title' => ['required','string','max:255',Rule::unique('tags','title')->ignore($tag->id)],
        ],[],[
            'title' => 'عنوان'
        ]);

        $tag->update([
            'title' => $request->title
        ]);

        return redirect()->route('panel.tags.index')->with([
            'success' => 'برچسب مورد نظر با موفقیت ویرایش شد'
        ]);
    }

    public function destroy(Tag $tag)
    {
        $this->authorize('delete tag');
        $tag->products()->detach();
        $tag->delete();

        return redirect()->route('panel.tags.index')->with([
            'success' => 'برچسب مورد نظر با موفقیت حذف شد'
        ]);
    }
}
