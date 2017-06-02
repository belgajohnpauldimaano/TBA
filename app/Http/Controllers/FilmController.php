<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Film;
use App\Genre;
class FilmController extends Controller
{
    public function index () 
    {
        $Film = Film::with(['genre'])->where(function ($query) {
            $query->where('release_status', '!=', 0);
        })->get();
        return view('cms.film.index', ['Film' => $Film]);
    }

    public function fetch_record (Request $request)
    {
        $Film = Film::with(['genre'])->where(function ($query) use($request) {
            $query->where('release_status', '!=', 0);
        })->get();
        return view('cms.film.partials.film_records', ['Film' => $Film]);
    }

    public function show_film_form (Request $request)
    {
        $Film = '';
        if ($request->id)
        {
            $Film = Film::where('id', $request->id)->first();

            if (!$Film)
            {
                return response()->json(['errCode' => 1, 'messages' => 'Invalid section']);
            }
        }
        $Genre = Genre::all();
        $film_status = Film::RELEASE_STATUS;
        return view('cms.film.partials.film_form', ['film_status' => $film_status, 'Film' => $Film, 'Genre' => $Genre])->render();
    }


    public function save_film (Request $request)
    {
        $rules = [
            'title'     => 'required',
            'genre'     => 'required',
            'sellsheet' => 'mimes:pdf',
            'release_status' => 'required'
        ];
        $messages = [
            'title.required' => 'Film title is required field.',
            'genre.required' => 'Film genre is required field.',
            'sellsheet.mimes' => 'Sell sheet should be in pdf file format.',
            'release_status.required' => 'Releas status is required field.'
        ];;

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
        {
            return response()->json(['errCode' => 1, 'messages' => $validator->getMessageBag()]);
        }

        $genre_id = '';

        $Genre = Genre::where('genre', $request->genre)->first();

        if($Genre) // has a genre in genres table
        {
            $genre_id = $Genre->id;
        }   
        else // no genre in genres table so we need to add new genre base on use input
        {
            $Genre = new Genre();
            $Genre->genre = $request->genre;
            $Genre->save();
            $genre_id = $Genre->id;
        }

        if($request->has('id')) // has id then it is updating of record
        {

            $Film                   = Film::where('id', $request->id)->first();
            $Film->title            = $request->title;
            $Film->synopsis         = $request->synopsis;
            $Film->release_status   = $request->release_status;
            $Film->release_date     = ($request->has('release_date') ? Date('Y-m-d', strtotime($request->release_date)) : NULL);
            $Film->rating           = $request->rating;
            $Film->running_time     = $request->running_time;
            $Film->sell_sheet       = $request->sellsheet;
            $Film->hash_tags        = $request->hashtags;
            $Film->genre_id         = $genre_id;
            $Film->save();

            return response()->json(['errCode' => 0, 'messages' => 'Film successfully updated.']);
        }

        // adding of record
        $Film                   = new Film();
        $Film->title            = $request->title;
        $Film->synopsis         = $request->synopsis;
        $Film->release_status   = $request->release_status;
        $Film->release_date     = ($request->has('release_date') ? Date('Y-m-d', strtotime($request->release_date)) : NULL);
        $Film->rating           = $request->rating;
        $Film->running_time     = $request->running_time;
        $Film->sell_sheet       = $request->sellsheet;
        $Film->hash_tags        = $request->hashtags;
        $Film->genre_id         = $genre_id;
        $Film->save();
        return response()->json(['errCode' => 0, 'messages' => 'Film successfully updated.']);
    }

    public function delete_film (Request $request)
    {
        if (!$request->has('id'))
        {
            return response()->json(['errCode' => 1, 'messages' => 'Invalid selection of entry.']);
        }

        $Film = Film::where('id', $request->id)->first();
        $Film->release_status = 0;
        $Film->save();
        return response()->json(['errCode' => 0, 'messages' => 'Film successfully deleted.']);
    }
}
