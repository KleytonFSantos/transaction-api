<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(),
            'description' => fake()->text(25),
            'type' => fake()->randomElement(['expense', 'income']),
            'user_id' => fake()->randomNumber(),
        ];
    }
}
