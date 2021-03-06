<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    const CURRENT_LINE_UP   = 1;
    const COMING_SOON       = 2;
    const FILM_CATALOGUE    = 3;

    const RELEASE_STATUS = ['','Current Line-up','Coming Soon','Film Catalogue'];

    const RELEASE_STATUS_STYLE = [
        '0' => 'bg-gray',
        '1' => 'bg-aqua',
        '2' => 'bg-purple',
        '3' => 'bg-blue',
    ];

    const RATINGS = ['1'=>'G', '2'=>'PG', '3'=>'R-13', '4'=>'R-16', '5'=>'R-18', '6'=>'X'];
    
    const RATING_STYLE = [
        '1' => 'bg-green',
        '2' => 'bg-blue',
        '3' => 'bg-yellow',
        '4' => 'bg-orange',
        '5' => 'bg-red',
        '6' => 'bg-black'
    ];
    
    const ROLE = [
        'DIRECTOR',
        'CAST',
        'WRITTEN BY',
        'PRODUCER',
        'EXECUTIVE PRODUCER',
        'CO-EXECUTIVE PRODUCER',
        'DIRECTOR OF PHOTOGRAPHY',
        'SCREENPLAY BY',
        'STORY BY',
        'CINEMATOGRAPHY',
        'PRODUCTION DESIGNER',
        'PRODUCTION DESIGNER FOR COSTUME',
        'EDITOR',
        'MUSIC BY',
        'SOUND DESIGNER',
        'VFX',
        'DISTRIBUTED BY',
    ];
    
    public function genre ()
    {
        return $this->belongsTo(Genre::class, 'genre_id', 'id');
    }

    public function trailers ()
    {
        return $this->hasOne(Trailer::class, 'film_id', 'id');
    }

    public function links ()
    {
        return $this->hasOne(RelatedLink::class, 'film_id', 'id');
    }

    public function film_crews ()
    {
        return $this->hasMany(FilmCrew::class, 'film_id', 'id');
    }

    public function posters ()
    {
        return $this->hasMany(Poster::class, 'film_id', 'id');
    }

    public function photos ()
    {
        return $this->hasMany(Photo::class, 'film_id', 'id');
    }

    public function awards ()
    {
        return $this->hasMany(Award::class, 'film_id', 'id');
    }
    
    public function quotes ()
    {
        return $this->hasMany(Quote::class, 'film_id', 'id');
    }
    
    public function press_release ()
    {
        return $this->hasOne(PressRelease::class, 'film_id', 'id');
    }
    
    public function dvds ()
    {
        return $this->hasMany(Dvd::class, 'film_id', 'id');
    }
}
