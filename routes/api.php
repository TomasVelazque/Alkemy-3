<?php

use App\Http\Controllers\Api\V1\CategoriaController;
use App\Http\Controllers\Api\V1\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

# -------------------------------

#RUTA CON LA VERSION 1 DE PREFIJO
Route::prefix('V1')->group(function(){
    
    # ---> PRODUCTOS <---

    #RUTA PARA BUSCAR TODOS LOS PRODUCTOS
    Route::get('/productos', [ProductoController::class, 'index']);

    #RUTA PARA MOSTRAR UN SOLO PRODUCTO
    Route::get('/productos/{producto}', [ProductoController::class, 'show']);

    #RUTA PARA CREAR UN PRODUCTO
    Route::post('/productos', [ProductoController::class, 'store']);

    #RUTA PARA ACTUALIZAR UN PRODUCTO
    Route::put('/productos/{producto}', [ProductoController::class, 'update']);

    #RUTA PARA ELIMINAR UN PRODUCTO
    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy']);

    # ---> CATEGORIAS <--

    #RUTA PARA LISTAR TODAS LAS CATEGORIAS
    Route::get('/categorias', [CategoriaController::class, 'index']);

    #RUTA PARA BUSCAR UNA SOLA CATEGORIA
    Route::get('/categorias/{categoria}', [CategoriaController::class, 'show']);

    #RUTA PARA CREAR UNA CATEGORIA
    Route::post('/categorias', [CategoriaController::class, 'store']);

    #RUTA PARA ACTUALIZAR UNA CATEGORIA
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update']);

    #RUTA PARA ELIMINAR UNA CATEGORIA
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy']);
});