<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

 class FilmCrew extends Model
{
    const ROLE = [
        '1' => 'DIRECTOR',
        '2' => 'CAST',
        '3' => 'WRITTEN BY',
        '4' => 'PRODUCER',
        '5' => 'EXECUTIVE PRODUCER',
        '6' => 'CO-EXECUTIVE PRODUCER',
        '7' => 'DIRECTOR OF PHOTOGRAPHY',
        '8' => 'SCREENPLAY BY',
        '9' => 'STORY BY',
        '10' => 'CINEMATOGRAPHY',
        '11' => 'PRODUCTION DESIGNER',
        '12' => 'PRODUCTION DESIGNER FOR COSTUME',
        '13' => 'EDITOR',
        '14' => 'MUSIC BY',
        '15' => 'SOUND DESIGNER',
        '16' => 'VFX',
        '17' => 'DISTRIBUTED BY',
    ];

    public function person ()
    {
        return $this->hasOne(Person::class, 'id', 'people_id');
    }

    public function people ()
    {
        return $this->belongsTo(Person::class, 'id', 'people_id');
    }
}
