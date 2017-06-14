<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

 class FilmCrew extends Model
{
    const ROLE = [
        '1' => 'DIRECTOR',
        '2' => 'PRODUCER',
        '3' => 'EXECUTIVE PRODUCER',
        '4' => 'CAST',
        '5' => 'WRITTEN BY',
        '6' => 'DIRECTOR OF PHOTOGRAPHY',
        '7' => 'PRODUCTION DESIGNER',
        '8' => 'CO-EXECUTIVE PRODUCER',
        '9' => 'SCREENPLAY BY',
        '10' => 'EDITOR',
        '11' => 'SOUND DESIGNER',
        '12' => 'VFX',
        '13' => 'STORY BY',
        '14' => 'CINEMATOGRAPHY',
        '15' => 'MUSIC BY',
        '16' => 'DISTRIBUTED BY',
        '17' => 'PRODUCTION DESIGNER FOR COSTUME',
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
