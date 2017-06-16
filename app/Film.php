<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    const CURRENT_LINE_UP   = 1;
    const COMING_SOON       = 2;
    const FILM_CATALOGUE    = 3;

    const RELEASE_STATUS = ['','Current Line-up','Coming Soon','Film Catalogue'];

    const RATINGS = ['1'=>'G', '2'=>'PG', '3'=>'R-13', '4'=>'R-16', '5'=>'R-18', '6'=>'X'];
    
    const ROLE = [
        'DIRECTOR',
        'PRODUCER',
        'EXECUTIVE PRODUCER',
        'CAST',
        'WRITTEN BY',
        'DIRECTOR OF PHOTOGRAPHY',
        'PRODUCTION DESIGNER',
        'CO-EXECUTIVE PRODUCER',
        'SCREENPLAY BY',
        'EDITOR',
        'SOUND DESIGNER',
        'VFX',
        'STORY BY',
        'CINEMATOGRAPHY',
        'MUSIC BY',
        'DISTRIBUTED BY',
        'PRODUCTION DESIGNER FOR COSTUME',
    ];
    
    public function genre ()
    {
        return $this->belongsTo(Genre::class, 'genre_id', 'id');
    }

    public function trailers ()
    {
        return $this->hasMany(Trailer::class, 'film_id', 'id');
    }

    public function links ()
    {
        return $this->hasOne(RelatedLink::class, 'film_id', 'id');
    }

    public function film_crews ()
    {
        return $this->hasMany(FilmCrew::class, 'film_id', 'id');
    }

    public function photos ()
    {
        return $this->hasMany(Photo::class, 'film_id', 'id');
    }
}
