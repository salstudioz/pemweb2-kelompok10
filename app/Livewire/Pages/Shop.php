<?php
namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\Genre;

#[Layout('layouts.app')]
class Shop extends Component {
    use WithPagination;

    public $search = '';
    public $genre = null;
    public $sort = 'latest';

    protected $queryString = ['search', 'genre', 'sort'];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingGenre() { $this->resetPage(); }
    public function updatingSort() { $this->resetPage(); }

    public function render() {
        $query = Product::where('is_active', true);

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('author', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->genre) {
            $query->whereHas('genres', function($q) {
                $q->where('slug', $this->genre);
            });
        }

        switch ($this->sort) {
            case 'price_low': $query->orderBy('price', 'asc'); break;
            case 'price_high': $query->orderBy('price', 'desc'); break;
            default: $query->latest(); break;
        }

        return view('livewire.pages.shop', [
            'products' => $query->paginate(12),
            'genres' => Genre::orderBy('name')->get()
        ]);
    }
}