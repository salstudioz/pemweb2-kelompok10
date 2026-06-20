<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call([
            GenreSeeder::class, // 30 genre yang sudah ada
            SubscriptionPlanSeeder::class,
            UserSeeder::class,
            BookSeeder::class,
        ]);
    }
}