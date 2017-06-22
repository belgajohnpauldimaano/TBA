<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Film;
use App\Carousel;
use App\FilmCrew;

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
        ->orderBy('id', 'DESC')
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
                'quote' => function ($q) {
                    $q->select(['main_quote', 'name_of_person', 'url', 'film_id']);
                },
                'press_release'  => function ($q) {
                    $q->select(['id', 'title', 'article_image', 'blurb', 'content', 'film_id']);
                },
                'posters' => function ($q) {
                    $q->where('featured', 1);
                    $q->orWhere('featured', 0);
                    $q->select(['id', 'label', 'featured', 'poster_image_sorter', 'film_id']);
                },
                'trailers' => function ($q) {
                    $q->where('trailer_show', 1);
                    //$q->orWhere('featured', 0);
                    //$q->select(['id', 'label', 'featured', 'poster_image_sorter', 'film_id']);
                },
            ]
        )
        ->where('id', $request->id)->first();

        // echo json_encode($film_info->posters->where('featured', 1));
        // $a =  $film_info->posters->where('featured', 1);
        // echo $a;
        // return;
        return view('frontend.film_info', ['film_info' => $film_info]);
    }
    public function trailers(){
        return view('frontend.trailers');
    }
    public function on_dvd(){
    	return view('frontend.on_dvd');
    }
}