<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{

    protected $fillable = [
        'room_id',
        'row',
        'number',
        'x',
        'y',
        'type',
        'group_id',
    ];


    public function room()
    {
        return $this->belongsTo(Room::class);
    }


    public function reservationSeats()
    {
        return $this->hasMany(
            ReservationSeat::class
        );
    }

}
