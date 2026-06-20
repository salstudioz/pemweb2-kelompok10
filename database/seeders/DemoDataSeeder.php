<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;
use App\Models\Game;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder {
    public function run(): void {
        // Create Admin
        User::create([
            'name' => 'Admin Sigmaven',
            'email' => 'admin@sigmaven.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Premium
        User::create([
            'name' => 'Premium Member',
            'email' => 'premium@sigmaven.com',
            'password' => Hash::make('password'),
            'role' => 'premium',
            'points' => 1000,
        ]);

        // Create User
        User::create([
            'name' => 'Regular Member',
            'email' => 'user@sigmaven.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create Game
        Game::create([
            'title' => 'Literasi Nusantara',
            'description' => 'Game edukasi interaktif tentang literasi budaya Indonesia.',
            'required_points' => 500,
            'url' => '#',
        ]);

        // Create Products & Reviews
        Product::factory(50)->create()->each(function($product) {
            Review::factory(rand(1, 5))->create(['product_id' => $product->id]);
        });
    }
}