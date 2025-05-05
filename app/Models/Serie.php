<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    // En App\Models\Serie.php
public function episodes()
{
    return $this->hasMany(\App\Models\Episode::class);
}

}
