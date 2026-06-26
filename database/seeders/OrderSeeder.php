<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;

class OrderSeeder extends Seeder {
    public function run(): void {
        // Ambil semua user non-admin dan semua produk aktif
        $users    = User::where('role', '!=', 'admin')->get();
        $products = Product::where('is_active', true)->get();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Run UserSeeder first.');
            return;
        }

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Run BookSeeder first.');
            return;
        }

        $statuses        = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        $paymentStatuses = ['unpaid', 'paid', 'failed'];
        $paymentMethods  = ['transfer_bank', 'qris', 'virtual_account', 'cod', 'e_wallet'];
        $cities          = [
            'Jakarta Selatan', 'Jakarta Barat', 'Bandung', 'Surabaya',
            'Yogyakarta', 'Semarang', 'Medan', 'Makassar', 'Bali', 'Bogor',
        ];

        $orderCount = 0;

        foreach ($users as $userIndex => $user) {
            // Setiap user memiliki 2–5 pesanan
            $numOrders = rand(2, 5);

            for ($o = 0; $o < $numOrders; $o++) {
                // Tentukan tanggal pesanan (60 hari terakhir)
                $daysAgo   = rand(0, 60);
                $orderDate = Carbon::now()->subDays($daysAgo);

                // Status yang masuk akal berdasarkan waktu
                if ($daysAgo > 30) {
                    $status = $this->weightedRandom([
                        'completed'  => 60,
                        'cancelled'  => 20,
                        'shipped'    => 10,
                        'processing' => 10,
                    ]);
                } elseif ($daysAgo > 7) {
                    $status = $this->weightedRandom([
                        'completed'  => 30,
                        'shipped'    => 35,
                        'processing' => 25,
                        'cancelled'  => 10,
                    ]);
                } else {
                    $status = $this->weightedRandom([
                        'pending'    => 30,
                        'processing' => 40,
                        'shipped'    => 20,
                        'cancelled'  => 10,
                    ]);
                }

                // Sesuaikan payment_status dengan order status
                if ($status === 'cancelled') {
                    $paymentStatus = $this->weightedRandom([
                        'unpaid' => 50,
                        'failed' => 30,
                        'paid'   => 20,
                    ]);
                } elseif ($status === 'completed' || $status === 'shipped') {
                    $paymentStatus = 'paid';
                } elseif ($status === 'processing') {
                    $paymentStatus = $this->weightedRandom([
                        'paid'   => 80,
                        'unpaid' => 20,
                    ]);
                } else {
                    $paymentStatus = $this->weightedRandom([
                        'unpaid' => 70,
                        'paid'   => 30,
                    ]);
                }

                $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
                $city          = $cities[array_rand($cities)];

                // Pilih 1–4 produk secara acak
                $selectedProducts = $products->random(rand(1, min(4, $products->count())));

                // Hitung total
                $totalAmount  = 0;
                $orderItems   = [];

                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 3);
                    $price    = $product->discount_price ?? $product->price;

                    $orderItems[] = [
                        'product_id' => $product->id,
                        'quantity'   => $quantity,
                        'price'      => $price,
                        'subtotal'   => $price * $quantity,
                    ];

                    $totalAmount += $price * $quantity;
                }

                // Ongkos kirim: COD agak mahal, sisanya flat
                $shippingCost = ($paymentMethod === 'cod') ? rand(20000, 35000) : rand(10000, 25000);

                // Diskon coupon (30% chance)
                $discount   = 0;
                $couponCode = null;
                if (rand(1, 10) <= 3) {
                    $discount   = rand(5000, 50000);
                    $discount   = min($discount, $totalAmount * 0.5); // max 50% diskon
                }

                $grandTotal = $totalAmount + $shippingCost - $discount;
                $grandTotal = max($grandTotal, 0);

                // Buat nomor order unik
                $orderNumber = 'ORD-' . strtoupper(substr(md5(uniqid()), 0, 8)) . '-' . $orderDate->format('Ymd');

                $order = Order::create([
                    'user_id'          => $user->id,
                    'order_number'     => $orderNumber,
                    'total_amount'     => $totalAmount,
                    'shipping_cost'    => $shippingCost,
                    'grand_total'      => $grandTotal,
                    'status'           => $status,
                    'payment_status'   => $paymentStatus,
                    'payment_method'   => $paymentMethod,
                    'shipping_address' => "Jl. {$this->getStreetName()} No. " . rand(1, 100) . ", {$city}",
                    'address'          => "{$city}, " . $this->getProvince($city),
                    'notes'            => rand(0, 3) === 0 ? $this->getRandomNote() : null,
                    'created_at'       => $orderDate,
                    'updated_at'       => $orderDate->copy()->addHours(rand(1, 24)),
                ]);

                // Buat order items
                foreach ($orderItems as $item) {
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $item['product_id'],
                        'quantity'   => $item['quantity'],
                        'price'      => $item['price'],
                        'created_at' => $orderDate,
                        'updated_at' => $orderDate,
                    ]);
                }

                $orderCount++;
            }
        }

        $this->command->info("Orders seeded successfully! ({$orderCount} orders with items created for {$users->count()} users)");
    }

    /**
     * Pilih item berdasarkan bobot probabilitas.
     */
    private function weightedRandom(array $weights): string {
        $total  = array_sum($weights);
        $rand   = rand(1, $total);
        $cumulative = 0;

        foreach ($weights as $key => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $key;
            }
        }

        return array_key_first($weights);
    }

    private function getStreetName(): string {
        $streets = [
            'Merdeka', 'Sudirman', 'Gatot Subroto', 'Diponegoro', 'Imam Bonjol',
            'Ahmad Yani', 'Pahlawan', 'Veteran', 'Pemuda', 'Kebangsaan',
            'Mawar', 'Melati', 'Anggrek', 'Kenanga', 'Dahlia',
            'Mangga', 'Rambutan', 'Durian', 'Cempaka', 'Teratai',
        ];
        return $streets[array_rand($streets)];
    }

    private function getProvince(string $city): string {
        $map = [
            'Jakarta Selatan' => 'DKI Jakarta',
            'Jakarta Barat'   => 'DKI Jakarta',
            'Bandung'         => 'Jawa Barat',
            'Surabaya'        => 'Jawa Timur',
            'Yogyakarta'      => 'DI Yogyakarta',
            'Semarang'        => 'Jawa Tengah',
            'Medan'           => 'Sumatera Utara',
            'Makassar'        => 'Sulawesi Selatan',
            'Bali'            => 'Bali',
            'Bogor'           => 'Jawa Barat',
        ];
        return $map[$city] ?? 'Indonesia';
    }

    private function getRandomNote(): string {
        $notes = [
            'Tolong dibungkus rapi, ini untuk kado.',
            'Mohon dikemas dengan bubble wrap agar tidak rusak.',
            'Sertakan nota pembelian ya, untuk keperluan laporan.',
            'Jika tidak ada stok, bisa diganti dengan buku sejenis.',
            'Titip pesan: "Semoga bermanfaat" di dalam paket.',
            'Pengiriman bisa sore hari setelah jam 5.',
            'Pastikan buku dalam kondisi baru dan bersih.',
            'Kalau bisa dikirim hari ini ya, ada yang menunggu.',
        ];
        return $notes[array_rand($notes)];
    }
}
