<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Product;

class ReviewFactory extends Factory {
    public function definition(): array {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? 1,
            'product_id' => Product::inRandomOrder()->first()->id ?? 1,
            'rating' => $this->faker->numberBetween(3, 5),
            'comment' => $this->faker->sentence(),
            'is_approved' => true,
        ];
    }
}