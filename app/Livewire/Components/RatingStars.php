<?php
namespace App\Livewire\Components;

use Livewire\Component;

class RatingStars extends Component {
    public $rating;
    public $count;

    public function mount($rating, $count = null) {
        $this->rating = $rating;
        $this->count = $count;
    }

    public function render() {
        return view('livewire.components.rating-stars');
    }
}