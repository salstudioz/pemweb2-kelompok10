<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Order;
use App\Traits\WithToast;

#[Layout('layouts.admin')]
class Orders extends Component {
    use WithPagination, WithToast;

    public $search = '';
    public $statusFilter = '';

    public function updatingSearch() {
        $this->resetPage();
    }

    public function updatingStatusFilter() {
        $this->resetPage();
    }

    public function updateStatus($orderId, $status) {
        Order::find($orderId)->update(['status' => $status]);
        $this->notify('Status pesanan diperbarui', 'success');
    }

    public function render() {
        $orders = Order::with('user')
                      ->when($this->search, function($q) {
                          $q->where('order_number', 'like', '%' . $this->search . '%');
                      })
                      ->when($this->statusFilter, function($q) {
                          $q->where('status', $this->statusFilter);
                      })
                      ->latest()
                      ->paginate(15);
                      
        return view('livewire.admin.orders', ['orders' => $orders]);
    }
}