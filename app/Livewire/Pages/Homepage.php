<?php
namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\Genre;

#[Layout('layouts.app')]
class Homepage extends Component {
    public function render() {
        $featuredProducts = Product::where('is_featured', true)->where('is_active', true)->take(4)->get();
        $latestProducts = Product::where('is_active', true)->latest()->take(8)->get();
        $genres = Genre::inRandomOrder()->limit(12)->get();
        
        return view('livewire.pages.homepage', [
            'featuredProducts' => $featuredProducts,
            'latestProducts' => $latestProducts,
            'genres' => $genres
        ]);
    }
}