<?php
namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\CartService;
use App\Traits\WithToast;

#[Layout('layouts.app')]
class Cart extends Component {
    use WithToast;

    public function updateQuantity($itemId, $quantity, CartService $cartService) {
        $cartService->updateItem($itemId, $quantity);
        $this->dispatch('cart-updated');
    }

    public function removeItem($itemId, CartService $cartService) {
        $cartService->removeItem($itemId);
        $this->dispatch('cart-updated');
        $this->notify('Item dihapus dari keranjang', 'info');
    }

    public function render(CartService $cartService) {
        $cart = $cartService->getCart();
        $items = $cart->items()->with('product')->get();
        
        $subtotal = 0;
        foreach ($items as $item) {
            $price = $item->product->discount_price ?? $item->product->price;
            $subtotal += $price * $item->quantity;
        }

        return view('livewire.pages.cart', [
            'items' => $items,
            'subtotal' => $subtotal
        ]);
    }
}