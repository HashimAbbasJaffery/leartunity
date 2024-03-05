<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Section;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    protected $quantity = 5000;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // User::factory($this->quantity)->create();
        Course::factory(50)->create();
        // Category::factory($this->quantity)->create();
        // Course::factory()
        //         ->has(Category::factory()->count(50))
        //         ->create();
        // Setting::create([
        //     "primary_color" => "#333",
        //     "secondary_color" => "white",
        //     "font_family" => "'Montserrat', sans-serif"
        // ]);
        // \App\Models\Quote::create([
        //     "quote" => "No one can steal your education and skills",
        //     "bg_color" => "#333",
        //     "status" => 1
        // ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
