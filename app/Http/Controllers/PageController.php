<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Page;
use App\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PageController extends Controller
{
    public function __construct()
    {
    }


    public function index()
    {
        $slides = Slide::orderBy('order','asc')->get();
        return view('index')->with([
            'slides' => $slides
        ]);
    }

    public function show(Request $request, $slug)
    {
        $page = Page::published()->slug($slug)->firstOrFail();
        return view('pages.show')->with([
            'page' => $page
        ]);
    }
}
