<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = [
        'name',
        'color'
    ];

    public function movies(){
        return $this->belongsToMany(
            Movie::class,
            'genres_movie'
        );
    }

}
