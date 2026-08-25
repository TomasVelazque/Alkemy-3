<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarritoItemRequest;
use App\Http\Requests\UpdateCarritoItemRequest;
use App\Models\Producto;
use App\Models\Carrito;
use App\Models\CarritoItem;

use Illuminate\Http\Request;

class CarritoItemController extends Controller
{

    #FUNCION PARA LISTAR LOS ITEMS DEL CARRITO
    public function index(Carrito $carrito){
        
        #VALIDAMOS SI EL CARRITO EXISTE
        $existe_carrito = Carrito::findOrFail($carrito->id);
        if(!$existe_carrito){
            return response()->json([
                'message' => 'El carrito no existe.'
            ], 404);
        }

        #OBTENEMOS TODOS LOS ITEMS DEL CARRITO
        $items_carrito = CarritoItem::where('carrito_id', $carrito->id)->get();

        #RETORNAMOS LOS ITEMS EN FORMATO JSON
        return response()->json($items_carrito);
    }

    #FUNCION PARA AGREGAR UN ITEM AL CARRITO
    public function store(StoreCarritoItemRequest $request, Carrito $carrito){

        #VALIDAMOS LOS DATOS ENVIADOS MEDIANTE EL REQUEST
        $infoValidada = $request->validated();

        #BUSCAMOS EL PRODUCTO EN LA BASE DE DATOS
        $producto_db = Producto::findOrFail($infoValidada['producto_id']);

        #VALIDAMOS SI TENEMOS STOCK SUFICIENTE PARA AGREGAR EL ITEM AL CARRITO
        if($producto_db->stock_producto < $infoValidada['cantidad_producto']){
            return response()->json([
                'message' => 'No hay suficiente stock para agregar este producto al carrito.',
                'stock_disponible' => $producto_db->stock_producto
            ],404);
        }

        #VALIDAMOS SI EXISTE EN EL CARRITO ITEMS
        $item = CarritoItem::where('carrito_id', $carrito->id)
                                    ->where('producto_id', $producto_db->id)
                                    ->first();

        #SI EL ITEM EXISTE INCREMENTAMOS LA CANTIDAD
        if($item){
            $item->cantidad_producto += $infoValidada['cantidad_producto'];
            $item->save();
        }else{
            # SINO CREAMOS UN NUEVO ITEM EN EL CARRITO
            $item = CarritoItem::create([
                'carrito_id' => $carrito->id,
                'producto_id' => $infoValidada['producto_id'],
                'cantidad_producto' => $infoValidada['cantidad_producto'],
                'precio_unitario' => $producto_db->precio_producto,
            ]);
        }

        #RETORNAMOS UNA RESPUESTA EXITOSA
        return response()->json([
            'message' => 'Item agregado al carrito exitosamente.',
            'item' => $item
        ], 200);
    }

    #FUNCION PARA ELIMINAR UN ITEM DEL CARRITO
    public function destroy(Carrito $carrito, Producto $producto){

        #VALIDAMOS QUE EL PRODUCTO EXISTA EN EL CARRITO
        $item_carrito = CarritoItem::where('carrito_id', $carrito->id)
                                    ->where('producto_id', $producto->id)
                                    ->first();

        if(!$item_carrito){
            return response()->json([
                'message' => 'El producto a eliminar no existe en el carrito.'
            ], 404);
        }

        #ELIMINAMOS EL ITEM DEL CARRITO
        $item_carrito->delete();

        #MANDAMOS UNA RESPUESTA EXITOSA
        return response()->json([
            'message' => 'Item eliminado del carrito exitosamente.'
        ], 200);
    }

    #FUNCION PARA ACTUALIZAR LA CANTIDAD DE X PRODUCTO DE NUESTRO CARRITO
    public function update(UpdateCarritoItemRequest $request, Carrito $carrito, Producto $producto)
    {   
        $datosValidados = $request->validated();

        $item_carrito = CarritoItem::where('carrito_id', $carrito->id)
                                    ->where('producto_id', $producto->id)
                                    ->first();

         if(!$item_carrito){
            return response()->json([
                'message' => 'El producto no existe en el carrito.'
            ], 404);
        }

        #VALIDAMOS EL STOCK
        $producto_db = Producto::where('id', $producto->id)->first();

        if($producto_db->stock_producto < $datosValidados['cantidad_producto']){
            return response()->json([
                'message' => 'No hay suficiente stock del producto: ' . $producto_db->nombre_producto,
                'stock_disponible' => $producto_db->stock_producto
            ]);
        }

        $item_carrito->update([
            'cantidad_producto' => $datosValidados['cantidad_producto'],
        ]);

        return response()->json($item_carrito, 200);
    }
}
