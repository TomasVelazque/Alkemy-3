<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Limit',
            'email' => 'tomasvelazquelp@gmail.com',
            'is_admin' => true,
        ]);

        User::factory()->create([
            'name' => 'TestUser',
            'email' => 'testuser@gmail.com',
            'is_admin' => false,
        ]);
    }
}
