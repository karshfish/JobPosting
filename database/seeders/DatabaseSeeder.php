<?php

namespace Database\Seeders;
use App\Models\Candidate;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;

use App\Models\Application;
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

        // Seed roles & permissions
        $this->call(RolesSeeder::class);

        // Ensure an admin user exists and has the admin role
        $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = env('ADMIN_PASSWORD', 'password');

        $admin = User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Admin',
                'password' => bcrypt($adminPassword),
            ]
        );

        if (! $admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Optional: demo user
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

    }
}
