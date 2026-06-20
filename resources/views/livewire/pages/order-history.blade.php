<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-4 mb-8">
        <h2 class="section-title mb-0">My Orders</h2>
    </div>

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-100 hover:shadow-card transition-shadow">
                    <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-gray-100 pb-4 mb-4 gap-4">
                        <div>
                            <span class="text-xs text-gray-400 uppercase tracking-wide block mb-1">Order Date</span>
                            <span class="text-sm text-gray-600 block mb-1">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            <span class="font-bold text-sigmaven-charcoal">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-blue-100 text-blue-800',
                                    'shipped' => 'bg-indigo-100 text-indigo-800',
                                    'delivered' => 'bg-purple-100 text-purple-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $statusColor = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current mr-1.5"></span>
                                {{ ucfirst($order->status) }}
                            </span>
                            
                            @if(in_array($order->status, ['pending', 'processing']))
                                <button wire:click="cancelOrder({{ $order->id }})" 
                                        wire:confirm="Are you sure you want to cancel this order?"
                                        class="text-xs text-red-600 hover:text-red-800 hover:underline">
                                    Cancel Order
                                </button>
                            @endif
                            
                            @if($order->status === 'completed')
                                <a href="{{ route('order.detail', $order->id) }}" class="text-xs text-sigmaven-forest hover:text-green-700 hover:underline">
                                    Write Review
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-sm text-gray-600">{{ $order->items->count() }} {{ $order->items->count() == 1 ? 'item' : 'items' }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                <span class="font-medium">Payment:</span> {{ strtoupper(str_replace('_', ' ', $order->payment_method ?? '-')) }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400 mb-0.5">Total</p>
                            <p class="font-bold text-xl text-sigmaven-forest mb-2">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                            <a href="{{ route('order.detail', $order->id) }}" class="btn btn-secondary text-sm">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="bg-white p-16 text-center rounded-sm border border-gray-100 shadow-sm">
            <svg class="w-20 h-20 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            <h3 class="text-xl font-serif font-bold text-gray-700 mb-2">No orders yet</h3>
            <p class="text-gray-500 mb-6">Start exploring our book collection and place your first order!</p>
            <a href="{{ route('shop') }}" class="btn btn-primary">Start Shopping</a>
        </div>
    @endif
</div>
