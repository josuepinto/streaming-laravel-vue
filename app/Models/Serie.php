<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Episode;
use App\Models\Favourite;

class Serie extends Model
{
    use HasFactory;

    // define the columns of series table
    protected $fillable = [
        'image',
        'name',
        'desc',
        'actor',
        'director',
        'video_url',
        'num_episode'
    ];

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favouritable');
    }


}
