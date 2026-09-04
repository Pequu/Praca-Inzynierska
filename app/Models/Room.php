<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Seat;

class Room extends Model
{

    protected $fillable = [
    'room_name',
    'capacity',
    'description',
    'room_rows',
    'room_columns',
    'color',
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
