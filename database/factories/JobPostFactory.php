<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobPost>
 */
class JobPostFactory extends Factory
{
    protected $model = \App\Models\JobPost::class;

    public function definition(): array
    {
        $skillsPool = [
            'Teamwork','Leadership','Problem Solving','Communication','Time Management',
            'Adaptability','Critical Thinking','Creativity','Conflict Resolution','Collaboration'
        ];

        $qualificationsPool = ['High School','Bachelor','Master','1 year','3 years','5 years'];

        $technologiesPool = [
            'Laravel','PHP','MySQL','React','Vue.js','Angular','JavaScript','TypeScript',
            'HTML','CSS','Bootstrap','TailwindCSS','REST API','Git','Docker','AWS','Node.js'
        ];

        $benefitsPool = [
            'Health insurance','Remote allowance','Paid vacation','Gym membership','Flexible hours'
        ];

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph(3),
            'responsibilities' => implode("\n", $this->faker->sentences(5)),
            'skills' => $this->faker->randomElements($skillsPool, rand(2,5)),
            'qualifications' => $this->faker->randomElements($qualificationsPool, rand(1,3)),
            'technologies' => $this->faker->randomElements($technologiesPool, rand(2,5)),
            'salary_min' => $this->faker->numberBetween(20000, 40000),
            'salary_max' => $this->faker->numberBetween(40001, 100000),
            'benefits' => $this->faker->randomElements($benefitsPool, rand(1,3)),
            'location' => $this->faker->city . ', ' . $this->faker->country,
            'work_type' => $this->faker->randomElement(['remote','on-site','hybrid']),
            'application_deadline' => $this->faker->dateTimeBetween('now','+2 months')->format('Y-m-d'),
            'branding_image' => null,
            'status' => $this->faker->randomElement(['draft','published','closed']),
        ];
    }
}
