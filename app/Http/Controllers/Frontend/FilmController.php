<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Film;
use App\Carousel;

class FilmController extends Controller
{
    public function home(){
        $Carousel = Carousel::orderBy('carousels_sorter', 'ASC')->get();
        return view('frontend.home', ['Carousel' => $Carousel, ]);
    }
    public function films(){
        $Film = Film::with(['photos' => function ($q) {
            $q->where('featured' , 1);
        }])->where('release_status', 1)->get();
        //return json_encode($Film);
    	return view('frontend.films', ['Film' => $Film]);
    }
    public function about(){
    	return view('frontend.about');
    }
    public function contact(){
    	return view('frontend.contact');
    }
    public function film_info(Request $request){
        $film_info = Film::with(
            [
                'photos' => function ($q) {
                    $q->where('featured' , 1);
                }
            ]
        )
        ->where('id', $request->id)->first();

        return view('frontend.film_info', ['film_info' => $film_info]);
    }
    public function trailers(){
        return view('frontend.trailers');
    }
    public function on_dvd(){
    	return view('frontend.on_dvd');
    }
}