<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('order.history') }}" class="text-gray-400 hover:text-sigmaven-forest transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="section-title mb-0">Order #{{ $order->order_number }}</h2>
    </div>

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

    <!-- Order Status Header -->
    <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-100 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start gap-4 border-b border-gray-100 pb-4 mb-4">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Order Status</p>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold {{ $statusColor }}">
                    <span class="w-2 h-2 rounded-full bg-current mr-2"></span>
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Order Date</p>
                <p class="font-medium text-sigmaven-charcoal">{{ $order->created_at->format('d F Y, H:i') }}</p>
            </div>
        </div>

        @if($order->status === 'delivered')
            <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-sm mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="font-bold text-indigo-800 mb-1">Your order has arrived!</h3>
                    <p class="text-sm text-indigo-600">Please confirm receipt once you have your order.</p>
                </div>
                <button wire:click="confirmReceived" class="btn btn-primary bg-indigo-600 hover:bg-indigo-700 border-none flex-shrink-0" wire:loading.attr="disabled">
                    <span wire:loading.remove>Confirm Receipt</span>
                    <span wire:loading>Processing...</span>
                </button>
            </div>
        @endif

        <!-- Items Purchased -->
        <h3 class="font-bold mb-4 text-sigmaven-charcoal">Items Purchased</h3>
        <div class="space-y-4">
            @foreach($order->items as $item)
                @php $subtotal = $item->price * $item->quantity; @endphp
                <div class="flex gap-4 border-b border-gray-50 pb-4 last:border-0 last:pb-0">
                    <div class="w-16 h-22 bg-gray-100 rounded flex-shrink-0 flex items-center justify-center overflow-hidden" style="height: 88px;">
                        @if($item->product && $item->product->cover_image)
                            <img src="{{ Storage::url($item->product->cover_image) }}" alt="{{ $item->product->title ?? 'Product' }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-sigmaven-charcoal">{{ $item->product->title ?? 'Product Deleted' }}</p>
                        <p class="text-sm text-gray-500">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        <p class="font-bold text-sigmaven-forest mt-1">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                        
                        @if($order->status === 'completed' && isset($reviewForms[$item->product_id]))
                            <div class="mt-4 bg-gray-50 p-4 rounded-sm border border-gray-200">
                                <h4 class="font-bold text-sm mb-3">Leave a Review</h4>
                                <form wire:submit.prevent="submitReview({{ $item->product_id }})">
                                    <div class="flex gap-1 mb-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button" wire:click="$set('reviewForms.{{ $item->product_id }}.rating', {{ $i }})" class="focus:outline-none transition-transform hover:scale-110">
                                                <svg class="w-7 h-7 {{ isset($reviewForms[$item->product_id]) && $reviewForms[$item->product_id]['rating'] >= $i ? 'text-yellow-400' : 'text-gray-200' }} transition-colors" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            </button>
                                        @endfor
                                    </div>
                                    <textarea wire:model="reviewForms.{{ $item->product_id }}.comment" rows="2" class="w-full text-sm border-gray-300 rounded focus:ring-sigmaven-forest focus:border-sigmaven-forest mb-3" placeholder="How was this product?"></textarea>
                                    <button type="submit" class="btn btn-secondary text-xs" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Submit Review</span>
                                        <span wire:loading>Submitting...</span>
                                    </button>
                                </form>
                            </div>
                        @elseif($order->status === 'completed')
                            <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Review submitted
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Shipping Info -->
        <div class="mt-6 border-t border-gray-100 pt-4">
            <h3 class="font-bold mb-3 text-sigmaven-charcoal">Shipping Address</h3>
            <div class="bg-gray-50 p-4 rounded-sm text-sm text-gray-700">
                <p class="whitespace-pre-line">{{ $order->address }}</p>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="mt-6 border-t border-gray-100 pt-4">
            <h3 class="font-bold mb-3 text-sigmaven-charcoal">Payment Summary</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Payment Method</span>
                    <span class="font-medium">{{ strtoupper(str_replace('_', ' ', $order->payment_method ?? '-')) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Subtotal ({{ $order->items->sum('quantity') }} items)</span>
                    <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Shipping</span>
                    <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                @if($order->discount_amount > 0)
                <div class="flex justify-between text-green-600">
                    <span>Discount</span>
                    <span>− Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between font-bold text-base pt-2 border-t border-gray-100">
                    <span>Total</span>
                    <span class="text-sigmaven-forest text-lg">Rp {{ number_format($order->final_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
