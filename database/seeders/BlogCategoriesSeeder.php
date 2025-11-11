<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Study Guides',
                'slug' => 'study-guides',
                'description' => 'Comprehensive study guides and tips for certification preparation',
            ],
            [
                'name' => 'Exam Strategies',
                'slug' => 'exam-strategies',
                'description' => 'Best practices and strategies for passing certification exams',
            ],
            [
                'name' => 'Career Development',
                'slug' => 'career-development',
                'description' => 'Career paths, opportunities, and salary insights for certified professionals',
            ],
            [
                'name' => 'Industry News',
                'slug' => 'industry-news',
                'description' => 'Latest updates and trends in the certification and tech industry',
            ],
            [
                'name' => 'Success Stories',
                'slug' => 'success-stories',
                'description' => 'Real stories from professionals who achieved their certification goals',
            ],
        ];

        foreach ($categories as $category) {
            // Validate required fields
            if (empty($category['name']) || empty($category['slug'])) {
                $this->command->error("Invalid category data: name and slug are required");
                continue;
            }

            // Check if category already exists
            $existing = BlogCategory::where('slug', $category['slug'])->first();
            if ($existing) {
                $this->command->info("Category '{$category['name']}' already exists, skipping...");
                continue;
            }

            BlogCategory::create($category);
            $this->command->info("Created category: {$category['name']}");
        }
    }
}
