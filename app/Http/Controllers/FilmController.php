<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use File;
use DB;
use Intervention\Image\Facades\Image as Image; // or use Image;

use App\Film;
use App\Genre;
use App\Trailer;
use App\Poster;
use App\Award;
use App\Photo;
use App\Quote;
use App\PressRelease;
use App\RelatedLink;
use App\Person;
use App\FilmCrew;
use App\Dvd;

class FilmController extends Controller
{

    public function sample_upload (Request $request) {
        //echo "fsadf";
        
        
        //get the base-64 from data
        $base64_str = substr($request->imgData, strpos($request->imgData, ",")+1);
        
        //decode base64 string
        $image = base64_decode($base64_str);
        
        $png_url = "product-".time().".png";
        $path = public_path('cms') .'\\'. $png_url;
        //echo $path;
        file_put_contents($path, base64_decode($base64_str));
        //Image::make(file_get_contents(base64_decode($request->imgData)))->save($path);
        return;
    }

    public function index () 
    {
        $Film = Film::where(function ($query) {
            $query->where('release_status', '=', NULL);
            $query->orWhere('release_status', '>', 0);
        })
        ->orderBy('title', 'asc')
        ->orderBy('release_date', 'DESC')
        ->paginate(10);

        $RATINGS = Film::RATINGS;
        
        return view('cms.film.index', ['Film' => $Film, 'RATINGS' => $RATINGS]);
    }

    public function film_synopsis_save (Request $request)
    {
        if (!$request->id)
        {
            return response()->json(['errCode' => 1, 'messages' => 'Invalid selection of film']);
        }

        $Film = Film::where('id', $request->id)->first();

        if(!$Film)
        {
            return response()->json(['errCode' => 1, 'messages' => 'Invalid selection of film']);
        }

        $Film->synopsis = $request->synopsis;
        $Film->save();

        return response()->json(['errCode' => 0, 'messages' => 'Synopsis successfully updated']);
    }

    public function fetch_record (Request $request)
    {

        $per_page = 10;

        if ($request->per_page)
        {
            $per_page = $request->per_page;
        }
        
        $Film = Film::where(function ($query) use($request) {
            $query->where('title', 'LIKE', '%'. $request->search .'%');
            $query->orWhere('genre', 'LIKE', '%'. $request->search .'%');
            $query->where(function ($q) {
                //$q->where('release_status', '!=', 0);
                $q->where('release_status', '=', NULL);
                $q->orWhere('release_status', '>', 0);
            });
        })
        // ->orWhereHas('genre', function ($query) use($request) {
        //     $query->where('genre', 'LIKE', '%'. $request->search .'%');
        // })
        ->orderBy('title', 'asc')
        ->orderBy('release_date', 'DESC')
        ->paginate($per_page);
        $RATINGS = Film::RATINGS;
        return view('cms.film.partials.film_records', ['Film' => $Film, 'RATINGS' => $RATINGS, 'per_page' => $per_page, 'request' => $request]);
    }

    public function show_film_form (Request $request)
    {
        $Film = '';
        if ($request->id)
        {
            $Film = Film::with('links')->where('id', $request->id)->first();

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
            'release_status'    => 'digits_between:min:1,3',
            'running_time'      => 'nullable|digits_between:1,1000',
            'facebook_link'     => 'nullable|url',
            'twitter_link'      => 'nullable|url',
            'instagram_link'    => 'nullable|url',
        ];
        $messages = [
            'title.required'    => 'Film title is required field.',
            'genre.required'    => 'Film genre is required field.',
            'sellsheet.mimes'   => 'Sell sheet should be in pdf file format.',
            'release_status.digits_between' => 'Releas status is required field.',
            'running_time.digits_between'   => 'Please provide a valid running time in minutes.',
            'facebook_link.url'     => 'Invalid Facebook link.',
            'twitter_link.url'      => 'Invalid Twitter link.',
            'instagram_link.url'    => 'Invalid Instagram link.',
        ];;
          
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
        {
            return response()->json(['errCode' => 1, 'messages' => $validator->getMessageBag()]);
        }

        $genre_arr = explode(',', $request->genre);
        
        foreach($genre_arr as $val)
        {   
            $Genre = Genre::where('genre', trim($val))->first();
            
            if(!$Genre) // no genre in genres table so we need to add new genre base on use input
            {
                $Genre = new Genre();
                $Genre->genre = trim($val);
                $Genre->save();
            }
        }

        // $genre_id = '';

        // $Genre = Genre::where('genre', $request->genre)->first();

        // if($Genre) // has a genre in genres table
        // {
        //     $genre_id = $Genre->id;
        // }   
        // else // no genre in genres table so we need to add new genre base on use input
        // {
        //     $Genre = new Genre();
        //     $Genre->genre = $request->genre;
        //     $Genre->save();
        //     $genre_id = $Genre->id;
        // }

        if($request->has('id')) // has id then it is updating of record
        {

            $Film                   = Film::where('id', $request->id)->first();
            $Film->title            = $request->title;
            $Film->english_title    = $request->english_title;
            $Film->genre            = $request->genre;
            //$Film->synopsis         = $request->synopsis;
            $Film->release_status   = ($request->release_status != '' ? $request->release_status : NULL);
            $Film->release_date     = ($request->has('release_date') ? Date('Y-m-d', strtotime($request->release_date)) : null);
            $Film->rating           = $request->rating;
            $Film->running_time     = $request->running_time;
            $Film->hash_tags        = $request->hashtags;
            
            $filename = '';
            if ($request->hasFile('sellsheet'))
            {
                if ($Film->sell_sheet == '')
                {
                    $sellsheet_ext  = $request->sellsheet->getClientOriginalExtension();
                    $filename       = str_random(20) . '.' . $sellsheet_ext;
                }
                else
                {
                    $filename = $Film->sell_sheet; 
                }

                $Film->sell_sheet = $filename; 

                $request->sellsheet->move(public_path('content/sell_sheets'),$filename);
            }

            $Film->save();

            if($request->facebook_link || $request->twitter_link || $request->instagram_link)
            {
                $RelatedLink = RelatedLink::where('film_id', $request->id)->first();
                if($RelatedLink) // update links
                {        
                    $RelatedLink->facebook_url  = $request->facebook_link;
                    $RelatedLink->twitter_url   = $request->twitter_link;
                    $RelatedLink->instagram_url = $request->instagram_link;
                    $RelatedLink->save();
                }
                else // create links
                {
                    $RelatedLink = new RelatedLink();
                    $RelatedLink->facebook_url  = $request->facebook_link;
                    $RelatedLink->twitter_url   = $request->twitter_link;
                    $RelatedLink->instagram_url = $request->instagram_link;
                    $RelatedLink->film_id       = $request->id;
                    $RelatedLink->save();
                }
            }
            
            return response()->json(['errCode' => 0, 'messages' => 'Film successfully updated.']);
        }

        // adding of record

        $Film                   = new Film();
        $Film->title            = $request->title;
        $Film->english_title    = $request->english_title;
        $Film->genre            = $request->genre;
        //$Film->synopsis         = $request->synopsis;
        $Film->release_status   = ($request->release_status != '' ? $request->release_status : NULL);
        $Film->release_date     = ($request->has('release_date') ? Date('Y-m-d', strtotime($request->release_date)) : NULL);
        $Film->rating           = $request->rating;
        $Film->running_time     = $request->running_time;
        $Film->hash_tags        = $request->hashtags;

        if ($request->hasFile('sellsheet'))
        {
        $sellsheet_ext  = $request->sellsheet->getClientOriginalExtension();
        $filename       = str_random(20) . '.' . $sellsheet_ext; 
            $Film->sell_sheet       = $filename;
            $request->sellsheet->move(public_path('content/sell_sheets'),$filename);
        }

        $Film->save();

        if($request->facebook_link || $request->twitter_link || $request->instagram_link)
        {
            $RelatedLink = RelatedLink::where('film_id', $request->id)->first();
            if($RelatedLink) // update links
            {        
                $RelatedLink->facebook_url  = $request->facebook_link;
                $RelatedLink->twitter_url   = $request->twitter_link;
                $RelatedLink->instagram_url = $request->instagram_link;
                $RelatedLink->save();
            }
            else // create links
            {
                $RelatedLink = new RelatedLink();
                $RelatedLink->facebook_url  = $request->facebook_link;
                $RelatedLink->twitter_url   = $request->twitter_link;
                $RelatedLink->instagram_url = $request->instagram_link;
                $RelatedLink->film_id       = $Film->id;
                $RelatedLink->save();
            }
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

    public function delete_sellsheet ($id) 
    {
        if (!$id)
        {
            return response()->json(['errCode' => 1, 'messages' => 'Invalid selection of film sell sheet.']);
        }

        $Film = Film::where('id', $id)->first();

        if (!$Film)
        {
            return response()->json(['errCode' => 1, 'messages' => 'Invalid selection of film sell sheet.']);
        }

        $public_path = public_path('content/sell_sheets/');

        if (File::exists($public_path . $Film->sell_sheet))
        {
            File::delete($public_path . $Film->sell_sheet);
            $Film->sell_sheet = NULL;
            $Film->save();
            return response()->json(['errCode' => 0, 'messages' => 'Sell sheet successfully deleted.']);
        }

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
            'genre',
            'links'
            ])->where('id', $id)->first();
        
        if(!$Film)
        {
            return redirect(route('film'));
        }
        
        $Poster         = Poster::where('film_id', $id)->orderBy('poster_image_sorter', 'ASC')->get();
        $Award          = Award::where('film_id', $id)->orderBy('award_image_sorter', 'ASC')->get();
        $Photo          = Photo::where('film_id', $id)->orderBy('photo_sorter', 'ASC')->orderBy('updated_at', 'DESC')->get();
        $Quote          = Quote::where('film_id', $id)->first();
        $PressRelease   = PressRelease::where('film_id', $id)->first();
        $FilmCrew       = FilmCrew::with('person')->where('film_id', $id)->orderBy('role')->get();
        $Dvd            = Dvd::where('film_id', $id)->orderBy('dvd_order', 'ASC')->get();

        $Person         = Person::all(['name']);

        $RATINGS        = Film::RATINGS;    
        $RELEASE_STATUS = Film::RELEASE_STATUS;
        $PERSON_ROLES   = FilmCrew::ROLE;
        //return json_encode($Film);
        return view('cms.film.specific_film.film', ['Film' => $Film, 'Poster' => $Poster, 'Award' => $Award, 'Photo' => $Photo, 'Quote' => $Quote, 'PressRelease' => $PressRelease, 'FilmCrew' => $FilmCrew, 'Dvd' => $Dvd, 'Person' => $Person, 'RATINGS' => $RATINGS, 'RELEASE_STATUS' => $RELEASE_STATUS, 'PERSON_ROLES' => $PERSON_ROLES]);
     }

     public function film_basic_info_fetch ($id)
     {
        $Film = Film::where('id', $id)->first(); 
        
        $RATINGS        = Film::RATINGS;
        $RELEASE_STATUS = Film::RELEASE_STATUS;
        return view('cms.film.specific_film.partials.film_basic_info', ['Film' => $Film, 'RATINGS' => $RATINGS, 'RELEASE_STATUS' => $RELEASE_STATUS])->render();
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
            $rules['image_preview']                 = 'required|mimes:jpeg,png|dimensions:min_width=1600,min_height=900,max_width=1600,max_height=900|max:1024';
            $messages['image_preview.required']     = 'Image preview is a required field.';
            $messages['image_preview.dimensions']   = 'Image preview is should 1600px width and 900px in height.';
            $messages['image_preview.max']          = 'Image preview is should only 1MB and below in size.';
        }
        else
        {   //ratio=16/9
            $rules['image_preview']                 = 'mimes:jpg,jpeg,png|dimensions:min_width=1600,min_height=900,max_width=1600,max_height=900|max:1024';
            $messages['image_preview.dimensions']   = 'Image preview is should 1600px width and 900px in height.';
            $messages['image_preview.max']          = 'Image preview is should only 1MB and below in size.';
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

            
            if($request->hasFile('image_preview'))
            {
                $old_filename   = $Trailer->image_preview;
                File::delete(public_path('content\\film\\trailers\\' . $old_filename));
                
                $ext        = $request->image_preview->getClientOriginalExtension();
                $filename   = str_random(100) . '.' . $ext;
                $request->image_preview->move(public_path('content/film/trailers'), $filename);

                $Trailer->image_preview = $filename;
            }

            $Trailer->trailer_url   = $request->url;
            $Trailer->save();
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
        $rule = [
                'photo' => 'required|dimensions:min_width=600,max_width=1200|max:1024'
        ];
        $message = [
            'photo.required'    => 'Poster photo is required',
            'photo.dimensions'  => 'Poster photo width should only between 600 to 1200 pixels.'
        ];
        $validator = Validator::make($request->all(), $rule, $message);
        
        if ($validator->fails())
        {
            $initialPreview = [];
            $initialPreviewConfig = [
                []
            ];
            return response()->json([ 'initialPreview' => $initialPreview, 'initialPreviewConfig' => $initialPreviewConfig, 'initialPreviewThumbTags' => [], 'append' => true, 'error' => 'Poster photo width should only between 600 to 1200 pixels, and should not exceeds file size of 1mb.']);
        }

        if($request->hasFile('photo'))
        {
            $filename = '';
            $Poster =  new Poster();
            
            $photo = $request->file('photo');
            $ext = $photo->getClientOriginalExtension();
            $filename   = str_random(100);
            $full_filename = $filename . '.' . $ext;
            $photo->move(public_path('content/film/posters'), $full_filename);

            $Poster->label = $full_filename;
            $Poster->featured = 0;
            $Poster->film_id = $request->film_id;
            $Poster->save();
            
            $img = Image::make(public_path('content/film/posters/' . $full_filename));
            $img->resize(250, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(public_path('content/film/posters/' . $filename . '-preview.' . $ext));
            $initialPreview = [
                asset('content/film/posters').'/'.$full_filename
            ];
            $initialPreviewConfig = [
                ['caption' => "", 'size' => 0, 'width' => "120px", 'url' => route('poster_image_delete'), 'key' => $Poster->id, 'extra' => [' _token' => csrf_token() ] ]
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
            'award_image' => 'required|mimes:jpeg,png|dimensions:min_width=200,min_height=200,max_width=200,max_height=200'
        ];
        $messages = [
            'award_title.required'       => 'Award title is required.',
            'award_image.required'       => 'Award photo is required.',
            'award_image.dimensions'     => 'Award photo should atleast 200 x 200 pixels.'
        ];

        if ($request->award_id)
        {
            $rules['award_image'] = 'mimes:jpeg,png|dimensions:min_width=200,min_height=200,max_width=200,max_height=200';
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

            if ($request->hasFile('award_image')) // check if there is new file uploaded
            {
                File::delete(public_path('content\\film\\awards\\' . $Award->award_image));


                $ext = $request->award_image->getClientOriginalExtension(); // get the file extension name
                $filename   = str_random(100). '.' . $ext; // generate random filename and append the extension
                $request->award_image->move(public_path('content/film/awards'), $filename); // upload the file

                $Award->award_image = $filename;
            }

            $Award->save();
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

    /**
     * FILM PHOTO
     *
     */

    public function film_photo_fetch ($id, Request $request)
    {
        $Photo  = Photo::where('film_id', $id)->orderBy('photo_sorter', 'ASC')->get();
        $Film   = Film::where('id', $id)->first();
        return view('cms.film.specific_film.partials.film_photo_data', ['Photo' => $Photo, 'Film' => $Film])->render();
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

    public function film_photo_set_featured (Request $request)
    {
        if (!$request->id || !$request->film_id)
        {
            return response()->json(['errCode' => 1, 'messages' => 'Invalid selection of photo galler or film.']);
        }

        $Photo = Photo::where('id', $request->id)->where('film_id', $request->film_id)->first();

        if ($Photo == NULL) // no photo
        {
            return response()->json(['errCode' => 2, 'messages' => 'Invalid selection of gallery photo.']); // return an error message
        }

        $Photo_List = Photo::where('film_id', $Photo->film_id)->get();
            
        if ($Photo_List)
        {
            foreach ($Photo_List as $data)
            {
                $data->featured = NULL;
                $data->save();
            }
        }

        $Photo->featured = 1;
        $Photo->save();

        return response()->json(['errCode' => 0, 'messages' => 'Successfully set as featured.']);
    }

    public function film_photo_single_save ($id, Request $request) 
    {
        
        $rules = [
            //'title'         => 'nullable',
            'image_filename'    => 'required|mimes:jpeg,png|max:2048'
        ];
        $messages = [
            //'title.required'        => 'Image title is required.',
            'image_filename.required'   => 'Film photo is required.',
            'image_filename.mimes'      => 'Film photo is invalid format it should be :jpeg,png.',
            'image_filename.required'   => 'Film photo filesize should be only 2MB.',
        ];

        if ($request->photo_id)
        {
            $rules['image_filename'] = 'mimes:jpeg,png';
        }

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails())
        {
            $initialPreview = [];
            $initialPreviewConfig = [
                []
            ];
            return response()->json([ 'initialPreview' => $initialPreview, 'initialPreviewConfig' => $initialPreviewConfig, 'initialPreviewThumbTags' => [], 'append' => true, 'error' => 'Poster photo should not exceeds file size of 2mb.']);
        
            /**
             *  the code below that returns a json response is for single upload only 
             *  
             */
            //return response()->json(['errCode' => 1, 'messages' => $validator->getMessageBag()]);
            
        }
        
        $Film = Film::where('id', $id)->first(['title', 'release_date']);
        if (!$Film)
        {
            return response()->json(['errCode' => 2, 'messages' => 'Invalid film selection.']); // return an error message 
        }


        if ($request->photo_id) // this is for edit
        {

            $Photo = Photo::where('id', $request->photo_id)->first();

            if ($Photo == NULL) // no photo
            {
                return response()->json(['errCode' => 2, 'messages' => 'Invalid selection of gallery photo.']); // return an error message
            }
            
            if ($request->film_photo_featured_switch && $request->hasFile('image_filename'))
            {
                return response()->json(['errCode' => 2, 'messages' => 'You should upload first then crop it to set as featured photo.']); // return an success message
            }

            if ($request->film_photo_featured_switch && $Photo->thumb_filename == NULL) 
            {
                return response()->json(['errCode' => 2, 'messages' => 'To set as featured photo it should have a cropped thumbnail.']); // return an success message
            }
            // award is existing
            DB::beginTransaction();

            $Photo_List = Photo::where('film_id', $Photo->film_id)->get();
            
            if ($Photo_List && $request->film_photo_featured_switch)
            {
                foreach ($Photo_List as $data)
                {
                    $data->featured = NULL;
                    $data->save();
                }

                $Photo->featured = 1;
            }

            $old_filename = '';
            $old_thumb_filename = '';
            if ($request->hasFile('image_filename')) // check if there is new file uploaded
            {
                $ext = $request->image_filename->getClientOriginalExtension(); // get the file extension name
                $random_str = str_random(100);
                $filename   = $random_str . '.' . $ext; // generate random filename and append the extension
                //$thumb_file = $filename . '-thumbnail' . $ext;
                $old_filename = $Photo->filename;
                $old_thumb_filename = $Photo->thumb_filename;
                /**
                 * Code below is the previous code to delete the old image, it was changed by the code under the DB::commit()
                 */
                //File::delete(public_path('content\\film\\photos\\' . $old_filename)); 

                $request->image_filename->move(public_path('content/film/photos'), $filename); // upload the file
                
                $Photo->filename    = $filename;
                $Photo->thumb_filename    = NULL;
            
            }

            // if ($request->film_photo_featured_switch)
            // {
            //     $Photo->featured = 1;
            // }

            $Photo->title = $request->title; // ($request->title ? $request->title : $Film->title . '(' . date('Y', strtotime($Film->release_date)) . ')');
            $Photo->save();

            DB::commit();
            if ($request->hasFile('image_filename')) // check if there is new file uploaded
            {
                $file_path = public_path('content/film/photos/');

                if (File::exists($file_path . $old_filename))
                {
                    File::delete($file_path . $old_filename);
                }

                if (File::exists($file_path . $old_thumb_filename))
                {
                    File::delete($file_path . $old_thumb_filename);
                }
            }
            return response()->json(['errCode' => 0, 'messages' => 'Photo information successfully editted.']); // return an success message
        }

        // this is for add

        $ext = $request->image_filename->getClientOriginalExtension(); // get the file extension name

        $filename   = str_random(100) . '.' . $ext; // generate random filename and append the extension

        $request->image_filename->move(public_path('content/film/photos'), $filename); // upload the file

        $Photo = new Photo();
        $Photo->title       = $request->title; // ($request->title ? $request->title : $Film->title . '(' . date('Y', strtotime($Film->release_date)) . ')');
        $Photo->filename    = $filename;
        $Photo->film_id     = $id;
        $Photo->save();
        
        if ($request->upload_type)
        {
            $initialPreview = [
                asset('content/film/photos').'/'.$filename
            ];
            $initialPreviewConfig = [
                ['caption' => "", 'size' => 0, 'width' => "120px", 'url' => route('photo_single_delete'), 'key' => $Photo->id, 'extra' => [' _token' => csrf_token(), 'id' => $Photo->id ] ]
            ];
            return response()->json([ 'initialPreview' => $initialPreview, 'initialPreviewConfig' => $initialPreviewConfig, 'initialPreviewThumbTags' => [], 'append' => true]);
        }

        return response()->json(['errCode' => 0, 'messages' => 'Photo information successfully editted.']); // return an success message
    }

    public function photo_single_delete (Request $request)
    {
        if (!$request->id)
        {
            return response()->json(['errCode' => 2, 'messages' => 'Invalid selection of photo.']);
        }

        $Photo = Photo::where('id', $request->id)->first();

        $file_path = public_path('content/film/photos/');

        if (File::exists($file_path . $Photo->filename))
        {
            File::delete($file_path . $Photo->filename);
        }

        if (File::exists($file_path . $Photo->thumb_filename))
        {
            File::delete($file_path . $Photo->thumb_filename);
        }

        $Photo->delete();
        return response()->json(['errCode' => 0, 'messages' => 'Photo successfully deleted.', 'closeModal' => true]);
    }

    public function film_photo_multi_upload_form_modal (Request $request) 
    {
        $Photo = Photo::where('film_id', $request->film_id)->get();
        return view('cms.film.specific_film.partials.film_photo_multi_upload_form_modal', ['Photo' => $Photo, 'film_id' => $request->film_id])->render();
    }

    public function film_photo_crop_modal (Request $request)
    {
        $Photo = Photo::where(['id' => $request->photo_id, 'film_id' => $request->film_id])->first(['id', 'filename', 'film_id']);
        return view('cms.film.specific_film.partials.film_photo_crop_modal', ['Photo' => $Photo])->render();
    }

    public function film_photo_crop_save (Request $request)
    {
        $rules = [
            'left'      => 'required',
            'top'       => 'required',
            'width'     => 'required|digits_between:1,300',
            'height'    => 'required|digits_between:1,300',
            'photo_id'  => 'required',
            'film_id'   => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            return response()->json(['errCode' => 2, 'messages' => $validator->getMessageBag()]);
        }

        $Photo = Photo::where(['id' => $request->photo_id, 'film_id' => $request->film_id])->first();

        //return json_encode($request->all());
        if (!$Photo)
        {
            return response()->json(['errCode' => 2, 'messages' => 'Invalid selected film photo.']);
        }

        $origFilename           = $Photo->filename;
        $origFilename_arr       = explode('.', $origFilename);
        $ext                    = array_pop($origFilename_arr);
        $origFilename           = implode('.', $origFilename_arr);
        $filename               = $origFilename . '-thumbnail';
        $cropFilename           = $filename . '.' . $ext;

        $Photo->thumb_filename  = $cropFilename;
        $Photo->save();

        // $file_path = public_path('content/film/photos/');
        // if (File::exists($file_path . $Photo->filename))
        // {
        //     File::delete($file_path . $Photo->filename);
        // }

        $film_thumbnail = \Image::make(public_path('content/film/photos/' . $Photo->filename));

        $film_thumbnail->crop($request->width, $request->height, $request->left, $request->top);
        $film_thumbnail->save(public_path('content/film/photos/' . $cropFilename));

        $film_thumbnail = Image::make(public_path('content/film/photos/' . $cropFilename));
        $film_thumbnail->resize(300, 300);
        $film_thumbnail->save(public_path('content/film/photos/' . $cropFilename));
        return response()->json(['errCode' => 0, 'messages' => 'Film photo successfully cropped.']);
    }

    /*
     * FILM QUOTE
     */
    public function film_quote_form_modal (Request $request)
    {
        if (!$request->film_id)
        {
            return response()->json(['errCode' => 1, 'messages' => 'Invalid selection of quote.']);
        }

        $Quote = Quote::where('film_id', $request->film_id)->first(); 

        return view('cms.film.specific_film.partials.film_quote_form_modal', ['Quote' => $Quote, 'film_id' => $request->film_id])->render();
    }

    public function film_quote_save (Request $request)
    {
        $validator = Validator::make($request->all(), [
                'main_quote'    => 'required',
                'person'        => 'required'
            ], [
                'main_quote.required'    => 'Quote is required.',
                'person.required'        => 'Person is required.'
            ]);

        if ($validator->fails())
        {
            return response()->json(['errCode' => 1, 'messages' => $validator->getMessageBag()]);
        }
 
        $Quote = Quote::where(['film_id' => $request->film_id, 'id' => $request->quote_id])->first();

        if($Quote) // there is an existing then edit
        {
            $Quote->main_quote      = $request->main_quote;
            $Quote->name_of_person  = $request->person;
            $Quote->url             = $request->url;
            $Quote->save();

            return response()->json(['errCode' => 0, 'messages' => 'Quote successfully updated.']);
        }

        $Quote = new Quote();

        $Quote->main_quote      = $request->main_quote;
        $Quote->name_of_person  = $request->person;
        $Quote->url             = $request->url;
        $Quote->film_id         = $request->film_id;
        $Quote->save();

        return response()->json(['errCode' => 0, 'messages' => 'Quote successfully updated.']);

    }

    public function film_quote_fetch ($id, Request $request) 
    {
        $Quote = Quote::where('film_id', $id)->first();
        return view('cms.film.specific_film.partials.film_quote_data_fetch', ['Quote' => $Quote])->render();
    }

    /*
     * PRESS RELEASE
     */
    
    public function film_press_release_save (Request $request)
    {
        $rules = [
            'film_id'                       => 'required',
            'press_release_title'           => 'required',
            'press_release_article_image'   => 'required|mimes:jpeg,png',
            'press_release_blurb'           => 'required',
            'press_release_content'         => 'required'
        ];

        $messages = [
            'film_id.required'                          => 'Invalid film data selection.',
            'press_release_title.required'              => 'Title field is required.',
            'press_release_article_image.required'      => 'Article image field is required.',
            'press_release_article_image.mimes'         => 'Article image should be a valid format :jpeg, png',
            'press_release_blurb.required'              => 'Blurb field is required.',
            'press_release_content.required'            => 'Article content field is required.'
        ];
        
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

        $PressRelease = PressRelease::where('film_id', $request->film_id)->first();
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

        $PressRelease->save();

        return response()->json(['errCode' => 0, 'messages' => 'Press release successfully added.']);

    }

    public function film_press_release_fetch ($id) 
    {
        $PressRelease = PressRelease::where('film_id', $id)->first();
        return view('cms.film.specific_film.partials.film_press_release_data', ['PressRelease' => $PressRelease])->render();
    }

    public function film_press_release_form_modal ($id)
    {
        $PressRelease = PressRelease::where('film_id', $id)->first();
        return view('cms.film.specific_film.partials.film_press_release_form_modal', ['PressRelease' => $PressRelease, 'film_id' => $id])->render();
    }

    public function film_press_release_delete (Request $request)
    {
        if(!$request->id || !$request->film_id)
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
     * FILM CREW
     */
    
    public function film_crew_save (Request $request) 
    {
        $regex = 'regex:/^[\pL\s\,\.\"\(\) -]+$/u';
        $rules = [
            'director'              => 'nullable|'.$regex,
            'producer'              => 'nullable|'.$regex,
            'executive_producer'    => 'nullable|'.$regex,
            'cast'                  => 'nullable|'.$regex,
            'written_by'            => 'nullable|'.$regex,
            'director_of_photography' => 'nullable|'.$regex,
            'production_designer'   => 'nullable|'.$regex,
            'co-executive_producer' => 'nullable|'.$regex,
            'screenplay_by'         => 'nullable|'.$regex,
            'editor'                => 'nullable|regex:/^[\pL\s\,]+$/u',
            'sound_designer'        => 'nullable|'.$regex,
            'vfx'                   => 'nullable|'.$regex,
            'story_by'              => 'nullable|'.$regex,
            'cinematography'        => 'nullable|'.$regex,
            'music_by'              => 'nullable|'.$regex,
            'distributed_by'        => 'nullable|'.$regex,
            'production_designer_for_costume' => 'nullable|'.$regex,
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return response()->json(['errCode' => 1, 'messages' => $validator->getMessageBag()]);
        }
        $data = $request->all();
        array_shift($data);
        array_shift($data);

        $film_id = $request->film_id;

        foreach ($data as $key => $val)
        {
            $names = explode(',', $val);

            $ids_not_to_be_delete = [];

            $role = str_replace('_', ' ', strtoupper($key)); // replace the role underscore (_) with space to match the array of roles
            
            $role_id = array_search($role, FilmCrew::ROLE); // get the key id of role

            foreach ($names as $n)
            {
                if ($n != '') // go thru not blank data only
                {

                    // check if the person already in the list
                    $Person = Person::where('name', trim($n))->first(); 

                    if (!$Person) // if not in the list
                    {
                        // create new person
                        $Person = new Person();
                        $Person->name = ucwords(trim($n));
                        $Person->save();

                        // create film crew that tags to the film
                        $FilmCrew               = new FilmCrew();
                        $FilmCrew->film_id      = $film_id;
                        $FilmCrew->people_id    = $Person->id;
                        $FilmCrew->role         = $role_id;
                        $FilmCrew->save();

                        $ids_not_to_be_delete[] = $Person->id;

                    }
                    else // person already exists in the list
                    {
                        // check if the current person in the loop is already in the database
                        $FilmCrew = FilmCrew::where(['people_id' => $Person->id, 'role' => $role_id, 'film_id' => $film_id])->first();

                        if (!$FilmCrew) // if not in the database create new
                        {
                            // create film crew that tags to the film
                            $FilmCrew               = new FilmCrew();
                            $FilmCrew->film_id      = $film_id;
                            $FilmCrew->people_id    = $Person->id;
                            $FilmCrew->role         = $role_id;
                            $FilmCrew->save();

                            $ids_not_to_be_delete[] = $Person->id;
                        }
                        else
                        {
                            $ids_not_to_be_delete[] = $Person->id;
                        }
                    }
                }
            }

            // Delete all crew that are not in the list variable (ids_not_to_be_delete) 
            $FilmCrew = FilmCrew
                        ::where(['role' => $role_id, 'film_id' => $film_id])
                        ->where(function ($q) use ($ids_not_to_be_delete) {
                            $q->whereNotIn('people_id', $ids_not_to_be_delete);
                        })
                        ->delete();

        }
        return response()->json(['errCode' => 0, 'messages' => 'Film crew successfully updated.']);
    }
    public function film_crew_form_modal (Request $request)
    {   
        $FilmCrew       = FilmCrew::with('person')->where('film_id', $request->film_id)->orderBy('role')->get();
        $PERSON_ROLES   = FilmCrew::ROLE;
        return view('cms.film.specific_film.partials.film_crew_form_modal', ['FilmCrew' => $FilmCrew, 'film_id' => $request->film_id, 'PERSON_ROLES' => $PERSON_ROLES])->render();
    }

    public function film_crew_data_fetch ($id)
    {
        $FilmCrew       = FilmCrew::with('person')->where('film_id', $id)->orderBy('role')->get();
        $PERSON_ROLES   = FilmCrew::ROLE;
        return view('cms.film.specific_film.partials.film_crew_data', ['FilmCrew' => $FilmCrew, 'PERSON_ROLES' => $PERSON_ROLES])->render();
    }

    /**
     * FILM DVD
     */
    
    public function film_dvd_form_modal (Request $request) 
    {
        $Dvd = Dvd::where(['id' => $request->dvd_id, 'film_id' => $request->film_id])->first();
        return view('cms.film.specific_film.partials.film_dvd_form_modal', ['Dvd' => $Dvd, 'film_id' => $request->film_id])->render();         
    }

    public function film_dvd_sorter (Request $request) 
    {

        foreach($request->order as $key => $val)
        {
            $Dvd = Dvd::where('id', $val)->first();
            $Dvd->dvd_order = $key + 1;
            $Dvd->save();
            //echo json_encode($Trailer);
            //echo $Trailer->trailer_image_sorter . ' ' . $key . ' ' . $val . '<br >' ;
        }

        return response()->json(['errCode' => 0, 'message' => 'DVD successfully ordered.']);
    }

    public function film_dvd_save (Request $request)
    {
        $rules = [
            'film_id'   => 'required',                      
            'dvd_case_cover' => 'required|mimes:png|max:2048|dimensions:max_width=300,max_height=500,min_width=300,min_height=500',
            'dvd_disc_image' => 'required|mimes:png|max:2048|dimensions:max_width=300,max_height=300,min_width=300,min_height=300',
            'dvd_languages' => 'required',
            'dvd_subtitles' => 'required',
            'dvd_running_time' => 'nullable|digits_between:1,5',
        ];

        $messages = [
            'film_id.required'                  => 'Invalid selection of film.',
            'dvd_case_cover.required'           => 'DVD case image cover is required.',
            'dvd_case_cover.mimes'              => 'DVD case image cover should only be a PNG file type.',
            'dvd_case_cover.dimensions'         => 'DVD case image cover should only be 300 x 500 pixels.',
            'dvd_case_cover.max'                => 'DVD case image cover should not exceeds 2MB.',
            'dvd_disc_image.required'           => 'DVD disc image is required.',
            'dvd_disc_image.mimes'              => 'DVD disc image should only be a PNG file type.',
            'dvd_disc_image.dimensions'         => 'DVD disc image cover should only be 300 x 300 pixels.',
            'dvd_disc_image.max'                => 'DVD disc image cover should not exceeds 2MB.',
            'dvd_languages.required'            => 'Language is required.',
            'dvd_subtitles.required'            => 'Subtitle is required.',
            'dvd_running_time.digits_between'   => 'Invalid running time.', 
        ];

        if ($request->dvd_id)
        {
            $rules['dvd_case_cover'] = 'nullable|mimes:png|max:2048|dimensions:max_width=300,max_height=500,min_width=300,min_height=500';
            $rules['dvd_disc_image'] = 'nullable|mimes:png|max:2048|dimensions:max_width=300,max_height=300,min_width=300,min_height=300';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
        {
            return response()->json(['errCode' => 1, 'messages' => $validator->getMessageBag()]);
        }

        $Film = Film::where('id', $request->film_id)->first();

        // check if film is valid
        if (!$Film)
        {
            return response()->json(['errCode' => 2, 'messages' => 'Invalid selection of film.']);
        }

        // path to dvd image storage
        $public_path = public_path('content/film/dvds/');

        if ($request->dvd_id) // has dvd_id and this is for editing
        {

            $Dvd = Dvd::where('id', $request->dvd_id)->first();
            
            // check if dvd is valid
            if (!$Dvd)
            {
                return response()->json(['errCode' => 2, 'messages' => 'Invalid selection of film DVD.']);
            }

            if ($request->hasFile('dvd_case_cover'))
            {
                $dvd_case_cover_ext = $request->dvd_case_cover->getClientOriginalExtension();
                $dvd_case_cover     = str_random(100) . '.' . $dvd_case_cover_ext;
                $request->dvd_case_cover->move($public_path, $dvd_case_cover);

                if (File::exists($public_path . $Dvd->dvd_case_cover))
                {
                    File::delete(public_path('content/film/dvds/' . $Dvd->dvd_case_cover));
                }

                $Dvd->dvd_case_cover    = $dvd_case_cover;
            }
            
            if ($request->hasFile('dvd_disc_image'))
            {
                $dvd_disc_image_ext = $request->dvd_disc_image->getClientOriginalExtension();
                $dvd_disc_image     = str_random(100) . '.' . $dvd_disc_image_ext;
                $request->dvd_disc_image->move($public_path, $dvd_disc_image);

                if (File::exists($public_path . $Dvd->dvd_disc_image))
                {
                    File::delete(public_path('content/film/dvds/' . $Dvd->dvd_disc_image));
                }

                $Dvd->dvd_disc_image    = $dvd_disc_image;
            }
            
            $Dvd->name              = ($request->dvd_name ? $request->dvd_name : $Film->title . ' DVD');
            $Dvd->languages         = $request->dvd_languages;
            $Dvd->subtitles         = $request->dvd_subtitles;
            $Dvd->running_time      = ($request->dvd_running_time ? $request->dvd_running_time : $Film->running_time);
            $Dvd->description       = $request->dvd_description;
            $Dvd->dvd_status        = ($request->film_dvd_featured_switch ? 1 : 0);

            $Dvd->save();

            return response()->json(['errCode' => 0, 'messages' => 'DVD data successfully updated.']);
        }

        // no dvd id and this is for adding 
        
        $dvd_case_cover_ext = $request->dvd_case_cover->getClientOriginalExtension();
        $dvd_disc_image_ext = $request->dvd_case_cover->getClientOriginalExtension();
        $dvd_case_cover     = str_random(100) . '.' . $dvd_case_cover_ext;
        $dvd_disc_image     = str_random(100) . '.' . $dvd_disc_image_ext;

        $Dvd = new Dvd();

        $Dvd->name              = ($request->dvd_name ? $request->dvd_name : $Film->title . ' DVD');
        $Dvd->dvd_case_cover    = $dvd_case_cover;
        $Dvd->dvd_disc_image    = $dvd_disc_image;
        $Dvd->languages         = $request->dvd_languages;
        $Dvd->subtitles         = $request->dvd_subtitles;
        $Dvd->running_time      = ($request->dvd_running_time ? $request->dvd_running_time : $Film->running_time);
        $Dvd->description       = $request->dvd_description;
        $Dvd->dvd_status        = ($request->film_dvd_featured_switch ? 1 : 0);
        $Dvd->film_id           = $request->film_id;
        $Dvd->save();

        // save to dvd image storage
        $request->dvd_case_cover->move($public_path, $dvd_case_cover);
        $request->dvd_disc_image->move($public_path, $dvd_disc_image);


        return response()->json(['errCode' => 0, 'messages' => 'DVD data successfully added.']);
    }

    public function film_dvd_data_fetch ($id) 
    {
        $Dvd = Dvd::where('film_id', $id)->orderBy('dvd_order', 'ASC')->get();
        return view('cms.film.specific_film.partials.film_dvd_data_fetch', ['Dvd' => $Dvd])->render();
    }

    public function film_dvd_delete (Request $request)
    {
        if (!$request->id)
        {
            return response()->json(['errCode' => 2, 'messages' => 'Invalid selection of film DVD.']);
        }

        // path to dvd image storage
        $public_path = public_path('content/film/dvds/');
        $Dvd = Dvd::where(['id' => $request->id])->first();

        if (File::exists($public_path . $Dvd->dvd_case_cover))
        {
            File::delete(public_path('content/film/dvds/' . $Dvd->dvd_case_cover));
        }

        if (File::exists($public_path . $Dvd->dvd_disc_image))
        {
            File::delete(public_path('content/film/dvds/' . $Dvd->dvd_disc_image));
        }
        $Dvd->delete();
        return response()->json(['errCode' => 0, 'messages' => 'Film DVD data successfully deleted.']);
    }
}