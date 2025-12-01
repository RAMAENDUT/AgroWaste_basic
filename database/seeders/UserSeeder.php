<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@agrowaste.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        // Create regular users
        User::firstOrCreate(
            ['email' => 'user@agrowaste.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
            ]
        );
    }
}
