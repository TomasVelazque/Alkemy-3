<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrdenRequest;
use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Orden;
use Illuminate\Http\Request;

class OrdenController extends Controller
{
    #METODO PARA CONFIRMAR LA ORDEN (COMPRA DEL CARRITO)
    public function store(StoreOrdenRequest $request){
        
        #VALIDAMOS LOS VALORES
        $datosValidados = $request->validated();

        #OBTENEMOS TODOS LOS ITEMS DEL CARRITO
        $items_carrito = CarritoItem::where('carrito_id', $datosValidados['carrito_id'])->get();

        #OBTENEMOS EL CARRITO
        $carrito = Carrito::where('id', $datosValidados['carrito_id'])->first();

        #VALIDAMOS QUE EL CARRITO NO HAYA SIDO CONFIRMADO ANTES
        if($carrito->estado == 'Confirmado'){
            return response()->json([
                'message' => 'Este carrito ya ha sido confirmado anteriormente.'
            ], 404);
        }

        #VALIDAMOS SI HAY ITEMS EN EL CARRITO
        if($items_carrito->isEmpty()){
            return response()->json([
                'message' => 'El carrito esta vacio, no hay items para eliminar.'
            ],404);
        }

        #VALIDAMOS SI TENEMOS STOCK SUFICIENTE PARA CADA ITEM DEL CARRITO
        foreach($items_carrito as $item){
            if($item->producto->stock_producto < $item->cantidad_producto){
                return response()->json([
                    'message' => 'No hay suficiente stock disponible para: ' . $item->producto->nombre_producto,
                    'stock_disponible' => $item->producto->stock_producto,
                ],404);
            }
        }

        #VALIDAMOS QUE EL PRECIO DEL CARRITO NO HAYA CAMBIADO DESDE QUE SE AGREGO EL ITEM AL CARRITO
        foreach($items_carrito as $item){
            if($item->producto->precio_producto != $item->precio_producto){
                $item->precio_producto = $item->producto->precio_producto;
                $item->save();
                return response()->json([
                    'message' => 'El precio del producto: ' . $item->producto->nombre_producto . 'cambio desde que se agrego al carrito. Por favor, revise su carrito antes de confirmar la orden.',
                    'nuevo_precio' => $item->producto->precio_producto,
                ],404);
            }
        }

        #SI HAY STOCK SUFICIENTE, REDUCIMOS EL STOCK DE CADA PRODUCTO
        foreach($items_carrito as $item){
            $item->producto->stock_producto -= $item->cantidad_producto;
            $item->producto->save();
        }


        #CALCULAMOS EL SUBTOTAL, IMPUESTOS, COSTO DE ENVIO Y TOTAL DE LA ORDEN
        $subtotal = 0;
        foreach($items_carrito as $item){
            $subtotal += $item->producto->precio_producto * $item->cantidad_producto;
        }

        $impuestos = $subtotal * 0.21;
        $costo_envio = 1500;
        $total = $subtotal + $impuestos + $costo_envio;

        #CREAMOS LA ORDEN EN LA BASE DE DATOS
        $orden = Orden::create([
            'carrito_id' => $carrito->id,
            'subtotal' => $subtotal,
            'impuestos' => $impuestos,
            'total' => $total,
            'costo_envio' => $costo_envio, 
            'direccion_envio' => $datosValidados['direccion_envio'],
            'metodo_pago' => $datosValidados['metodo_pago'],
            'confirmada' => true
        ]);

        #ACTUALIZAMOS EL ESTADO DEL CARRITO A CONFIRMADO
        $carrito->estado = 'Confirmado';
        $carrito->save();

        #RETORNAMOS LA ORDEN CREADA
        return response()->json([
            'message' => 'Orden confirmada exitosamente.',
            'orden' => $orden
        ], 201);
    }



    #FUNCION PARA MOSTRAR LOS DETALLES DE UNA ORDEN
    public function show($id){

        #BUSCAMOS LA ORDEN POR SU ID Y LA RETORNAMOS
        $orden = Orden::where('id', $id)->first();

        #VALIDAMOS SI LA ORDEN EXISTE
        if(!$orden){
            return response()->json([
                'message' => 'La orden no existe.'
            ], 404);
        }

        #RETORNAMOS LA ORDEN ENCONTRADA
        return response()->json([
            'orden' => $orden
        ], 200);
    }
}
