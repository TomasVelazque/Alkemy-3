<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // TABLA A LA QUE HACEMOS REFERENCIA
    protected $table = 'categorias';

    // ESPECIFICAMOS QUE CAMPOS SON DE ASIGNACION MASIVA
    protected $fillable = 
    [
        'nombre_categoria',
        'descripcion_categoria',  
    ];

    // ESPECIFICAMOS QUE CAMPOS NO SON DE ASIGNACION MASIVA
    protected $guarded = [
        'id'
    ];

    // RELACION CON PRODUCTO
    public function producto(){
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}