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
        // HSL Superadmin
        User::create([
            'name' => 'HSL Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Provider
        User::create([
            'name' => 'Provider',
            'email' => 'provider@example.com',
            'password' => Hash::make('password'),
            'role' => 'provider',
        ]);
    }
}
