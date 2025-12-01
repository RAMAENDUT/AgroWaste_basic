<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'name' => 'Admin',
            'description' => 'Administrator dengan akses penuh',
        ]);

        Role::create([
            'name' => 'User',
            'description' => 'Pengguna biasa (Petani)',
        ]);
    }
}
