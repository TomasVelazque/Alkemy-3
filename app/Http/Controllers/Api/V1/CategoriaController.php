<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    # FUNCION PARA BUSCAR TODAS LAS CATEGORIAS DE LA DB
    public function index()
    {
        #BUCAMOS LAS CATEGORIAS
        $categorias = Categoria::all();

        #DEVOLVEMOS LAS CATEGORIAS EN FORMATO JSON
        return response()->json($categorias);
    }

    # FUNCION PARA CREAR UNA CATEGORIA
    public function store(StoreCategoriaRequest $request)
    {
        #VALIDAMOS LA INFORMACION QUE NOS LLEGA
        $datosValidados = $request->validated();

        #CREAMOS LA CATEGORIA
        $categoria = Categoria::create($datosValidados);

        #ENVIAMOS LA CATEGORIA EN FORMATO JSON
        return response()->json($categoria);
    }

    # FUNCION PARA MOSTRAR UNA SOLA CATEGORIA EN ESPECIFICO
    public function show(Categoria $categoria)
    {
        #BUSCAMOS LA CATEGORIA QUE NOS ENVIAN EN LA DB
        Categoria::find($categoria);

        #RETORNAMOS LA CATEGORIA
        return response()->json($categoria);
    }

    # FUNCION PARA EDITAR UNA CATEGORIA
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        #VALIDAMOS LA INFORMACION ENTRANTE
        $datosValidados = $request->validated();

        #ACTUALIZAMOS LA CATEGORIA
        $categoria->update($datosValidados);

        #RETORNAMOS EN FORMATO JSON LA CATEGORIA ACTUALIZADA
        return response()->json($categoria);
    }

    # FUNCION PARA ELIMINAR UNA CATEGORIA
    public function destroy(Categoria $categoria)
    {
        #ELIMINAMOS LA CATEGORIA
        $categoria->delete();

        #ENVIAMOS UN 200
        return response()->json(200);
    }
}
