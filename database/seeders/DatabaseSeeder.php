<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create 10 users with candidate profiles
        Candidate::factory(10)->create();

        // Create jobs for testing (assuming Job model ready)
        Job::factory(10)->create();

        // Create sample applications
        Application::factory(20)->create();

        // Ensure an admin user exists and has admin role (string column)
        $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = env('ADMIN_PASSWORD', 'password');

        $admin = User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Admin',
                'password' => bcrypt($adminPassword),
                'role' => 'admin',
            ]
        );

        if ($admin->role !== 'admin') {
            $admin->role = 'admin';
            $admin->save();
        }

        // Optional: demo user
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role' => 'candidate',
            ]
        );
    }
}

