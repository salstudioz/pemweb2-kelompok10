<?php
namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Review;
use App\Models\Product;
use App\Traits\WithToast;

class ReviewForm extends Component {
    use WithToast;

    public $productId;
    public $showForm = false;
    public $rating = 5;
    public $title = '';
    public $comment = '';
    public $canReview = false;

    public function mount($productId) {
        $this->productId = $productId;
        $this->checkCanReview();
    }

    public function checkCanReview() {
        $user = auth()->user();
        if (!$user) {
            $this->canReview = false;
            return;
        }

        // Check if user has purchased this product
        $hasPurchased = $user->orders()
            ->whereHas('items', function($query) {
                $query->where('product_id', $this->productId);
            })
            ->whereIn('status', ['completed', 'delivered'])
            ->exists();

        // Check if already reviewed
        $alreadyReviewed = Review::where('user_id', $user->id)
            ->where('product_id', $this->productId)
            ->exists();

        $this->canReview = $hasPurchased && !$alreadyReviewed;
    }

    public function setRating($value) {
        $this->rating = $value;
    }

    public function getRatingText($rating) {
        return match($rating) {
            1 => 'Sangat Buruk',
            2 => 'Buruk',
            3 => 'Cukup',
            4 => 'Bagus',
            5 => 'Sangat Bagus',
            default => 'Pilih rating',
        };
    }

    public function submitReview() {
        if (!$this->canReview) {
            $this->notify('Anda tidak dapat memberikan review untuk produk ini.', 'error');
            return;
        }

        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|min:5|max:100',
            'comment' => 'required|string|min:10|max:500',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $this->productId,
            'rating' => $this->rating,
            'rating_text' => $this->getRatingText($this->rating),
            'title' => $this->title,
            'comment' => $this->comment,
            'is_approved' => true,
        ]);

        $this->reset(['rating', 'title', 'comment', 'showForm']);
        $this->canReview = false;
        
        $this->notify('Review berhasil dikirim!', 'success');
        $this->dispatch('review-added');
    }

    public function render() {
        return view('livewire.components.review-form');
    }
}