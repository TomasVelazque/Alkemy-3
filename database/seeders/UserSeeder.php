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
        User::create([
            'name' => 'Limit',
            'email' => 'tomasvelazquelp@gmail.com',
            'password' => Hash::make('1234'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'TestUser',
            'email' => 'testuser@gmail.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}
