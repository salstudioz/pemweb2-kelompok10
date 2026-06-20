<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class PaymentService {
    public function processOrderPayment(Order $order, $paymentMethod) {
        DB::beginTransaction();
        try {
            // Lock order items to prevent race conditions during stock deduction
            $items = $order->items()->lockForUpdate()->get();
            
            foreach ($items as $item) {
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Insufficient stock for {$product->title}");
                }
                $product->decrement('stock', $item->quantity);
            }

            Payment::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'payment_method' => $paymentMethod,
                'transaction_id' => uniqid('TXN-'),
                'amount' => $order->grand_total,
                'status' => 'success',
                'type' => 'order'
            ]);

            $order->update(['status' => 'processing', 'payment_status' => 'paid']);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}