<?php
namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartService {
    public function getCart() {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }
        return Cart::firstOrCreate(['session_id' => session()->getId()]);
    }

    public function addItem($productId, $quantity = 1) {
        $cart = $this->getCart();
        $product = Product::findOrFail($productId);
        
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $productId)
                            ->first();
                            
        if (!$cartItem) {
            $cartItem = $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        } else {
            $cartItem->increment('quantity', $quantity);
        }

        $this->recalculateTotal($cart);
        event(new \App\Events\CartUpdated());
        return $cartItem;
    }

    public function updateItem($itemId, $quantity) {
        if ($quantity <= 0) {
            return $this->removeItem($itemId);
        }
        
        $item = CartItem::findOrFail($itemId);
        $item->update(['quantity' => $quantity]);
        $this->recalculateTotal($item->cart);
        event(new \App\Events\CartUpdated());
    }

    public function removeItem($itemId) {
        $item = CartItem::find($itemId);
        if ($item) {
            $cart = $item->cart;
            $item->delete();
            $this->recalculateTotal($cart);
            event(new \App\Events\CartUpdated());
        }
    }
    
    public function clearCart() {
        $cart = $this->getCart();
        $cart->items()->delete();
        $this->recalculateTotal($cart);
        event(new \App\Events\CartUpdated());
    }

    public function recalculateTotal($cart) {
        // Carts table does not have a total column, calculate dynamically in views instead
    }
}