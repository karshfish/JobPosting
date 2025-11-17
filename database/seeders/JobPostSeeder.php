<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobPost;

class JobPostSeeder extends Seeder
{
    public function run(): void
    {
        JobPost::factory()
            ->count(50)
            ->create()
            ->each(function (JobPost $job) {
                if ($job->status === 'closed') {
                    $job->delete(); // soft delete seeded closed jobs
                }
            });
    }
}
