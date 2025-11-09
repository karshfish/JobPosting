<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Backend Development',
            'Frontend Development',
            'Full-Stack',
            'Mobile',
            'DevOps',
            'Data Science / ML',
            'QA / Testing',
            'UI/UX Design',
            'Product Management',
            'Digital Marketing',
        ];

        foreach ($categories as $name) {
            $slug = Str::slug($name);

            Category::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }
    }
}

