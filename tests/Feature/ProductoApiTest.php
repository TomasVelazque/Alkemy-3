<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function Pest\Laravel\getJson;

class ProductoApiTest extends TestCase
{
    use RefreshDatabase;

    #TEST PARA VERFICAR QUE TODOS LOS PUEDAN LISTAR LOS PRODUCTOS
    public function test_cualquiera_puede_listar_los_productos(): void 
    {
        #ARRANGE: CREAMOS PRODUCTOS EN LA DB MEDIANTE EL FACTORY
        Producto::factory()->count(3)->create();

        #ACT: MANDAMOS LA SOLICITUD 
        $response = $this->getJson('/api/V1/productos');

        #ASSERT: VALIDAMOS LA RESPUESTA
        $response->assertOk();
    }

    #TEST PARA VERIFICAR QUE UN ADMIN PUEDA CREAR UN PRODUCTO
    public function test_un_admin_puede_crear_un_producto(): void 
    {
        #ARRANGE: CREAMOS EL PRODUCTO, CATEGORIA Y EL USUARIO PARA LA PRUEBA CON LA SESSION INICIADA

        $admin = User::factory()->create(['is_admin' => true]);

        $token = auth('api')->login($admin);

        $categoria = Categoria::factory()->create();

        $producto = [
            'nombre_producto' => 'Producto Test',
            'descripcion_producto' => 'Descripcion test',
            'stock_producto' => 17,
            'precio_producto' => 1500,
            'categoria_id' => $categoria->id,
        ];

        # ACT: ENVIAMOS LA PETICION
        $request = $this->postJson('/api/V1/productos', $producto);

        # ASSERT: VALIDAMOS QUE EL PRODUCTO SE HAYA CREADO
        $request->assertCreated();
    }

    #TEST PARA VERIFICAR QUE UNA PERSONA QUE NO ES ADMIN NO PUEDA CREAR UN USUARIO
    public function test_un_usuario_normal_no_puede_crear_un_producto(): void 
    {
        #ARRANGE: CREAMOS EL USUARIO, CATEGORIA, PRODUCTO Y INICIAMOS SESSION
        User::factory()->create(['is_admin' => false]);

        $categoria = Categoria::factory()->create();

        $producto = [
            'nombre_producto' => 'Producto de Prueba',
            'descripcion_producto' => 'Descripcion de prueba',
            'precio_producto' => 1000,
            'stock_producto' => 13,
            'categoria_id' => $categoria->id,
        ];

        # ACT: ENVIAMOS LA SOLICITUD
        $request = $this->postJson('/api/V1/productos', $producto);

        # ASSERT: VALIDAMOS QUE ESTO NO SE PUEDA REALIZAR Y ESTE NO AUTORIZADO
        $request->assertUnauthorized();
    }

    #TEST PARA QUE UNA PERSONA NO AUTENTICADA PUEDA CREAR UN PRODUCTO
    public function test_una_persona_sin_token_no_puede_crear_un_producto(): void 
    {
        # ARRANGE: CREAMOS UN USUARIO, UNA CATEGORIA, UN PRODUCTO PERO SIN INICIAR SESSION
        $categoria = Categoria::factory()->create();

        $producto = [
            'nombre_producto' => 'Producto Misterioso',
            'descripcion_producto' => 'No parece haber iniciado session',
            'precio_producto' => 800,
            'stock_producto' => 18,
            'categoria_id' => $categoria->id,
        ];

        # ACT: REALIZAMOS LA SOLICITUD
        $response = $this->postJson('/api/V1/productos', $producto);

        # ASSERT: VALIDAMOS LA RESPUESTA
        $response->assertUnauthorized();
    }
}
