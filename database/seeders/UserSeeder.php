<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    public function run(): void {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@sigmaven.com'],
            [
                'name' => 'Admin Sigmaven',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'phone' => '081234567890',
                'points' => 10000,
            ]
        );

        // Premium users
        $premiumUsers = [
            ['name' => 'Budi Santoso', 'email' => 'budi@sigmaven.com', 'phone' => '081234567891'],
            ['name' => 'Sari Dewi', 'email' => 'sari@sigmaven.com', 'phone' => '081234567892'],
            ['name' => 'Rizky Pratama', 'email' => 'rizky@sigmaven.com', 'phone' => '081234567893'],
            ['name' => 'Maya Wijaya', 'email' => 'maya@sigmaven.com', 'phone' => '081234567894'],
            ['name' => 'Andi Setiawan', 'email' => 'andi@sigmaven.com', 'phone' => '081234567895'],
        ];

        foreach ($premiumUsers as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password'),
                'role' => 'premium',
                'email_verified_at' => now(),
                'phone' => $user['phone'],
                'points' => rand(5000, 15000),
            ]);
        }

        // Regular users
        $regularUsers = [
            ['name' => 'Dewi Lestari', 'email' => 'dewi@sigmaven.com', 'phone' => '081234567896'],
            ['name' => 'Eko Prasetyo', 'email' => 'eko@sigmaven.com', 'phone' => '081234567897'],
            ['name' => 'Fajar Nugroho', 'email' => 'fajar@sigmaven.com', 'phone' => '081234567898'],
            ['name' => 'Gita Sari', 'email' => 'gita@sigmaven.com', 'phone' => '081234567899'],
            ['name' => 'Hendra Wijaya', 'email' => 'hendra@sigmaven.com', 'phone' => '081234567800'],
            ['name' => 'Indah Permata', 'email' => 'indah@sigmaven.com', 'phone' => '081234567801'],
            ['name' => 'Joko Susilo', 'email' => 'joko@sigmaven.com', 'phone' => '081234567802'],
            ['name' => 'Kartika Sari', 'email' => 'kartika@sigmaven.com', 'phone' => '081234567803'],
            ['name' => 'Lukman Hakim', 'email' => 'lukman@sigmaven.com', 'phone' => '081234567804'],
            ['name' => 'Mega Putri', 'email' => 'mega@sigmaven.com', 'phone' => '081234567805'],
        ];

        foreach ($regularUsers as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
                'phone' => $user['phone'],
                'points' => rand(1000, 5000),
            ]);
        }

        // Test users dengan role berbeda
        User::create([
            'name' => 'Test Premium',
            'email' => 'premium@test.com',
            'password' => Hash::make('password'),
            'role' => 'premium',
            'email_verified_at' => now(),
            'phone' => '081111111111',
            'points' => 8000,
        ]);

        User::create([
            'name' => 'Test Regular',
            'email' => 'regular@test.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
            'phone' => '082222222222',
            'points' => 2000,
        ]);

        $this->command->info('Users seeded successfully! All passwords are: password');
    }
}