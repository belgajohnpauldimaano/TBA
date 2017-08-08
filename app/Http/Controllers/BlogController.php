<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blog ()
    {
        return view('cms.blog.index');
    }

    public function show_modal_form_data (Request $request)
    {
        return view('cms.blog.partials.modal_form_blog')->render();
    }
}