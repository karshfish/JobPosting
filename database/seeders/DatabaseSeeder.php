<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Candidate;
use App\Models\JobPost;
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
        JobPost::factory(10)->create();

        // Create sample applications
        Application::factory(20)->create();

        // Ensure a single super admin user exists (created only via seeder)
        $adminEmail = 'superAdmin@gmail.com';
        $adminPassword = env('ADMIN_PASSWORD', 'password');

        $admin = User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Super Admin',
                'password' => bcrypt($adminPassword),
                'role' => 'super_admin',
            ]
        );

        // Always enforce role as super_admin for this seeded account
        if ($admin->role !== 'super_admin') {
            $admin->forceFill(['role' => 'super_admin'])->save();
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

         // Call your seeders here
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            JobPostSeeder::class,
        ]);
    }
}
