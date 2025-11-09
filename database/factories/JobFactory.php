<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    public function definition(): array
    {
        return [
            'employer_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(),
            'skills' => $this->faker->words(5, true),
            'location' => $this->faker->city(),
            'work_type' => $this->faker->randomElement(['onsite', 'remote', 'hybrid']),
            'salary_min' => 5000,
            'salary_max' => 15000,
            'status' => 'open',
            'deadline' => now()->addDays(15),
        ];
    }
}
