<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin AgroWaste',
            'email' => 'admin@agrowaste.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]);

        // Regular users (petani)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@agrowaste.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@agrowaste.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
        ]);

        User::create([
            'name' => 'Ahmad Dahlan',
            'email' => 'ahmad@agrowaste.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
        ]);
    }
}
