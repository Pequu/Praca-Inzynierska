<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'reservation_id',
        'user_id',
        'screening_id',
        'seat_id',
        'qr_code',
        'status',
        'used_at',
        'ticket_price',
    ];

    protected $casts = [
        'used_at' => 'datetime',
        'ticket_price' => 'decimal:2',
    ];

    public function reservation()
    {
        return $this->belongsTo(
            Reservation::class
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }

    public function screening()
    {
        return $this->belongsTo(
            Screening::class
        );
    }

    public function seat()
    {
        return $this->belongsTo(
            Seat::class
        );
    }
}
