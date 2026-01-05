<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Profile extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'profiles';

    protected $fillable = [
        'user_id',
        'nombre_perfil',
        'avatar_url',
        'es_niño'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'es_niño' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
