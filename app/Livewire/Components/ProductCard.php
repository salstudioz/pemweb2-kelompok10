<?php
namespace App\Livewire\Components;

use Livewire\Component;
use App\Services\CartService;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Traits\WithToast;

class ProductCard extends Component {
    use WithToast;

    public $product;
    public $inWishlist = false;

    public function mount($product) {
        $this->product = $product;
        if (Auth::check()) {
            $this->inWishlist = Wishlist::where('user_id', Auth::id())
                                        ->where('product_id', $this->product->id)
                                        ->exists();
        }
    }

    public function addToCart(CartService $cartService) {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $cartService->addItem($this->product->id);
        $this->dispatch('cart-updated');
        $this->notify('Produk berhasil ditambahkan ke keranjang!', 'success');
    }

    public function toggleWishlist() {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->inWishlist) {
            Wishlist::where('user_id', Auth::id())
                    ->where('product_id', $this->product->id)
                    ->delete();
            $this->inWishlist = false;
            $this->notify('Dihapus dari wishlist.', 'info');
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $this->product->id
            ]);
            $this->inWishlist = true;
            $this->notify('Ditambahkan ke wishlist!', 'success');
        }
    }

    public function render() {
        return view('livewire.components.product-card');
    }
}