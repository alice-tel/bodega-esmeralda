<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bodegas-esmeralda.ar',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'admin', // Assuming your User model has a role field
        ]);

        // Create regular user
        User::create([
            'name' => 'Test User',
            'email' => 'test@bodegas-esmeralda.ar',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'user', // Assuming your User model has a role field
        ]);
    }
}
