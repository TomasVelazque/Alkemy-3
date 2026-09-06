<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_producto' => fake()->words(2, true),
            'descripcion_producto' => fake()->sentences(2, true),
            'precio_producto' => fake()->randomFloat(2,1,100),
            'stock_producto' => fake()->numberBetween(1,50),
            'categoria_id' => Categoria::factory(),
        ];
    }
}
