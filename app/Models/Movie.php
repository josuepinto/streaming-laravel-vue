<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Favourite;

class Movie extends Model
{
    use HasFactory;
     protected $fillable = [
        'title',
        'description',
        'actor', 
        'director',
        'year', 
        'genre', 
        'image', 
        'video_url'
    ];

    public function favourites()
    {
         return $this->morphMany(Favourite::class, 'favouritable');
    }

}