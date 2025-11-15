<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\JobPost;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            'job_id' => JobPost::factory(),
            'resume' => null,
            'status' => 'pending',
        ];
    }
}
