<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cashier',
                'email' => 'cashier@example.com',
                'password' => Hash::make('password123'),
                'role' => 'cashier',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Registrar',
                'email' => 'registrar@example.com',
                'password' => Hash::make('password123'),
                'role' => 'registrar',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
