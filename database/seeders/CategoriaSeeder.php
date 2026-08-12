<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create([
            'nombre_categoria' => 'Bebidas',
            'descripcion_categoria' => 'Categoria para las bebidas.'
        ]);
        
        Categoria::create([
            'nombre_categoria' => 'Frutas y Verduras',
            'descripcion_categoria' => 'Categoria para todo tipo de frutas y verduras.'
        ]);

        Categoria::Create([
            'nombre_categoria' => 'Pastas',
            'descripcion_categoria' => 'Categoria para todo tipo de pastas.'
        ]);
    }
}