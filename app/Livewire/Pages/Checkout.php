<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\CartService;
use App\Services\PaymentService;
use App\Models\Order;
use App\Models\OrderItem;
use App\Traits\WithToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class Checkout extends Component
{
    use WithToast;

    public $address_id;
    public $payment_method = 'bank_transfer';
    public $notes = '';
    public $coupon_code = '';
    public $applied_coupon = null;

    protected $paymentMethods = [
        'bank_transfer'      => 'Bank Transfer',
        'credit_card'        => 'Credit Card',
        'ewallet'            => 'E-Wallet',
        'cash_on_delivery'   => 'Cash on Delivery'
    ];

    public function mount(CartService $cartService)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = $cartService->getCart();
        if ($cart->items()->count() == 0) {
            return redirect()->route('shop')->with('error', 'Your cart is empty.');
        }

        $primaryAddress = Auth::user()->primaryAddress;
        if ($primaryAddress) {
            $this->address_id = $primaryAddress->id;
        }
    }

    public function applyCoupon()
    {
        $this->validate([
            'coupon_code' => 'required|string|max:50'
        ]);

        $coupon = \App\Models\Coupon::where('code', strtoupper($this->coupon_code))->first();

        if (!$coupon) {
            $this->toast('Coupon code not found.', 'error');
            $this->applied_coupon = null;
            return;
        }

        if (!$coupon->isValid()) {
            $this->toast('Coupon is not valid or has expired.', 'error');
            $this->applied_coupon = null;
            return;
        }

        $this->applied_coupon = $coupon;
        $this->toast('Coupon applied successfully!', 'success');
        $this->coupon_code = '';
    }

    public function removeCoupon()
    {
        $this->applied_coupon = null;
        $this->toast('Coupon removed.', 'info');
    }

    public function processCheckout(CartService $cartService, PaymentService $paymentService)
    {
        $this->validate([
            'address_id'      => 'required|exists:addresses,id',
            'payment_method'  => 'required|in:' . implode(',', array_keys($this->paymentMethods))
        ]);

        $address = \App\Models\Address::where('id', $this->address_id)
                                      ->where('user_id', Auth::id())
                                      ->first();
        if (!$address) {
            $this->toast('Invalid address selected.', 'error');
            return;
        }

        $cart = $cartService->getCart();
        $items = $cart->items()->with('product')->get();

        if ($items->isEmpty()) {
            $this->toast('Your cart is empty.', 'error');
            return redirect()->route('shop');
        }

        $subtotal = 0;
        foreach ($items as $item) {
            $price = $item->product->discount_price ?? $item->product->price;
            $subtotal += $price * $item->quantity;
        }

        $shipping = $this->calculateShippingCost($address);

        $discount = 0;
        if ($this->applied_coupon) {
            $discount = $this->applied_coupon->applyDiscount($subtotal);
            $discount = min($discount, $subtotal);
        }

        $grandTotal = max(0, $subtotal + $shipping - $discount);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id'           => Auth::id(),
                'order_number'      => 'ORD-' . strtoupper(uniqid()),
                'total_amount'      => $subtotal,
                'shipping_cost'     => $shipping,
                'grand_total'       => $grandTotal,
                'status'            => 'pending',
                'payment_method'    => $this->payment_method,
                'shipping_address'  => $address->recipient_name . ' (' . $address->phone . ') - ' . $address->full_address . ', ' . $address->city . ' ' . $address->postal_code,
                'notes'             => $this->notes
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->discount_price ?? $item->product->price
                ]);
            }

            if ($this->applied_coupon) {
                $this->applied_coupon->incrementUses();
            }

            $paymentService->processOrderPayment($order, $this->payment_method);

            $cartService->clearCart();

            DB::commit();

            $this->toast("Order #{$order->order_number} placed successfully!", 'success');
            return redirect()->route('order.history');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->toast('Failed to place order: ' . $e->getMessage(), 'error');
            \Log::error('Checkout error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }
    }

    public function render(CartService $cartService)
    {
        $cart = $cartService->getCart();
        $items = $cart->items()->with('product')->get();

        $subtotal = 0;
        foreach ($items as $item) {
            $price = $item->product->discount_price ?? $item->product->price;
            $subtotal += $price * $item->quantity;
        }

        $addresses = Auth::user()->addresses;

        $shipping = 15000;
        if ($this->address_id) {
            $address = $addresses->find($this->address_id);
            if ($address) {
                $shipping = $this->calculateShippingCost($address);
            }
        }

        $discount = 0;
        if ($this->applied_coupon) {
            $discount = $this->applied_coupon->applyDiscount($subtotal);
            $discount = min($discount, $subtotal);
        }

        $grandTotal = max(0, $subtotal + $shipping - $discount);

        return view('livewire.pages.checkout', [
            'items'            => $items,
            'subtotal'         => $subtotal,
            'shipping'         => $shipping,
            'discount'         => $discount,
            'grandTotal'       => $grandTotal,
            'addresses'        => $addresses,
            'payment_methods'  => $this->paymentMethods,
            'applied_coupon'   => $this->applied_coupon,
        ]);
    }

    private function calculateShippingCost($address)
    {
        if (!$address) {
            return 15000;
        }

        $city = strtolower($address->city);
        $shippingCosts = [
            'jakarta'    => 10000,
            'bandung'    => 12000,
            'surabaya'   => 13000,
            'yogyakarta' => 15000,
            'bali'       => 20000,
        ];

        foreach ($shippingCosts as $cityName => $cost) {
            if (str_contains($city, $cityName)) {
                return $cost;
            }
        }

        return 15000;
    }
}