<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = 'ordenes';

    protected $fillable = [
        'carrito_id',
        'subtotal',
        'impuestos',
        'total',
        'costo_envio',
        'direccion_envio',
        'metodo_pago',
        'confirmada',
    ];

    public function carrito()
    {
        return $this->belongsTo(Carrito::class);
    }
}
