<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{

    protected $fillable = [
        'room_name',
        'capacity',
        'color'
    ];


    public function seats()
    {
        return $this->hasMany(Seat::class);
    }


    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }

}
