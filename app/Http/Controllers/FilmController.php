<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Film;
use App\Genre;
use App\Trailer;
class FilmController extends Controller
{
    public function index () 
    {
        $Film = Film::with(['genre'])->where(function ($query) {
            $query->where('release_status', '!=', 0);
        })->paginate(2);
        return view('cms.film.index', ['Film' => $Film]);
    }

    public function fetch_record (Request $request)
    {
        $Film = Film::with(['genre'])->where(function ($query) use($request) {
            $query->where('title', 'LIKE', '%'. $request->search .'%');
            $query->where('release_status', '!=', 0);
        })
        ->orWhereHas('genre', function ($query) use($request) {
            $query->where('genre', 'LIKE', '%'. $request->search .'%');
        })
        ->paginate(2);
        return view('cms.film.partials.film_records', ['Film' => $Film, 'request_data' => $request]);
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
            
            if ($request->has('sellsheet'))
            {
                $ext        = $request->sellsheet->getClientOriginalExtension();
                $filename   = str_random(40) . '.' . $ext;
                $request->sellsheet->move(public_path('content/sell_sheets'),$filename);
            }

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

        if ($request->has('sellsheet'))
        {
            $ext        = $request->sellsheet->getClientOriginalExtension();
            $filename   = str_random(40) . '.' . $ext;
            $request->sellsheet->move(public_path('content/sell_sheets'),$filename);
        }
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

    /* SPECIFIC FILM
     *
     *
     *
     */

     public function specific_film_index ($id) 
     {
        if (!$id)
        {
            return redirect(route('film'));
        }

        $Film = Film::with([
            'trailers' => function ($q) {
                $q->orderBy('trailer_image_sorter', 'ASC');
                $q->where('trailer_show', '!=', 0);
            }, 
            'genre'])->where('id', $id)->first();
        
        if(!$Film)
        {
            return redirect(route('film'));
        }
        
        return view('cms.film.specific_film.film', ['Film' => $Film]);
     }

     public function trailer_order_save (Request $request) 
     {
        foreach($request->order as $key => $val)
        {
            $Trailer = Trailer::where('id', $val)->first();
            $Trailer->trailer_image_sorter = $key + 1;
            $Trailer->save();
            //echo json_encode($Trailer);
            //echo $Trailer->trailer_image_sorter . ' ' . $key . ' ' . $val . '<br >' ;
        }

        return response()->json(['errCode' => 0, 'message' => 'Trailers successfully ordered.']);
     }
     
     public function show_hide_toggle (Request $request)
     {
        $validator = Validator::make($request->all(), 
                [
                    'id' => 'required',
                    'is_show' => 'required'
                ], 
                [
                    'id.required' => 'Invalid data.',
                    'is_show.required' => 'Invalid data.'
                ]
            );

        if ($validator->fails())
        {
            return response()->json(['errCode' => 1, 'message' => 'Invalid Input.']);
        }
        
        $Trailer = Trailer::where('id', $request->id)->first();
        $Trailer->trailer_show = $request->is_show;
        $Trailer->save();
        return response()->json(['errCode' => 0, 'message' => 'Trailers successfully changed show status.']);
     }

     public function delete_trailer (Request $request)
     {
        if(!$request->has('id'))
        {
            return response()->json(['errCode' => 1, 'message' => 'Invalid selection of trailer.']);
        }
         
        $Trailer = Trailer::where('id', $request->id)->first();
        $Trailer->trailer_show = 0;
        $Trailer->save();

        return response()->json(['errCode' => 0, 'message' => 'Trailers successfully deleted.']);

     }

     public function film_trailer_fetch_record ($id, Request $request)
     {
        $Trailer = Trailer::where('film_id', $id)->where('trailer_show', '!=', 0)->orderBy('trailer_image_sorter', 'ASC')->get();

        return view('cms.film.specific_film.partials.film_trailer_data', ['Trailer' => $Trailer])->render();
     }

     public function film_trailer_form_modal (Request $request)
     {
         $Trailer = '';
         if ($request->trailer_id)
         {
            $Trailer = Trailer::where('id', $request->trailer_id)->first();
         }
         return view('cms.film.specific_film.partials.film_trailer_form_modal', ['Trailer' => $Trailer])->render();
     }

     public function save_trailer ($id, Request $request)
     {
         
         $rules = [
                'url'           => 'required|url',
                ];
        $messages = [
                'url.required'           => 'Url is a required field.',
                'url.url'           => 'Url is invalid format.',
                'image_preview.mimes' => 'Image preview is invalid format :jpg,jpeg,png'
                ];

        if(!$request->has('trailer_id')) 
        {
                $rules['image_preview'] = 'required|mimes:jpg,jpeg,png';
                $messages['image_preview.required'] = 'Image preview is a required field.';

        }
         $validator = Validator::make($request->all(), $rules, $messages);
        

        if ($validator->fails())
        {
            return response()->json(['errCode' => 1, 'messages' => $validator->getMessageBag()]);
        }

        if(!$id)
        {
            return response()->json(['errCode' => 2, 'messages' => 'Invalid selection of data.']);
        }

        if ($request->has('trailer_id'))
        {
            $Trailer = Trailer::where('id', $request->trailer_id)->first();

            if($Trailer == NULL)
            {
                return response()->json(['errCode' => 2, 'messages' => 'Invalid selection of data.']);
            }

            $Trailer->trailer_url   = $request->url;
            $Trailer->save();
            
            if($request->hasFile('image_preview'))
            {
                $filename   =$Trailer->image_preview;
                $request->image_preview->move(public_path('content/film/trailers'), $filename);
            }

            return response()->json(['errCode' => 0, 'messages' => 'Trailer successfully updated.']);
        }

        $ext        = $request->image_preview->getClientOriginalExtension();
        $filename   = str_random(40) . '.' . $ext;

        $Trailer = new Trailer();
        $Trailer->trailer_url   = $request->url;
        $Trailer->image_preview = $filename;
        $Trailer->film_id       = $id;
        $Trailer->trailer_show  = 2;
        $Trailer->save();

        $request->image_preview->move(public_path('content/film/trailers'), $filename);


        return response()->json(['errCode' => 0, 'messages' => 'Trailer successfully added.']);
     }
}
