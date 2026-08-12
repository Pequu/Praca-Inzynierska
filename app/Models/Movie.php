<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{

    protected $fillable = [
        'title',
        'description',
        'duration',
        'poster',
        'release_date',
        'age_rating'
    ];


    public function screenings(){
        return $this->hasMany(Screening::class);
    }

    public function genres(){
        return $this->belongsToMany(
            Genre::class,
            'genres_movie'
        );
    }


}
