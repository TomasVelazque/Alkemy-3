<?php

namespace Database\Factories;

use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CarritoItem>
 */
class CarritoItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'carrito_id' => Carrito::factory(),
            'producto_id' => Producto::factory(),
            'cantidad_producto' => fake()->numberBetween(1, 10),
            'precio_unitario' => fake()->randomFloat(2, 1, 100),
        ];
    }
}
