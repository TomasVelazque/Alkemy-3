<?php

namespace Database\Factories;

use App\Models\Carrito;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Carrito>
 */
class CarritoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'estado' => 'No confirmado'
        ];
    }
}
