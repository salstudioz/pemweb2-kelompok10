<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Auction;

#[Layout('layouts.admin')]
class Dashboard extends Component {
    public function render() {
        return view('livewire.admin.dashboard', [
            'totalOrders' => Order::count(),
            'revenue' => Order::whereIn('status', ['processing', 'delivered', 'completed'])->sum('final_amount'),
            'totalProducts' => Product::count(),
            'totalUsers' => User::where('role', '!=', 'admin')->count(),
            'totalAuctions' => Auction::where('status', 'active')->count(),
            'recentOrders' => Order::with('user')->latest()->take(5)->get()
        ]);
    }
}