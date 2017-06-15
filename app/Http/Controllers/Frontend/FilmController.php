<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Film;

class FilmController extends Controller
{
    public function home(){
        return view('frontend.home');
    }
    public function films(){
        $Film = Film::where('release_status', 1)->get();
    	return view('frontend.films', ['Film' => $Film]);
    }
    public function about(){
    	return view('frontend.about');
    }
    public function contact(){
    	return view('frontend.contact');
    }
    public function film_info(){
        return view('frontend.film_info');
    }
    public function trailers(){
        return view('frontend.trailers');
    }
    public function on_dvd(){
    	return view('frontend.on_dvd');
    }
}