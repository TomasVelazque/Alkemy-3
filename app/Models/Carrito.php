<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    // TABLA A LA QUE HACEMOS REFERENCIA
    protected $table = 'carrito';

    // ESPECIFICAMOS LOS CAMPOS QUE PERMITEN ASIGNACION MASIVA
    protected $fillable = [
        
    ];

    // ESPECIFICAMOS LOS CAMPOS QUE NO SON DE ASIGNACION MASIVA
    protected $guarded = [
        'id'
    ];
}