<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarritoRequest;
use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Producto;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    # FUNCION PARA CREAR UN CARRITO
    public function store(StoreCarritoRequest $request){
        
        #VALIDAMOS LA INFORMACION MEDIANTE LA REQUEST
        $datosValidados = $request->validated();

        #CREAMOS EL CARRITO
        $carrito = Carrito::create($datosValidados);

        #DEVOLVEMOS LA RESPUESTA EN FORMATO JSON y UN 201
        return response()->json($carrito, 201);
    }

    #FUNCION PARA VACIAR EL CARRITO
    public function destroy(Carrito $carrito){

        #VALIDAMOS SI EL CARRITO EXISTE
        $existe_carrito = Carrito::findOrFail($carrito->id);
        if(!$existe_carrito){
            return response()->json([
                'message' => 'El carrito no existe.'
            ], 404);
        }
    
        #OBTENEMOS TODOS LOS ITEMS DEL CARRITO
        $items_carrito = CarritoItem::where('carrito_id', $carrito->id)->get();

        #VALIDAMOS SI HAY ITEMS EN EL CARRITO
        if($items_carrito->isEmpty()){
            return response()->json([
                'message' => 'El carrito esta vacio, no hay items para eliminar.'
            ],404);
        }

        #RECORREMOS CADA ITEM PARA RESTAURAR EL STOCK DEL PRODUCTO
        foreach($items_carrito as $item){
            $producto_db = Producto::findOrFail($item->producto_id);
            $producto_db->stock_producto += $item->cantidad_producto;
            $producto_db->save();
        }

        #ELIMINAMOS TODOS LOS ITEMS DEL CARRITO
        CarritoItem::where('carrito_id', $carrito->id)->delete();

        #RETORNAMOS UNA RESPUESTA EXITOSA
        return response()->json([
            'message' => 'Carrito vaciado exitosamente.'
        ], 200);
    }

    
}
