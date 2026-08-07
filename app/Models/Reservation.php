<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

    protected $fillable = [
        'user_id',
        'screening_id',
        'status',
        'total_price'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function screening()
    {
        return $this->belongsTo(Screening::class);
    }


    public function reservationSeats()
    {
        return $this->hasMany(
            ReservationSeat::class
        );
    }

}
