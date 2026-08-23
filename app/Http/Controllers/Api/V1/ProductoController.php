<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Producto;
use App\DTO\ProductoDTO;
use App\Http\Resources\ProductoResource;
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
    public function store(StoreProductoRequest $request)
    {
        #VALIDAMOS LOS DATOS
        $datosValidados = $request->validated();

        # $productoDTO = new ProductoDTO(
        #     nombre_producto: $datosValidados['nombre_producto'],
        #     descripcion_producto: $datosValidados['descripcion_producto'] ?? null,
        #     precio_producto: (float) $datosValidados['precio_producto'],
        #     stock_producto: (int) $datosValidados['stock_producto'],
        #     categoria_id: (int) $datosValidados['categoria_id']
        # );

        $productoDTO = ProductoDTO::fromArray($datosValidados);

        #CREAMOS EL PRODUCTO
        $producto = Producto::create($productoDTO->toArray());

        #DEVOLVEMOS EN FORMATO JSON EL PRODUCTO CREADO
        return response()->json($producto);
    }

    # FUNCION PARA MOSTRAR UN PRODUCTO EN ESPECIFICO
    public function show(Producto $producto)
    {
        #BUSCAMOS EL PRODUCTO EN LA DB
        Producto::find($producto);

        #LO DEVOLVEMOS EN FORMATO JSON
        return response()->json($producto);
    }

    # FUNCION PARA ACTULIZAR UN PRODUCTO
    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        #VALIDAMOS LA INFORMACION 
        $datosValidados = $request->validated();
        
        #ACTUALIZAMOS EL PRODUCTO
        $producto->update($datosValidados);

        #RETORNAMOS EL PRODUCTO ACTUALIZADO
        return response()->json($producto);
    }

    # FUNCION PARA ELIMINAR UN PRODUCTO
    public function destroy(Producto $producto)
    {
        #ELIMINAMOS EL PRODUCTO QUE NOS LLEGA
        $producto->delete();

        #RETORNAMOS UN 200
        return response()->json(200);
    }
}
