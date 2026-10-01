<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Screening extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'room_id',
        'start_time',
        'screening_price'
    ];


    protected $casts = [
        'start_time' => 'datetime'
    ];


    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }


    public function room()
    {
        return $this->belongsTo(Room::class);
    }


    public function reservations()
    {
        return $this->hasMany(
            Reservation::class
        );
    }

}
