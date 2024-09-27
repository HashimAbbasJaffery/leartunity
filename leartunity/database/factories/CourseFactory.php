<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paragraphs = fake()->paragraphs(3);
        $title = fake()->text(20);
        $slug = str($title)->slug();
        return [
            "title" => $title,
            "description" => "<p>" . implode("</p><p>", $paragraphs) . "<p>",
            "status" => fake()->boolean(),
            "thumbnail" => "",
            "author_id" => 1,
            "price" => fake()->randomFloat(1, 1, 100),
            "slug" => $slug,
            "stripe_id" => "price_1OglnuEHPJtVUmag6DxxffKD",
            "pre_req" => "<p>" . implode("</p><p>", $paragraphs) . "<p>",
            "stripe_product_id" => "lol"
        ];
    }
}
