<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\User;
use App\Models\JobPost;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $jobs = JobPost::all();

        foreach ($users as $user) {
            foreach ($jobs->random(2) as $job) {
                Application::create([
                    'user_id' => $user->id,
                    'job_id' => $job->id,
                    'resume' => null,
                    'status' => 'pending',
                ]);
            }
        }
    }
}
