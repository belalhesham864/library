<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Loans;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Loans>
 */
class LoansFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
             $loansdata=fake()->dateTimeBetween('-1 month',now());
        return [
            'user_id'=>User::inRandomOrder()->first()->id,
            'book_id'=>Book::inRandomOrder()->first()->id,
             'loans_at'=>$loansdata,
             'due_date'=>fake()->dateTimeBetween($loansdata,'+1 month'),
             'returned_at'=> fake()->boolean() ? fake()->dateTimeBetween($loansdata,'+1 month'):null,
        ];
    
    }
}
