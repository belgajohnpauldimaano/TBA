<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public function film_crews ()
    {
        return $this->hasMany(FilmCrew::class, 'people_id', 'id');
    }
}
