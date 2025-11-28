<?php

namespace App\Models;
use MongoDB\Laravel\Eloquent\Model;
class Profile extends Model
{
    
    protected $connection = 'mongodb';
    
    
    protected $collection = 'perfiles';

    
    protected $fillable = [
        'user_id',       
        'nombre_perfil',  
        'avatar_url',     
        'es_niño',        
    ];

    
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
