<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
//use Storage;
use File;

use App\Film;
use App\Genre;
use App\Trailer;
use App\Poster;
use App\Award;
use App\Photo;
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
        $RATINGS = Film::RATINGS; 
        return view('cms.film.partials.film_form', ['film_status' => $film_status, 'Film' => $Film, 'Genre' => $Genre, 'RATINGS'=>$RATINGS])->render();
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
                $filename   = str_random(100).  '.' . $ext;
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

    /* 
     * SPECIFIC FILM
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
        
        $Poster = Poster::where('film_id', $id)->orderBy('poster_image_sorter', 'ASC')->get();
        $Award  = Award::where('film_id', $id)->orderBy('award_image_sorter', 'ASC')->get();
        $Photo  = Photo::where('film_id', $id)->orderBy('photo_sorter', 'ASC')->get();

        return view('cms.film.specific_film.film', ['Film' => $Film, 'Poster' => $Poster, 'Award' => $Award, 'Photo' => $Photo]);
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
            return response()->json(['errCode' => 1, 'messages' => 'Invalid selection of trailer.']);
        }
         
        $Trailer = Trailer::where('id', $request->id)->first();
        $Trailer->trailer_show = 0;
        $Trailer->save();

        return response()->json(['errCode' => 0, 'messages' => 'Trailers successfully deleted.']);

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
            $rules['image_preview'] = 'required|mimes:jpeg,png|dimensions:min_width=1600,min_height=900';
            $messages['image_preview.required'] = 'Image preview is a required field.';
            $messages['image_preview.dimensions'] = 'Image preview is should atleast 1600px width and 900px in height.';
        }
        else
        {   //ratio=16/9
            $rules['image_preview'] = 'mimes:jpg,jpeg,png|dimensions:min_width=1600,min_height=900';
            $messages['image_preview.dimensions'] = 'Image preview is should atleast 1600px width and 900px in height.';
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
                $filename   = $Trailer->image_preview;
                $request->image_preview->move(public_path('content/film/trailers'), $filename);
            }

            return response()->json(['errCode' => 0, 'messages' => 'Trailer successfully updated.']);
        }

        $ext        = $request->image_preview->getClientOriginalExtension();
        $filename   = str_random(100) . '.' . $ext;

        $Trailer = new Trailer();
        $Trailer->trailer_url   = $request->url;
        $Trailer->image_preview = $filename;
        $Trailer->film_id       = $id;
        $Trailer->trailer_show  = 2;
        $Trailer->save();

        $request->image_preview->move(public_path('content/film/trailers'), $filename);


        return response()->json(['errCode' => 0, 'messages' => 'Trailer successfully added.']);
     }


     /* 
      * FILM POSTER
      */
    public function film_poster ()
    {
        echo "fsad";
        return ;
    }

    public function set_featured_image(Request $request)
    {
        if(!$request->has('id') || !$request->has('film_id'))
        {
            return response()->json(['errCode' => 1, 'messages' => 'Invalid selection of poster.']);
        }

        $Poster = Poster::where(['film_id' => $request->film_id, 'featured' => '1'])->first();
        if($Poster)
        {
            $Poster->featured = 0;
            $Poster->save();
        }

        $Poster = Poster::where(['id' => $request->id])->first();
        if(!$Poster)
        {
            return response()->json(['errCode' => 1, 'messages' => 'Invalid selection of poster.']);
        }

        $Poster->featured = 1;
        $Poster->save();
        return response()->json(['errCode' => 0, 'messages' => 'Poster successfully set as featured.']);
    }

    public function posters_order_save (Request $request)
    {
        foreach($request->order as $key => $val)
        {
            $Poster = Poster::where('id', $val)->first();
            $Poster->poster_image_sorter = $key + 1;
            $Poster->save();
        }

        return response()->json(['errCode' => 0, 'message' => 'Trailers successfully ordered.']);
    }

    public function poster_image_modal (Request $request)
    {
        $Poster = Poster::where('film_id', $request->film_id)->orderBy('poster_image_sorter', 'ASC')->get();
        return view('cms.film.specific_film.partials.film_poster_image_modal', ['Poster' => $Poster, 'film_id' => $request->film_id])->render();
    }

    public function poster_image_upload (Request $request)
    {
        if($request->hasFile('photo'))
        {
            $filename = '';
            $Poster =  new Poster();
            
            $photo = $request->file('photo');
            $ext = $photo->getClientOriginalExtension();
            $filename   = str_random(100) . '.' . $ext;
            $photo->move(public_path('content/film/posters'), $filename);

            $Poster->label = $filename;
            $Poster->featured = 0;
            $Poster->film_id = $request->film_id;
            $Poster->save();
            
            $initialPreview = [
                asset('content/film/posters').'/'.$filename
            ];
            $initialPreviewConfig = [
                ['caption' => "", 'size' => 0, 'width' => "120px", 'url' => route('poster_image_delete'), 'key' => $Poster->id, 'extra' => [' _token' => csrf_token() ] ]
            ];
            return response()->json([ 'initialPreview' => $initialPreview, 'initialPreviewConfig' => $initialPreviewConfig, 'initialPreviewThumbTags' => [], 'append' => true]);
        }
        else
        {
             $initialPreview = [
            ];
            $initialPreviewConfig = [
                []
            ];
            return response()->json([ 'initialPreview' => $initialPreview, 'initialPreviewConfig' => $initialPreviewConfig, 'initialPreviewThumbTags' => [], 'append' => true]);
        }
    } 

    public function poster_image_delete (Request $request)
    {
        $Poster = Poster::where('id', $request->key)->first();
        $Poster->delete();
        
        File::delete(public_path('content\\film\\posters\\' . $Poster->label));

        $initialPreview = [
        ];
        $initialPreviewConfig = [
            []
        ];
        return response()->json([ 'initialPreview' => $initialPreview, 'initialPreviewConfig' => $initialPreviewConfig, 'initialPreviewThumbTags' => [], 'append' => true]);
    }

    public function poster_image_fetch (Request $request)
    {
        $Poster = Poster::where('film_id', $request->film_id)->orderBy('poster_image_sorter', 'ASC')->get();
        return view('cms.film.specific_film.partials.film_poster_image_fetch', ['Poster' => $Poster])->render();
    } 

    /*
     *  FILM AWARDS
     */
    public function film_award_form (Request $request)
    {
        $Award = '';
        if($request->award_id)
        {
            $Award = Award::where('id', $request->award_id)->first();
        } 

        return view('cms.film.specific_film.partials.film_award_form', ['Award' => $Award])->render();
    }

    public function film_award_save ($id, Request $request)
    {
        $rules = [
            'award_title' => 'required',
            'award_image' => 'required|mimes:jpeg,png'
        ];
        $messages = [
            'award_title.required'  => 'Award title is required.',
            'award_image.required'  => 'Award photo is required.',
            'award_image.mimes'     => 'Award photo is invalid format it should be :jpeg,png.'
        ];

        if ($request->award_id)
        {
            $rules['award_image'] = 'mimes:jpeg,png';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails())
        {
            return response()->json(['errCode' => 1, 'messages' => $validator->getMessageBag()]);
        }

        if ($request->award_id) // this is for edit
        {
            $Award = Award::where('id', $request->award_id)->first();

            if ($Award == NULL) // no award selected
            {
                return response()->json(['errCode' => 2, 'messages' => 'Invalid selection of award.']); // return an error message
            }

            // award is existing

            $Award->award_name = $request->award_title;
            $Award->save();

            if ($request->hasFile('award_image')) // check if there is new file uploaded
            {
                $filename = $Award->award_image;
                $request->award_image->move(public_path('content/film/awards'), $filename); // upload the file
            }

            return response()->json(['errCode' => 0, 'messages' => 'Award information successfully editted.']); // return an success message
        }

        // this is for add

        $ext = $request->award_image->getClientOriginalExtension(); // get the file extension name

        $filename   = str_random(100). '.' . $ext; // generate random filename and append the extension

        $request->award_image->move(public_path('content/film/awards'), $filename); // upload the file

        $Award = new Award();
        $Award->award_name = $request->award_title;
        $Award->award_image = $filename;
        $Award->film_id = $id;
        $Award->save();
        
        return response()->json(['errCode' => 0, 'messages' => 'Award information successfully editted.']); // return an success message

    }

    public function film_award_order_save (Request $request)
    {

        foreach($request->order as $key => $val)
        {
            $Award = Award::where('id', $val)->first();
            $Award->award_image_sorter = $key + 1;
            $Award->save();
        }

        return response()->json(['errCode' => 0, 'message' => 'Awards successfully ordered.']);
    }

    public function film_awards_fetch ($id, Request $request)
    {
        $Award  = Award::where('film_id', $id)->orderBy('award_image_sorter', 'ASC')->get();
        return view('cms.film.specific_film.partials.film_awards_data', ['Award' => $Award])->render();
    }

    public function film_award_delete (Request $request)
    {
        if(!$request->id)
        {
            return response()->json(['errCode' => 1, 'messages' => 'Invalid selection of trailer.']);
        }
         
        $Award = Award::where('id', $request->id)->first();
        $Award->delete();

        File::delete(public_path('content\\film\\awards\\' . $Award->award_image));

        return response()->json(['errCode' => 0, 'messages' => 'Award successfully deleted.']);
    }

    public function film_photo_fetch ($id, Request $request)
    {
        $Photo  = Photo::where('film_id', $id)->orderBy('photo_sorter', 'ASC')->get();
        return view('cms.film.specific_film.partials.film_photo_data', ['Photo' => $Photo])->render();
    }

    public function film_photo_single_upload_form_modal (Request $request)
    {
        $Photo = '';
        if($request->photo_id)
        {
            $Photo = Photo::where('id', $request->photo_id)->first();
        } 
        return view('cms.film.specific_film.partials.film_photo_single_upload_form_modal', ['Photo' => $Photo])->render();
    }

    public function film_photo_order_save (Request $request)
    {
        foreach($request->order as $key => $val)
        {
            $Photo = Photo::where('id', $val)->first();
            $Photo->photo_sorter = $key + 1;
            $Photo->save();
        }

        return response()->json(['errCode' => 0, 'message' => 'Awards successfully ordered.']);
    }

    public function film_photo_single_save ($id, Request $request) 
    {
        
        $rules = [
            'title'         => 'required',
            'image_filename'    => 'required|mimes:jpeg,png'
        ];
        $messages = [
            'title.required'        => 'Image title is required.',
            'image_filename.required'   => 'Film photo is required.',
            'image_filename.mimes'      => 'Film photo is invalid format it should be :jpeg,png.'
        ];

        if ($request->photo_id)
        {
            $rules['image_filename'] = 'mimes:jpeg,png';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails())
        {
            return response()->json(['errCode' => 1, 'messages' => $validator->getMessageBag()]);
        }

        if ($request->photo_id) // this is for edit
        {
            $Photo = Photo::where('id', $request->photo_id)->first();

            if ($Photo == NULL) // no award selected
            {
                return response()->json(['errCode' => 2, 'messages' => 'Invalid selection of award.']); // return an error message
            }

            // award is existing

            $Photo->title = $request->title;
            $Photo->save();

            if ($request->hasFile('image_filename')) // check if there is new file uploaded
            {
                $filename = $Photo->filename;
                $request->image_filename->move(public_path('content/film/photos'), $filename); // upload the file
            }

            return response()->json(['errCode' => 0, 'messages' => 'Photo information successfully editted.']); // return an success message
        }

        // this is for add

        $ext = $request->image_filename->getClientOriginalExtension(); // get the file extension name

        $filename   = str_random(100) . '.' . $ext; // generate random filename and append the extension

        $request->image_filename->move(public_path('content/film/photos'), $filename); // upload the file

        $Photo = new Photo();
        $Photo->title       = $request->title;
        $Photo->filename    = $filename;
        $Photo->film_id     = $id;
        $Photo->save();
        
        return response()->json(['errCode' => 0, 'messages' => 'Photo information successfully editted.']); // return an success message
    }
}
