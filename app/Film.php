<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    const CURRENT_LINE_UP   = 1;
    const COMING_SOON       = 2;
    const FILM_CATALOGUE    = 3;

    const RELEASE_STATUS = ['Current Line-up','Comming Soon','Film Catalogue'];
    public function genre ()
    {
        return $this->belongsTo(Genre::class, 'genre_id', 'id');
    }
}
