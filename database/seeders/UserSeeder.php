<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(5)->create([
            'role' => 'candidate',
        ]);

        User::factory()
            ->admin()
            ->count(3)
            ->create();
    }
}
