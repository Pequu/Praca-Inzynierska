<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $fillable = [
        'reservation_id',
        'ticket_code'
    ];


    public function reservation()
    {
        return $this->belongsTo(
            Reservation::class
        );
    }

}
