<?php

use App\Http\Controllers\Api\V1\CarritoController;
use App\Http\Controllers\Api\V1\CategoriaController;
use App\Http\Controllers\Api\V1\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CarritoItemController;
use App\Http\Controllers\Api\V1\OrdenController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

# -------------------------------

#RUTA CON LA VERSION 1 DE PREFIJO
Route::prefix('V1')->group(function(){
    
    # ---> PRODUCTOS <---

    #RUTA MEDIANTE API RESOURCE PARA PRODUCTOS
    Route::apiResource('/productos', ProductoController::class);

    #---------------------------------------------------------------------------

    # ---> CATEGORIAS <--
    
    #RUTA MEDIANTE API RESOURCE PARA CATEGORIAS
    Route::apiResource('/categorias', CategoriaController::class);

    #---------------------------------------------------------------------------

    # ---> CARRITO <--

    #RUTAS MEDIANTE API RESOURSE PARA CARRITO
    Route::apiResource('/carritos', CarritoController::class);

    #---------------------------------------------------------------------------

    # ---> ITEMS DEL CARRITO <---
    Route::apiResource('carritos.items', CarritoItemController::class)
        ->parameters(['items' => 'producto'])
        ->only(['index','store', 'destroy', 'update']);

    #---------------------------------------------------------------------------

    #---> ORDENES DE COMPRA<---

    #RUTAS MEDIANTE API RESOURCE PARA ORDENES DE COMPRA
    Route::apiResource('/ordenes', OrdenController::class);

});