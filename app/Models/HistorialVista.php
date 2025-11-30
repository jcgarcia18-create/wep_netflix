<?php

namespace App\Models;


use MongoDB\Laravel\Eloquent\Model;

class HistorialVista extends Model
{

   
    protected $connection = 'mongodb';
    

    protected $collection = 'historial_vistas';

  
    public $timestamps = true; 

 
    protected $fillable = [
        'perfil_id',      
        'pelicula_id',    
        'nombre_pelicula',
    ];
}
