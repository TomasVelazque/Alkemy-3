<?php

namespace Tests\Feature;

use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarritoItemApiTest extends TestCase
{
    use RefreshDatabase;

    # VALIDAMOS QUE UN USUARIO AUTENTICADO PUEDA AGREGAR PRODUCTOS A UN CARRITO
    public function test_un_usuario_autenticado_puede_agregar_un_producto_al_carrito(): void 
    {
        #ARRANGE: CREAMOS EL CARRITO, UN PRODUCTO Y UN USUARIO QUE INICIAR SESSION
        $usuario = User::factory()->create(['is_admin' => false]);
        $token = auth('api')->login($usuario);


        $carrito = Carrito::factory()->create(['user_id' => $usuario->id]);

        $producto = Producto::factory()->create(['stock_producto' => 6]);        
        
        #ACT: ENVIAMOS LA PETICION PARA AGREGAR AL CARRITO
        $response = $this->withToken($token)
        ->postJson("/api/V1/carritos/{$carrito->id}/items", [
            'producto_id' => $producto->id,
            'cantidad_producto' => 2,
        ]);

        #ASSERT: VALIDAMOS LO QUE SE DEBERIA RECIBIR Y SI SE QUEDO GUARDADO EN LA DB
        
        $response->assertOk()
        ->assertJsonPath('message', 'Item agregado al carrito exitosamente.')
        ->assertJsonPath('item.producto_id', $producto->id)
        ->assertJsonPath('item.cantidad_producto', 2);

        // Confirmamos que quedó guardado en la DB
        $this->assertDatabaseHas('carrito_items', [
            'carrito_id' => $carrito->id,
            'producto_id' => $producto->id,
            'cantidad_producto' => 2,
        ]);
    }

    # TEST PARA QUE UN USUARIO AUTENTICADO PUEDA QUITAR UN PRODUCTO DEL CARRITO
    public function test_un_usuario_puede_quitar_un_producto_de_su_carrito(): void 
    {
        #ARRANGE: CREAMOS EL CARRITO, UN PRODUCTO Y UN USUARIO QUE INICIAR SESSION
        $usuario = User::factory()->create(['is_admin' => false]);
        $token = auth('api')->login($usuario);

        $carrito = Carrito::factory()->create(['user_id' => $usuario->id]);

        $producto = Producto::factory()->create(['stock_producto' => 6]); 
        
        $item = CarritoItem::factory()->create(['producto_id' => $producto->id, 'carrito_id' => $carrito->id]);

        # ACT: MANDAMOS LA PETICION:
        $request = $this->withToken($token)->deleteJson("/api/V1/carritos/{$carrito->id}/items/{$producto->id}");

        #ASSERT: VALIDAMOS 
        $request->assertOk()
                ->assertJsonPath('message', 'Item eliminado del carrito exitosamente.');
    }

    #TEST DONDE UNA PERSONA NO AUTENTICADA NO PUEDE AGREGAR UN PRODUCTO AL CARRITO
    public function test_una_persona_no_autenticada_no_puede_agregar_un_producto_al_carrito(): void 
    {
        #ARRANGE: CREAMOS EL CARRITO, UN PRODUCTO Y UN USUARIO QUE NO INICIA SESSION
        $usuario = User::factory()->create(['is_admin' => false]);

        $carrito = Carrito::factory()->create(['user_id' => $usuario->id]);

        $producto = Producto::factory()->create(['stock_producto' => 6]);        
        
        #ACT: ENVIAMOS LA PETICION PARA AGREGAR AL CARRITO
        $response = $this->postJson("/api/V1/carritos/{$carrito->id}/items", [
            'producto_id' => $producto->id,
            'cantidad_producto' => 2,
        ]);

        # ASEERT: ESPERAMOS QUE NOS DE QUE NO ESTA AUTORIZADO
        $response->assertUnauthorized();
    }

    #TEST DONDE UNA PERSONA NO AUTENTICADA NO PUEDE ELIMINAR UN PRODUCTO DE UN CARRITO
    public function test_una_persona_no_autenticada_no_puede_eliminar_un_producto_del_carrito(): void 
    {
        #ARRANGE: CREAMOS EL CARRITO, UN PRODUCTO Y UN USUARIO QUE INICIAR SESSION
        $usuario = User::factory()->create(['is_admin' => false]);

        $carrito = Carrito::factory()->create(['user_id' => $usuario->id]);

        $producto = Producto::factory()->create(['stock_producto' => 6]); 

        $item = CarritoItem::factory()->create(['producto_id' => $producto->id, 'carrito_id' => $carrito->id]);
        
        # ACT: MANDAMOS LA PETICION:
        $request = $this->deleteJson("/api/V1/carritos/{$carrito->id}/items/{$producto->id}");

        #ASSERT: VALIDAMOS QUE NO DEBERIA ESTAR AUTORIZADO
        $request->assertUnauthorized();
    }
}
