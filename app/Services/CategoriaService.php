<?php

namespace App\Services;

use App\DTO\StoreCategoriaDTO;
use App\DTO\UpdateCategoriaDTO;
use App\Models\Categoria;

class CategoriaService
{
    #FUNCION PARA CREAR UNA CATEGORIA
    public function create(StoreCategoriaDTO $data): Categoria
    {
        #CREAMOS LA CATEGORIA EN LA DB
        $categoria = Categoria::create($data->toArray());

        #RETORNAMOS LA CATEGORIA CREADA
        return $categoria;
    }

    #FUNCION PARA ACTUALIZAR UNA CATEGORIA
    public function update(Categoria $categoria, UpdateCategoriaDTO $data): Categoria
    {
        #VALIDAMOS SI SE REALIZARON CAMBIOS
        if(!$data->hasChanges())
        {
            return $categoria;
        }

        #SI HUBO CAMBIOS ACTUALIZAMOS LA CATEGORIA
        $categoria->update($data->toArray());

        #DEVOLVEMOS LA CATEGORIA ACTUALIZADA
        return $categoria;
    }
}
