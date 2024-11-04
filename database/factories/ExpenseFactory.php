<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(2),
            'amount' => fake()->randomFloat(2, 1, 10000),
            'spent_at' => fake()->dateTimeBetween('-2 years', 'now'),
            'info' => fake()->sentence(6),
            'user_id' => 1,
        ];
    }
}
