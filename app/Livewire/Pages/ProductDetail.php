<?php
namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Services\CartService;
use App\Traits\WithToast;

#[Layout('layouts.app')]
class ProductDetail extends Component {
    use WithToast;

    public Product $product;
    public $quantity = 1;

    public function mount($slug) {
        $this->product = Product::with(['reviews.user', 'genres'])->where('slug', $slug)->firstOrFail();
    }

    public function increment() {
        if ($this->quantity < $this->product->stock || $this->product->type == 'digital') {
            $this->quantity++;
        }
    }

    public function decrement() {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart(CartService $cartService) {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $cartService->addItem($this->product->id, $this->quantity);
        $this->dispatch('cart-updated');
        $this->notify('Product added to cart!', 'success');
    }

    public function render() {
        // Find related products through shared genres
        $genreIds = $this->product->genres->pluck('id');
        $relatedProducts = collect();
        if ($genreIds->isNotEmpty()) {
            $relatedProducts = Product::whereHas('genres', function($q) use ($genreIds) {
                    $q->whereIn('genres.id', $genreIds);
                })
                ->where('id', '!=', $this->product->id)
                ->where('is_active', true)
                ->take(4)
                ->get();
        }
                                  
        return view('livewire.pages.product-detail', [
            'relatedProducts' => $relatedProducts
        ]);
    }
}