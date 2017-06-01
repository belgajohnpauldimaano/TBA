<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    public function genre ()
    {
        return $this->belongsTo(Genre::class, 'genre_id', 'id');
    }
}
