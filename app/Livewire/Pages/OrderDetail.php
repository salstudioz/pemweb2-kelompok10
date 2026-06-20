<?php
namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Traits\WithToast;

#[Layout('layouts.app')]
class OrderDetail extends Component {
    use WithToast;

    public $order;
    public $reviewForms = [];

    public function mount($id) {
        $this->order = Auth::user()->orders()->with('items.product')->findOrFail($id);
        
        if ($this->order->status === 'completed') {
            foreach ($this->order->items as $item) {
                if (!$item->product) continue;
                $hasReviewed = Review::where('user_id', Auth::id())
                    ->where('product_id', $item->product_id)
                    ->exists();

                if (!$hasReviewed) {
                    $this->reviewForms[$item->product_id] = [
                        'rating' => 5,
                        'comment' => ''
                    ];
                }
            }
        }
    }

    public function confirmReceived() {
        if ($this->order->status === 'delivered') {
            $this->order->update(['status' => 'completed']);
            $this->notify('Order confirmed! You can now leave a review.', 'success');
            return redirect()->route('order.detail', $this->order->id);
        }
    }

    public function submitReview($productId) {
        $this->validate([
            "reviewForms.{$productId}.rating" => 'required|integer|min:1|max:5',
            "reviewForms.{$productId}.comment" => 'nullable|string|max:500',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'rating' => $this->reviewForms[$productId]['rating'],
            'comment' => $this->reviewForms[$productId]['comment'],
            'is_approved' => true,
        ]);

        unset($this->reviewForms[$productId]);
        $this->notify('Review submitted successfully!', 'success');
    }

    public function render() {
        return view('livewire.pages.order-detail');
    }
}
