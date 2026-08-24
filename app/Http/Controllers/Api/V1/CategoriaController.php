<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;
use App\Services\CategoriaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoriaController extends Controller
{
    # FUNCION PARA BUSCAR TODAS LAS CATEGORIAS DE LA DB
    public function index(): AnonymousResourceCollection
    {
        #BUCAMOS LAS CATEGORIAS
        $categorias = Categoria::all();

        #DEVOLVEMOS LAS CATEGORIAS EN FORMATO JSON
        return CategoriaResource::collection($categorias);
    }

    # FUNCION PARA CREAR UNA CATEGORIA
    public function store(StoreCategoriaRequest $request, CategoriaService $categoriaService): JsonResponse
    {
    
        #LLAMAMOS AL SERVICIO PARA CREAR LA CATEGORIA
        $categoria = $categoriaService->create($request->toDto());

        #ENVIAMOS LA CATEGORIA EN FORMATO JSON
        return response()->json(new CategoriaResource($categoria), 201);
    }

    # FUNCION PARA MOSTRAR UNA SOLA CATEGORIA EN ESPECIFICO
    public function show(Categoria $categoria): CategoriaResource
    {
        #RETORNAMOS LA CATEGORIA A MOSTRAR
        return new CategoriaResource($categoria);
    }

    # FUNCION PARA EDITAR UNA CATEGORIA
    public function update(UpdateCategoriaRequest $request, Categoria $categoria, CategoriaService $categoriaService): JsonResponse
    {   
        #LLAMAMOS AL SERVICIO PARA ACTUALIZAR LA CATEGORIA
        $categoria = $categoriaService->update($categoria, $request->toDTO());

        #RETORNAMOS EN FORMATO JSON LA CATEGORIA ACTUALIZADA
        return CategoriaResource::make($categoria)->response()->setStatusCode(200);
    }

    # FUNCION PARA ELIMINAR UNA CATEGORIA
    public function destroy(Categoria $categoria): JsonResponse
    {
        #ELIMINAMOS LA CATEGORIA
        $categoria->delete();

        #ENVIAMOS UN 200
        return response()->json(null, 200);
    }
}
