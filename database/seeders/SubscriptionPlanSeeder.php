<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder {
    public function run(): void {
        SubscriptionPlan::firstOrCreate(
            ['slug' => 'monthly-premium'],
            [
                'name' => 'Monthly Premium',
                'price' => 49000,
                'duration_days' => 30,
                'bonus_points' => 500,
                'features' => ['Akses Sigame', 'Akses LegacyBid', 'Diskon Khusus']
            ]
        );
        
        SubscriptionPlan::firstOrCreate(
            ['slug' => 'yearly-premium'],
            [
                'name' => 'Yearly Premium',
                'price' => 490000,
                'duration_days' => 365,
                'bonus_points' => 7000,
                'features' => ['Semua fitur Bulanan', '2 Bulan Gratis', 'Prioritas Support']
            ]
        );
    }
}