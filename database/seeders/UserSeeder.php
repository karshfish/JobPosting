<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Explicit main admin user
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Main Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::factory(5)->create([
            'role' => 'candidate',
        ]);

      
    }
}
