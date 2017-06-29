<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dvd extends Model
{
    public function film ()
    {
        return $this->hasOne(Film::class, 'id', 'film_id');
    }
}