<?php
namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class WishlistPage extends Component {
    public function render() {
        $wishlists = Wishlist::with('product')->where('user_id', Auth::id())->get();
        
        return view('livewire.pages.wishlist', [
            'wishlists' => $wishlists
        ]);
    }
}