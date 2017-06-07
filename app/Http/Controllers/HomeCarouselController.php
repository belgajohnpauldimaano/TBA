<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use File;

use App\Carousel;
use App\Film;

class HomeCarouselController extends Controller
{
    public function index ()
    {
        $Carousel = Carousel::orderBy('carousels_sorter')->get();
        return view('cms.home_carousel.index', ['Carousel' => $Carousel, ]);
    }

    public function image_list ()
    {
        $Carousel = Carousel::orderBy('carousels_sorter')->get();
        return view('cms.home_carousel.partials.image_list', ['Carousel' => $Carousel])->render();
    }

    public function image_uploader_modal ()
    {
        $Carousel = Carousel::orderBy('carousels_sorter')->get();
        return view('cms.home_carousel.partials.upload_modal', ['Carousel' => $Carousel])->render();
    }

    public function image_upload_save (Request $request)
    {
        if($request->hasFile('photo'))
        {
            $validator = Validator::make($request->all(), [
                'photo' => 'required|mimes:png,jpeg'
            ],[
                'photo.required'  => 'Photo is required.',
                'photo.mimes'     => 'File format should be :png,jpeg.'
            ]);

            $filename = '';
            $Carousel = new Carousel();
            // foreach($request->file('photo') as $photo)
            // {
                $ext = $request->photo->getClientOriginalExtension();
                $filename = str_random(40) . '.' . $ext;
                $request->photo->move(public_path('content/carousel'), $filename);

                $Carousel->image = $filename;
                $Carousel->url = '';
                $Carousel->caption = '';
                $Carousel->save();
            //}
            $initialPreview = [
                asset('content/carousel').'/'.$filename
            ];
            $initialPreviewConfig = [
                ['caption' => "ss.fgasd", 'size' => 329892, 'width' => "120px", 'url' => route('image_delete'), 'key' => $Carousel->id, 'extra' => [' _token' => csrf_token() ] ]
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

    public function image_ordering (Request $request) 
    {
        foreach($request->order as $key => $val)
        {
            $Carousel = Carousel::where('id', $val)->first();
            $Carousel->carousels_sorter = $key + 1;
            $Carousel->save();
        }
    }

    public function image_detail_modal (Request $request)
    {
        $Carousel = Carousel::where('id', $request->id)->first();
        return view('cms.home_carousel.partials.image_detail_modal', ['Carousel' => $Carousel])->render();
    }

    public function save_image_details (Request $request)
    {
        $rules = [
            'image_id'  => 'required',
            //'caption'   => 'required|max:50',
            'url'       => 'url'
        ];
        $messages = [
            'image_id.required' => 'Invalid selection of image.',
            //'caption.required'  => 'Caption is required.',
            //'caption.min'       => 'Caption is minimum of 2 characters.',
            //'url.required'      => 'Url is required.',
            'url.url'           => 'Url is invalid format.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails())
        {
            return response()->json(['errCode' => 1, 'messages' => $validator->getMessageBag()]);
        }
        $Carousel           = Carousel::where('id', $request->image_id)->first();
        $Carousel->caption  = $request->caption;
        $Carousel->url      = $request->url;
        $Carousel->save();
        return response()->json(['errCode' => 0, 'messages' => 'Image details successfully updated.']);
    }

    public function image_delete (Request $request) 
    {
        $Carousel = Carousel::where('id', $request->key)->first();
        $Carousel->delete();
        
        File::delete(public_path('content\\film\\carousel\\' . $Carousel->image));

        $initialPreview = [
        ];
        $initialPreviewConfig = [
            []
        ];
        return response()->json([ 'initialPreview' => $initialPreview, 'initialPreviewConfig' => $initialPreviewConfig, 'initialPreviewThumbTags' => [], 'append' => true]);
    }


}
