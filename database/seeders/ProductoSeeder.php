<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        //CREAMOS PRODUCTOS DE PRUEBAS
        Producto::create([
            'nombre_producto' => 'Monster',
            'descripcion_producto' => 'Bebida energetica.',
            'precio_producto' => 2700,
            'stock_producto' => 5,
            'categoria_id' => 1
        ]);

        Producto::create([
            'nombre_producto' => 'Manzana',
            'descripcion_producto' => '',
            'precio_producto' => 200,
            'stock_producto' => 50,
            'categoria_id' => 2
        ]);

        Producto::create([
            'nombre_producto' => 'Pan Lactal',
            'descripcion_producto' => 'Pan de elaboracion misteriosa',
            'precio_producto' => 4500,
            'stock_producto' => 7,
            'categoria_id' => 3
        ]);
    }
}