<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'genre_name',
        'color'
    ];

    public function movies(){
        return $this->belongsToMany(
            Movie::class,
            'genres_movie'
        );
    }

}
