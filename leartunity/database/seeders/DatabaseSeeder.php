<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Section;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        User::factory(10)->create();
        Course::factory(50)->create();
        Category::factory(10)->create();
        Section::factory(10)->create();
        Course::factory()
                ->has(Category::factory()->count(50))
                ->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
