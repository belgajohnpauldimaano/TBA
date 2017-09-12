<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use File;

use App\PressRelease;

class BlogController extends Controller
{
    public function blog (Request $request)
     {
        $Blog = PressRelease::orderBy('created_at', 'DESC')->paginate(10);
        return view('cms.blog.index', ['Blog' => $Blog]);
    }

    public function show_modal_form_data (Request $request)
    {

        $Blog = NULL;
        if ($request->id)
        {
            $Blog = PressRelease::where('id', $request->id)->first();

            if (!$Blog)
            {
                return response()->json(['errCode' => 1, 'messages' => 'Invalid section']);
            }
        }
        $test = PressRelease::where('film_id', '>', 0)
                ->selectRaw('title, film_id')
                ->get();
        return view('cms.blog.partials.modal_form_blog', ['Blog' => $Blog, 'test' => $test])->render();
    }

    public function fetch (Request $request)
    {

        $per_page = 10;

        if ($request->per_page)
        {
            $per_page = $request->per_page;
        }

        $Blog = PressRelease::orderBy('created_at', 'DESC')->paginate($per_page);
        return view('cms.blog.partials.table_blog_records', ['Blog' => $Blog, 'per_page' => $per_page, 'request' => $request]);
    }

    /*
     * BLOG
     */
    
    public function save_blog (Request $request)
    {
        $rules = [
            //'film_id'                       => 'required',
            'press_release_title'           => 'required',
            'press_release_article_image'   => 'required|mimes:jpeg,png',
            'press_release_blurb'           => 'required',
            'press_release_content'         => 'required',
            'press_release_film_select'     => 'required'
        ];

        $messages = [
            //'film_id.required'                          => 'Invalid film data selection.',
            'press_release_title.required'              => 'Title field is required.',
            'press_release_article_image.required'      => 'Article image field is required.',
            'press_release_article_image.mimes'         => 'Article image should be a valid format :jpeg, png',
            'press_release_blurb.required'              => 'Blurb field is required.',
            'press_release_content.required'            => 'Article content field is required.',
            'press_release_film_select.required'        => 'Film category is required.'
        ];
        
        if ($request->film_id == 0)
        {
            $rules['press_release_film_select'] = 'nullable';

        }

        if ($request->press_release_id)
        {
            $rules['press_release_article_image'] = 'mimes:jpeg,png';
            $messages['press_release_article_image.mimes'] = 'Article image should be a valid format :jpeg, png';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
        {
            return response()->json(['errCode' => 1, 'messages' => $validator->getMessageBag()]);
        }

        $PressRelease = PressRelease::where('id', $request->press_release_id)->first();

        $d = date('Y-m-d H:i:s', strtotime($request->pr_posting_date));

        if ($PressRelease != null)
        {


            if ($request->hasFile('press_release_article_image'))
            {
                File::delete(public_path('content\\film\\press_release\\' . $PressRelease->article_image));
                $ext = $request->press_release_article_image->getClientOriginalExtension(); // get the file extension name
                $filename   = str_random(100) . '.' . $ext; // generate random filename and append the extension
                $request->press_release_article_image->move(public_path('content/film/press_release'), $filename); // upload the file
                
                $PressRelease->article_image    = $filename;
            }


            $PressRelease->title            = $request->press_release_title;
            $PressRelease->blurb            = $request->press_release_blurb;
            $PressRelease->content          = $request->press_release_content;
            $PressRelease->film_id          = $request->film_id;
            $PressRelease->article_source   = $request->press_release_article_source;
            $PressRelease->created_at       = $d;

            $PressRelease->save();

            return response()->json(['errCode' => 0, 'messages' => 'Press release successfully updated.']);
        }

        $ext = $request->press_release_article_image->getClientOriginalExtension(); // get the file extension name
        $filename   = str_random(100) . '.' . $ext; // generate random filename and append the extension
        $request->press_release_article_image->move(public_path('content/film/press_release'), $filename); // upload the file

        $PressRelease = new PressRelease();
        $PressRelease->title            = $request->press_release_title;
        $PressRelease->article_image    = $filename;
        $PressRelease->blurb            = $request->press_release_blurb;
        $PressRelease->content          = $request->press_release_content;
        $PressRelease->film_id          = $request->film_id;
        $PressRelease->article_source   = $request->press_release_article_source;
        $PressRelease->created_at       = $d;
        //$PressRelease->film_id          = 0;

        $PressRelease->save();

        return response()->json(['errCode' => 0, 'messages' => 'Press release successfully added.']);

    }

    public function delete_blog (Request $request)
    {
        if(!$request->id)
        {
            return response()->json(['errCode' => 2, 'messages' => 'Invalid selection of press release.']);
        }

        $PressRelease = PressRelease::where('id', $request->id)->first();

        if(!$PressRelease)
        {
            return response()->json(['errCode' => 2, 'messages' => 'Invalid selection of press release.']);
        }

        File::delete(public_path('content\\film\\press_release\\' . $PressRelease->article_image));
        $PressRelease->delete();

        return response()->json(['errCode' => 0, 'messages' => 'Press release details successfully deleted.']);
    }


    /*
    *
    *
        Frontend function
    */

    public function blog_frontend (Request $request)
     {

        $Blog = PressRelease::orderBy('created_at', 'DESC')
        ->get();

        $latest = $Blog->slice(0, 2);

        $latest_id = [];

        foreach ($latest as $data) {
            $latest_id[] = $data->id;
        }

        return view('frontend.blog', ['Blog' => $Blog, 'latest_id' => $latest_id]);
    }

    public function blog_info_frontend (Request $request)
     {
        $Blog_info = PressRelease::where('id', '=', $request->id)->first();

        $Blog = PressRelease::where(function ($query) {
            $query->where('film_id', '=', 0);
        })
        //->orderBy('created_at', 'DESC')
        ->inRandomOrder()
        ->take(5)
        ->get();

        return view('frontend.blog_info', ['Blog_info' => $Blog_info, 'Blog' => $Blog]);
    }
}