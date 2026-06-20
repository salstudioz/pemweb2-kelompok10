<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ProductFactory extends Factory {
    public function definition(): array {
        $price = $this->faker->randomFloat(2, 50000, 300000);
        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? 1,
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->unique()->slug(),
            'author' => $this->faker->name(),
            'publisher' => $this->faker->company(),
            'isbn' => $this->faker->isbn13(),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $price,
            'discount_price' => $this->faker->boolean(30) ? $price * 0.8 : null,
            'stock' => $this->faker->numberBetween(10, 100),
            'type' => 'physical',
            'is_featured' => $this->faker->boolean(20),
            'is_active' => true,
        ];
    }
}