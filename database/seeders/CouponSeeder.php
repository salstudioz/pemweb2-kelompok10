<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponSeeder extends Seeder {
    public function run(): void {
        $now = Carbon::now();

        $coupons = [
            // ── Kupon Aktif ──────────────────────────────────────────
            [
                'code'        => 'WELCOME10',
                'name'        => 'Selamat Datang 10%',
                'description' => 'Kupon diskon 10% untuk pembelian pertama kamu di Sigmaven. Berlaku untuk semua produk.',
                'type'        => 'percentage',
                'value'       => 10.00,
                'min_order'   => 50000,
                'max_uses'    => null,
                'uses_count'  => 0,
                'starts_at'   => $now->copy()->subDays(30),
                'ends_at'     => $now->copy()->addDays(60),
                'is_active'   => true,
            ],
            [
                'code'        => 'BUKU15',
                'name'        => 'Diskon Buku 15%',
                'description' => 'Hemat 15% untuk semua pembelian buku fisik maupun digital.',
                'type'        => 'percentage',
                'value'       => 15.00,
                'min_order'   => 100000,
                'max_uses'    => 200,
                'uses_count'  => 47,
                'starts_at'   => $now->copy()->subDays(10),
                'ends_at'     => $now->copy()->addDays(20),
                'is_active'   => true,
            ],
            [
                'code'        => 'HEMAT20K',
                'name'        => 'Potongan Rp 20.000',
                'description' => 'Dapatkan potongan langsung sebesar Rp 20.000 untuk pembelian minimal Rp 150.000.',
                'type'        => 'fixed',
                'value'       => 20000.00,
                'min_order'   => 150000,
                'max_uses'    => 500,
                'uses_count'  => 123,
                'starts_at'   => $now->copy()->subDays(5),
                'ends_at'     => $now->copy()->addDays(25),
                'is_active'   => true,
            ],
            [
                'code'        => 'SIGMAVIP',
                'name'        => 'VIP Member Exclusive 20%',
                'description' => 'Kupon eksklusif untuk member premium Sigmaven. Nikmati diskon 20% tanpa minimum pembelian.',
                'type'        => 'percentage',
                'value'       => 20.00,
                'min_order'   => null,
                'max_uses'    => 100,
                'uses_count'  => 15,
                'starts_at'   => $now->copy()->subDays(1),
                'ends_at'     => $now->copy()->addDays(30),
                'is_active'   => true,
            ],
            [
                'code'        => 'FLASH50K',
                'name'        => 'Flash Sale Rp 50.000',
                'description' => 'Flash sale! Potongan langsung Rp 50.000 untuk pembelian di atas Rp 300.000. Stok terbatas!',
                'type'        => 'fixed',
                'value'       => 50000.00,
                'min_order'   => 300000,
                'max_uses'    => 50,
                'uses_count'  => 38,
                'starts_at'   => $now->copy()->startOfDay(),
                'ends_at'     => $now->copy()->endOfDay(),
                'is_active'   => true,
            ],
            [
                'code'        => 'LITERASI25',
                'name'        => 'Hari Literasi Nasional 25%',
                'description' => 'Rayakan Hari Literasi Nasional dengan diskon spesial 25% untuk semua pembelian buku.',
                'type'        => 'percentage',
                'value'       => 25.00,
                'min_order'   => 75000,
                'max_uses'    => 1000,
                'uses_count'  => 312,
                'starts_at'   => $now->copy()->subDays(2),
                'ends_at'     => $now->copy()->addDays(5),
                'is_active'   => true,
            ],
            [
                'code'        => 'GRATIS_ONGKIR',
                'name'        => 'Gratis Ongkos Kirim Rp 30.000',
                'description' => 'Nikmati gratis ongkos kirim senilai Rp 30.000 untuk pembelian buku fisik minimal Rp 100.000.',
                'type'        => 'fixed',
                'value'       => 30000.00,
                'min_order'   => 100000,
                'max_uses'    => null,
                'uses_count'  => 89,
                'starts_at'   => $now->copy()->subDays(7),
                'ends_at'     => $now->copy()->addDays(14),
                'is_active'   => true,
            ],
            [
                'code'        => 'NEWMEMBER',
                'name'        => 'New Member Special Rp 25.000',
                'description' => 'Hadiah khusus member baru! Potongan Rp 25.000 untuk pembelian pertama tanpa minimum.',
                'type'        => 'fixed',
                'value'       => 25000.00,
                'min_order'   => null,
                'max_uses'    => null,
                'uses_count'  => 204,
                'starts_at'   => null,
                'ends_at'     => null,
                'is_active'   => true,
            ],

            // ── Kupon Belum Mulai ─────────────────────────────────────
            [
                'code'        => 'HARBOLNAS30',
                'name'        => 'Harbolnas Diskon 30%',
                'description' => 'Persiapkan dirimu untuk Hari Belanja Online Nasional! Diskon 30% untuk semua produk.',
                'type'        => 'percentage',
                'value'       => 30.00,
                'min_order'   => 200000,
                'max_uses'    => 2000,
                'uses_count'  => 0,
                'starts_at'   => $now->copy()->addDays(10),
                'ends_at'     => $now->copy()->addDays(11),
                'is_active'   => true,
            ],
            [
                'code'        => 'LEBARAN2026',
                'name'        => 'Promo Lebaran Rp 75.000',
                'description' => 'Rayakan Lebaran dengan belanja buku! Potongan Rp 75.000 untuk pembelian minimal Rp 400.000.',
                'type'        => 'fixed',
                'value'       => 75000.00,
                'min_order'   => 400000,
                'max_uses'    => 500,
                'uses_count'  => 0,
                'starts_at'   => $now->copy()->addDays(15),
                'ends_at'     => $now->copy()->addDays(22),
                'is_active'   => true,
            ],

            // ── Kupon Kadaluarsa ──────────────────────────────────────
            [
                'code'        => 'KEMERDEKAAN17',
                'name'        => 'HUT RI 17% Diskon',
                'description' => 'Peringati HUT Republik Indonesia dengan diskon 17% untuk semua produk Sigmaven.',
                'type'        => 'percentage',
                'value'       => 17.00,
                'min_order'   => 50000,
                'max_uses'    => 1700,
                'uses_count'  => 1512,
                'starts_at'   => $now->copy()->subDays(40),
                'ends_at'     => $now->copy()->subDays(30),
                'is_active'   => false,
            ],
            [
                'code'        => 'BIRTHDAY10K',
                'name'        => 'Birthday Special Rp 10.000',
                'description' => 'Kupon ulang tahun Sigmaven. Terima kasih telah bersama kami selama ini!',
                'type'        => 'fixed',
                'value'       => 10000.00,
                'min_order'   => 50000,
                'max_uses'    => 800,
                'uses_count'  => 800,
                'starts_at'   => $now->copy()->subDays(60),
                'ends_at'     => $now->copy()->subDays(50),
                'is_active'   => false,
            ],
        ];

        foreach ($coupons as $couponData) {
            Coupon::firstOrCreate(
                ['code' => $couponData['code']],
                $couponData
            );
        }

        $this->command->info('Coupons seeded successfully! (' . count($coupons) . ' coupons: 8 active, 2 upcoming, 2 expired)');
    }
}
