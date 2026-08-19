<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    # TABLA A LA QUE HACEMOS REFERENCIA
    protected $table = 'carritos';

    # ESPECIFICAMOS LOS CAMPOS QUE PERMITEN ASIGNACION MASIVA
    protected $fillable = [
        'user_id',
        'estado'
    ];
}