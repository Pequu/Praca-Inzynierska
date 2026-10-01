<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

    protected $fillable = [
        'user_id',
        'screening_id',
        'status',
        'total_price',

        'customer_name',
        'customer_surname',
        'customer_phone',
        'customer_email',

        'payment_method',

        'terms_accepted',
        'privacy_policy_accepted',
        'marketing_accepted',
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
