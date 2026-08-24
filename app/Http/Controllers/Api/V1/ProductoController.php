<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Producto;
use App\DTO\ProductoDTO;
use App\Http\Resources\ProductoResource;
use App\Services\ProductoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductoController extends Controller
{
    # FUNCION PARA MOSTRAR TODOS LOS PRODUCTOS DE LA DB
    public function index(): AnonymousResourceCollection
    {
        #TOMAMOS TODOS LOS PRODUCTOS
        $productos = Producto::with('categoria')->get();

        #RETORNAMOS EN FORMATO JSON
        return ProductoResource::collection($productos);
    }

    # FUNCION PARA CREAR UN PRODUCTO
    public function store(StoreProductoRequest $request, ProductoService $productoService):JsonResponse
    {
        #LLAMAMOS AL SERVICE PARA CREAR EL PRODUCTO
        $producto = $productoService->create($request->toDTO());

        #DEVOLVEMOS EN FORMATO JSON EL PRODUCTO CREADO
        return response()->json(new ProductoResource($producto), 201);
    }

    # FUNCION PARA MOSTRAR UN PRODUCTO EN ESPECIFICO
    public function show(Producto $producto):ProductoResource
    {
        #CARGAMOS LA RELACION CON LA CATEGORIA PARA QUE SE MUESTRE
        $producto->load('categoria');

        #DEVOLVEMOS EL PRODUCTO A MOSTRAR
        return new ProductoResource($producto);
    }

    # FUNCION PARA ACTULIZAR UN PRODUCTO
    public function update(UpdateProductoRequest $request, Producto $producto, ProductoService $productoService): JsonResponse
    {
        #LLAMAMOS AL SERVICE PARA ACTUALIZAR EL PRODUCTO
        $producto = $productoService->update($producto, $request->toDTO());

        #RETORNAMOS EL PRODUCTO ACTUALIZADO
        return ProductoResource::make($producto)->response()->setStatusCode(200);
    }

    # FUNCION PARA ELIMINAR UN PRODUCTO
    public function destroy(Producto $producto): JsonResponse
    {
        #ELIMINAMOS EL PRODUCTO QUE NOS LLEGA
        $producto->delete();

        #RETORNAMOS UN 200
        return response()->json(null, 200);
    }
}
