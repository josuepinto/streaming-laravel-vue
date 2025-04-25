<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;

class Favourite extends Model
{
    use HasFactory;

    protected $fillable = ['movie_id'];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
    
}
