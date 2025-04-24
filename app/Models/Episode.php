<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model {
    use HasFactory;

    protected $fillable = [
        'serie_id',
        'title',
        'season',
        'episode_number',
        'video_url',
        'image'
    ];
    
    public function serie() {
        return $this->belongsTo(Serie::class);
    }
}