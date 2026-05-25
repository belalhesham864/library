<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$name=fake()->sentence(),
            
            'slug'=>Str::slug($name),
           'description'=>fake()->paragraph(),
           'status'=> rand(0,1),
           'quantity'=>fake()->randomElement([5,10]),
           'image' => 'https://picsum.photos/200/300?random=' . rand(1, 1000),
           'cost'=>fake()->randomElement([20,300]),
           'category_id'=>Category::inRandomOrder()->first()->id
        ];
    }
}
               