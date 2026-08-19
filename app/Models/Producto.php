<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // TABLA A LA QUE HACEMOS REFERENCIA
    protected $table = 'productos';

    // ESPECIFICAMOS QUE CAMPOS SON DE ASIGNACION MASIVA
    protected $fillable = [
        'nombre_producto',
        'descripcion_producto',
        'precio_producto',
        'stock_producto',
        'categoria_id'
    ];

     // ESPECIFICAMOS QUE CAMPOS NO SON DE ASIGNACION MASIVA
    protected $guarded = [
        'id'
    ];

    //ESTABLECEMOS LA RELACION CON LAS CATEGORIAS
    public function categorias(){
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}