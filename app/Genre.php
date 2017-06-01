<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public function film ()
    {
        //return $this->hasOne(Genre::class, 'id', 'genre_id');
    }
}
