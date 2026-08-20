<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarritoRequest;
use App\Models\Carrito;
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

    
}
