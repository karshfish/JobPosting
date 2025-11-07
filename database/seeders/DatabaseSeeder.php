<?php

namespace Database\Seeders;
use App\Models\Candidate;
use App\Models\User;
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
    }
}
