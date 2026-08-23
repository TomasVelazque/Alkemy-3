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

    # RELACION CON CARRITO ITEM
    public function carrito_items(){
        return $this->hasMany(CarritoItem::class);
    }

    # RELACION CON USUARIO
    public function user(){
        return $this->belongsTo(User::class);
    }

    # RELACION CON ORDEN
    public function orden(){
        return $this->hasOne(Orden::class);
    }
}