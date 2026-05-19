<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'=> $title=fake()->randomElement([
                       'Programming',
            'Science',
            'History',
            'Novels',
            'Religion',
            'Business',
            'Technology',
            'Mathematics',
            'Physics',
            'Chemistry',
            'Biography',
            ]),
            'slug'=>Str::slug($title),
            'status'=>rand(0,1),
            'description'=>fake()->paragraph(4)
        ];
    }
}
