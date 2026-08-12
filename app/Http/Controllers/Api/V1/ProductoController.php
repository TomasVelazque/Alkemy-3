<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    # FUNCION PARA MOSTRAR TODOS LOS PRODUCTOS DE LA DB
    public function index()
    {
        #TOMAMOS TODOS LOS PRODUCTOS
        $productos = Producto::all();

        #RETORNAMOS EN FORMATO JSON
        return response()->json($productos);
    }

    # FUNCION PARA CREAR UN PRODUCTO
    public function store(StoreProductoRequest $request)
    {
        #VALIDAMOS LOS DATOS
        $datosValidados = $request->validated();

        #CREAMOS EL PRODUCTO
        $producto = Producto::create($datosValidados);

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
