<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarritoItem extends Model
{
    # TABLA A LA QUE LE HACEMOS REFERENCIA
    protected $table = "carrito_items";

    # ESPECIFICAMOS QUE CAMPOS PERMITEN ASIGNACION MASIVA
    protected $fillable = [
        'carrito_id',
        'producto_id',
        'cantidad_producto',
        'precio_unitario'
    ];

    # ESPECIFICAMOS QUE CAMPOS NO SON DE ASIGNACION MASIVA
    protected $guarded = [
        'id'
    ];

    # RELACION CON EL CARRITO
    public function carrito(){
        return $this->belongsTo(Carrito::class, 'carrito_id');
    }

    # RELACION CON PRODUCTO
    public function producto(){
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
