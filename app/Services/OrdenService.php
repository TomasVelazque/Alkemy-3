<?php

namespace App\Services;

use App\DTO\StoreOrdenDTO;
use App\Models\Carrito;
use App\Models\Orden;
use InvalidArgumentException;

class OrdenService
{
    #FUNCION PARA CREAR UNA ORDEN
    public function create(StoreOrdenDTO $data): Orden 
    {
        #BUSCAMOS EL CARRITO CON SUS ITEMS
        $carrito = Carrito::with('carrito_items.producto')->findOrFail($data->carrito_id);
        
        #VALIDAMOS QUE LA ORDEN NO SE HAYA CONFIRMADO ANTES
        if($carrito->estado === 'Confirmado'){
            throw new InvalidArgumentException("Este carrito ya ha sido confirmado anteriormente.");
        }

        #VALIDAMOS SI HAY ITEMS EN EL CARRITO
        if($carrito->carrito_items->isEmpty()){
            throw new InvalidArgumentException("El carrito se encuentra vacio.");
        }

        #VALIDAMOS SI TENEMOS STOCK SUFICIENTE PARA CADA ITEM DEL CARRITO Y SI CAMBIO EL PRECIO
        foreach($carrito->carrito_items as $item){
            
            if($item->producto->stock_producto < $item->cantidad_producto){
                throw new InvalidArgumentException("No hay suficiente stock para: {$item->producto->nombre_producto}");
            }

            if($item->precio_unitario != $item->producto->precio_producto){
                throw new InvalidArgumentException("El precio del producto {$item->producto->nombre} ha cambiado, revise el carrito nuevamente.");
            }
        }

        #DESCONTAMOS EL STOCK
        foreach($carrito->carrito_items as $item){
            $item->producto->stock_producto -= $item->cantidad_producto;
            $item->producto->save();
        }

        #CALCULAMOS EL SUBTOTAL, IMPUESTOS, COSTO DE ENVIO Y TOTAL DE LA ORDEN
        $subtotal = 0;
        foreach($carrito->carrito_items as $item){
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
            'direccion_envio' => $data->direccion_envio,
            'metodo_pago' => $data->metodo_pago,
            'confirmada' => true
        ]);

        #ACTUALIZAMOS EL ESTADO DEL CARRITO A CONFIRMADO
        $carrito->estado = 'Confirmado';
        $carrito->save();

        #DEVOLVEMOS LA ORDEN CREADA
        return $orden;
    }
}
