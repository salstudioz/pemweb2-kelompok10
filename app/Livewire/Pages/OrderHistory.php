<?php
namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Traits\WithToast;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class OrderHistory extends Component {
    use WithPagination, WithToast;

    public function cancelOrder($orderId) {
        $order = Auth::user()->orders()->findOrFail($orderId);
        
        // Check if order can be cancelled
        if (!in_array($order->status, ['pending', 'processing'])) {
            $this->toast('Order tidak dapat dibatalkan karena status sudah ' . $order->status, 'error');
            return;
        }
        
        try {
            DB::beginTransaction();
            
            // Update order status
            $order->update([
                'status' => 'cancelled',
                'payment_status' => 'refunded'
            ]);
            
            // Restock products
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
            
            DB::commit();
            $this->toast('Order berhasil dibatalkan!', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->toast('Gagal membatalkan order: ' . $e->getMessage(), 'error');
        }
    }

    public function render() {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('livewire.pages.order-history', [
            'orders' => $orders
        ]);
    }
}
