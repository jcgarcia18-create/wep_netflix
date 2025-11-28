<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Peliculas extends Model 
{
    use HasFactory;

    
  
    protected $table = 'peliculas'; 

    

    protected $fillable = [
        'title', 
        'description', 
        'poster_url', 
        'video_url', 
        'duration_minutes', 
        'genre',
    ];
}
