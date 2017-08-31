<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Film;
use App\Carousel;
use App\FilmCrew;
use App\Dvd;
use App\PressRelease;

class FilmController extends Controller
{
    public function home(){
        $Carousel = Carousel::orderBy('carousels_sorter', 'ASC')->get();
        return view('frontend.home', ['Carousel' => $Carousel, ]);
    }
    public function films(){
        $Film = Film::with(
            ['photos' => function ($q) {
                $q->where('featured' , 1);
            }
        ])
        ->where('release_status', '<>', NULL)
        ->orderBy('title', 'ASC')
        ->get();

        $f = $Film->where('release_status', 1);
        // return dd($Film);
                    
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
                'trailers' => function ($q) {
                    //$q->where('trailer_show' , 1);
                    $q->orderBy('trailer_show', 'ASC');
                    $q->orderBy('trailer_image_sorter', 'ASC');
                },
                'photos' => function ($q) {
                    $q->where('featured' , 1);
                },
                'film_crews.person',
                'links',
                'awards' => function ($q) {
                    $q->orderBy('award_image_sorter', 'ASC');
                    $q->select(['award_name', 'award_image', 'film_id', 'award_image_sorter']);
                },
                'photos' => function ($q) {
                    $q->where('thumb_filename', '!=' , NULL);
                    $q->orderBy('photo_sorter', 'ASC');
                    $q->select(['title', 'filename', 'thumb_filename', 'film_id', 'photo_sorter']);
                },
                'quotes' => function ($q) {
                    $q->select(['main_quote', 'name_of_person', 'url', 'film_id']);
                },
                'press_release'  => function ($q) {
                    $q->select(['id', 'title', 'article_image', 'blurb', 'content', 'film_id']);
                },
                'posters' => function ($q) {
                    $q->where('featured', 1);
                    $q->orWhere('featured', 0);
                    $q->select(['id', 'label', 'featured', 'poster_image_sorter', 'film_id']);
                }
            ]
        )
        ->where('id', $request->id)->first();

        $press_release = PressRelease::where('film_id', $request->id)->get();

        // echo json_encode($film_info->posters->where('featured', 1));
        // $a =  $film_info->posters->where('featured', 1);
        // echo $a;
        // return;
        return view('frontend.film_info', ['film_info' => $film_info, 'press_release' => $press_release]);
    }
    public function trailers(){
        $film_trailer = Film::with(
            [
                'trailers' => function ($q) {
                    $q->orderBy('trailer_show', 'ASC');
                    $q->orderBy('trailer_image_sorter', 'ASC');
                }
            ]
        )
        //->where('release_status', 1)
        ->get();

        return view('frontend.trailers', ['film_trailer' => $film_trailer]);
    }
    public function on_dvd(){

        $dvds = Dvd::with(['film' => function ($q) {
            $q->select(['id', 'english_title']);
        }])
        ->orderBy('name', 'ASC')
        ->orderBy('dvd_order', 'ASC')
        ->get();
        return view('frontend.on_dvd', ['dvds' => $dvds]);
        
    }
}