<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrdenRequest;
use App\Http\Resources\OrdenResource;
use App\Http\Resources\ProductoResource;
use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Orden;
use App\Models\Producto;
use App\Services\OrdenService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrdenController extends Controller
{
    #METODO PARA CONFIRMAR LA ORDEN (COMPRA DEL CARRITO)
    public function store(StoreOrdenRequest $request, OrdenService $ordenService): JsonResponse
    {
        try{
            #LLAMAMOS AL SERVICIO PARA CREAR LA ORDEN
            $orden = $ordenService->create($request->toDto());

            #RETORNAMOS LA ORDEN CREADA EN JSON
            return response()->json(new OrdenResource($orden), 201);
        }
        catch(Exception $e)
        {
            // SI ALGO FALLO AL CREARSE MOSTRAMOS LA EXCEPCION CON SU MENSAJE DE ERROR.
            return response()->json([
                'message' => $e->getMessage(),
            ], 404);
        }
    }



    #FUNCION PARA MOSTRAR LOS DETALLES DE UNA ORDEN
    public function show(Orden $orden):OrdenResource
    {
        #CARGAMOS LA RELACION CON EL CARRITO
        $orden->load('carrito');

        #RETORNAMOS LA ORDEN ENCONTRADA
        return new OrdenResource($orden);
    }
}
