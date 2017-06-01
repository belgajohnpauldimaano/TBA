<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index () 
    {
        $Film = Film::with(['genre'])->get();
        return view('cms.film.index', ['Film' => $Film]);
    }
}
