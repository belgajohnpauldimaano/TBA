<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FilmController extends Controller
{
    public function home(){
        return view('frontend.home');
    }
    public function films(){
    	return view('frontend.films');
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
}
