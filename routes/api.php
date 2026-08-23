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

    #RUTA PARA LISTAR LOS ITEMS DEL CARRITO
    Route::get('/carrito-items/{carrito}', [CarritoItemController::class, 'index']);

    #RUTA PARA AGREGAR UN ITEM AL CARRITO
    Route::post('/carrito-items/{carrito}/create', [CarritoItemController::class, 'store']);

    #RUTA PARA ELIMINAR UN ITEM DEL CARRITO
    Route::post('/carrito-items/{carrito}/delete', [CarritoItemController::class, 'destroy']);

    #RUTA PARA LIMPIAR EL CARRITO
    Route::delete('/carrito-items/{carrito}/clear', [CarritoItemController::class, 'clear']);

    #---------------------------------------------------------------------------

    #---> ORDENES DE COMPRA<---

    #RUTAS MEDIANTE API RESOURCE PARA ORDENES DE COMPRA
    Route::apiResource('/ordenes', OrdenController::class);

});