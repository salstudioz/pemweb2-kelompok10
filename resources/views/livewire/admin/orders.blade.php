<div x-data="{ openModal: false, selectedOrder: null }">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Order Management</h2>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6">
        <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row gap-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search by order number..." class="w-full md:w-1/3 rounded-lg border-gray-300 text-sm focus:border-sigmaven-admin-blue focus:ring focus:ring-sigmaven-admin-blue/20">
            <select wire:model.live="statusFilter" class="w-full md:w-1/4 rounded-lg border-gray-300 text-sm focus:border-sigmaven-admin-blue focus:ring focus:ring-sigmaven-admin-blue/20">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Order ID</th>
                        <th class="px-6 py-3 font-semibold">Customer</th>
                        <th class="px-6 py-3 font-semibold">Total</th>
                        <th class="px-6 py-3 font-semibold">Payment</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold">View</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-semibold text-sigmaven-admin-blue">{{ $order->order_number }}</td>
                        <td class="px-6 py-4">
                            <span class="block font-medium text-gray-800">{{ $order->user->name ?? 'N/A' }}</span>
                            <span class="text-xs text-gray-400">{{ $order->created_at->format('d M Y H:i') }}</span>
                        </td>
                        <td class="px-6 py-4 font-semibold">Rp {{ number_format($order->grand_total ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">
                                {{ strtoupper(str_replace('_', ' ', $order->payment_method ?? '-')) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <select wire:change="updateStatus({{ $order->id }}, $event.target.value)" class="text-xs rounded-full border-0 py-1 pl-2.5 pr-6 font-semibold cursor-pointer {{ 
                                $order->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                ($order->status == 'processing' ? 'bg-blue-100 text-blue-800' :
                                ($order->status == 'delivered' ? 'bg-purple-100 text-purple-800' :
                                ($order->status == 'shipped' ? 'bg-indigo-100 text-indigo-800' :
                                ($order->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'))))
                            }}">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </td>
                        <td class="px-6 py-4">
                            <button @click="openModal = true; selectedOrder = {{ json_encode($order->load('user')->toArray()) }}" class="p-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition" title="View Details">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">No orders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
    </div>

    <!-- Order Detail Modal -->
    <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;" @keydown.escape.window="openModal = false">
        <div @click="openModal = false" class="absolute inset-0 bg-black/60"></div>
        <div x-show="openModal" x-transition class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl z-10">
            <div class="flex justify-between items-center p-6 border-b">
                <h3 class="text-lg font-bold text-gray-900">
                    Order Details — <span class="text-sigmaven-admin-blue" x-text="selectedOrder?.order_number"></span>
                </h3>
                <button @click="openModal = false" class="p-1 rounded-lg hover:bg-gray-100 transition text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 space-y-4 text-sm">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-400 mb-1">Transaction Date</p>
                        <p class="font-medium" x-text="selectedOrder?.created_at ? new Date(selectedOrder.created_at).toLocaleString() : '-'"></p>
                    </div>
                    <div>
                        <p class="text-gray-400 mb-1">Customer</p>
                        <p class="font-medium" x-text="selectedOrder?.user?.name ?? 'N/A'"></p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-400 mb-1">Shipping Address</p>
                        <p class="font-medium bg-gray-50 p-3 rounded" x-text="selectedOrder?.address ?? '-'"></p>
                    </div>
                    <div>
                        <p class="text-gray-400 mb-1">Payment Method</p>
                        <p class="font-medium" x-text="(selectedOrder?.payment_method ?? '-').replace(/_/g, ' ').toUpperCase()"></p>
                    </div>
                    <div>
                        <p class="text-gray-400 mb-1">Total Payment</p>
                        <p class="font-bold text-sigmaven-forest text-base" x-text="'Rp ' + (selectedOrder?.grand_total ?? 0).toLocaleString('id-ID')"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>