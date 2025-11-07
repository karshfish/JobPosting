<?php
use Illuminate\Database\Eloquent\Factories\Factory;

class JobPostFactory extends Factory
{
    public function definition(): array
    {
        $statuses = ['draft', 'published', 'closed', 'approved', 'rejected'];

        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(5),
            'responsibilities' => implode("\n", $this->faker->sentences(5)),
            'skills' => json_encode($this->faker->randomElements([
                'PHP', 'Laravel', 'JavaScript', 'Vue', 'React', 'MySQL', 'HTML', 'CSS'
            ], rand(3, 6))),
            'qualifications' => json_encode($this->faker->randomElements([
                'Bachelor’s Degree', '3+ years experience', 'Strong communication', 'Team player'
            ], rand(2, 4))),
            'salary_range' => $this->faker->numberBetween(4000, 10000) . ' - ' . $this->faker->numberBetween(11000, 20000),
            'benefits' => implode(', ', $this->faker->randomElements([
                'Health Insurance', 'Paid Leave', 'Remote Work', 'Performance Bonus'
            ], rand(2, 3))),
            'work_type' => $this->faker->randomElement(['remote', 'onsite', 'hybrid']),
            'location' => $this->faker->city(),
            'status' => $this->faker->randomElement($statuses),
            'application_deadline' => $this->faker->dateTimeBetween('now', '+2 months'),
            'user_id' => 1, // will be replaced dynamically in seeder
        ];
    }
}
