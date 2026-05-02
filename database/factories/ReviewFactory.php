<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => null,
            'review' => fake()->paragraph,
            'rating' => fake()->numberBetween(1, 5),
            'created_at' => $createdAt = fake()->dateTimeBetween('-2 year')->setTime(12, 0),
            'updated_at' => fake()->dateTimeBetween($createdAt, 'now', 'UTC')->setTime(12, 0)
        ];
    }

    public function good(){
        return $this->state(function(array $attributes){
            return [
                'rating' => fake()->numberBetween(4, 5)
            ];
        });
    }

        public function average(){
        return $this->state(function(array $attributes){
            return [
                'rating' => fake()->numberBetween(2, 5)
            ];
        });
    }

        public function bad(){
        return $this->state(function(array $attributes){
            return [
                'rating' => fake()->numberBetween(1, 3)
            ];
        });
    }
}
