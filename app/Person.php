<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
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
}
