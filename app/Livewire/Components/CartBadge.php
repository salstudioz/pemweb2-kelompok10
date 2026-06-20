<?php
namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\CartService;

class CartBadge extends Component {
    public $count = 0;

    #[On('cart-updated')]
    public function updateCount() {
        $cartService = app(CartService::class);
        $cart = $cartService->getCart();
        $this->count = $cart ? $cart->items()->sum('quantity') : 0;
    }

    public function mount() {
        $this->updateCount();
    }

    public function render() {
        return view('livewire.components.cart-badge');
    }
}