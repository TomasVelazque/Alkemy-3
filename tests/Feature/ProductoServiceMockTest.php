<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;
use App\Services\ProductoService;
use Mockery\MockInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductoServiceMockTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_endpoint_delega_el_alta_en_producto_service(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $token = auth('api')->login($admin);

        $categoria = Categoria::factory()->create();

        $productoDevuelto = Producto::factory()->make([
            'id' => 50,
            'nombre_producto' => 'Producto de Prueba',
            'categoria_id' => $categoria->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $productoDevuelto->setRelation('categoria', $categoria);

        $this->mock(ProductoService::class, function (MockInterface $mock) use ($productoDevuelto): void {
            $mock->shouldReceive('create')
                ->once()
                ->andReturn($productoDevuelto);
        });

        $datosProducto = [
            'nombre_producto' => $productoDevuelto->nombre_producto,
            'descripcion_producto' => 'Simulacion de dependencia',
            'precio_producto' => 30000,
            'stock_producto' => 4,
            'categoria_id' => $productoDevuelto->categoria_id,
        ];

        $this->withToken($token)->postJson('/api/V1/productos', $datosProducto)
            ->assertCreated()
            ->assertJsonPath('nombre', 'Producto de Prueba');
    }
}