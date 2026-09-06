<?php

namespace App\Services;

use App\DTO\StoreProductoDTO;
use App\DTO\UpdateProductoDTO;
use App\Models\Producto;

class ProductoService
{
    #FUNCION PARA CREAR EL PRODUCTO
    public function create(StoreProductoDTO $data): Producto
    {
        
        #CREAMOS EL PRODUCTO EN LA DB
        $producto = Producto::create($data->toArray());

        #CARGAMOS LA RELACION DE CATEGORIA PARA MOSTRARLA EN EL JSON
        $producto->load('categoria');

        #RETORNAMOS EL PRODUCTO CREADO
        return $producto;
    }

    #FUNCION PARA ACTUALIZAR UN PRODUCTO
    public function update(Producto $producto, UpdateProductoDTO $data): Producto
    {
        #VALIDAMOS SI HUBO CAMBIOS O NO
        if(!$data->hasChanges()){
            return $producto;
        }

        # SI HUBO CAMBIOS ACTUALIZAMOS EL PRODUCTO
        $producto->update($data->toArray());

        #CARGAMOS LA RELACION CON CATEGORIA
        $producto->load('categoria');

        #RETORNAMOS EL PRODUCTO ACTUALIZADO
        return $producto;
    }
}
