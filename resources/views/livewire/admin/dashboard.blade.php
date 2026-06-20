<div>
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Overview</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 border-l-4 border-l-blue-500">
            <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
            <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($revenue, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 border-l-4 border-l-yellow-500">
            <p class="text-sm text-gray-500 mb-1">Total User</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalUsers) }}</h3>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 border-l-4 border-l-purple-500">
            <p class="text-sm text-gray-500 mb-1">Total Buku</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalProducts) }}</h3>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 border-l-4 border-l-red-500">
            <p class="text-sm text-gray-500 mb-1">Lelang Aktif</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalAuctions) }}</h3>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Pesanan Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-500 uppercase">
                    <tr>
                        <th class="px-6 py-3 font-medium">Order ID</th>
                        <th class="px-6 py-3 font-medium">Pelanggan</th>
                        <th class="px-6 py-3 font-medium">Total</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentOrders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-sigmaven-admin-blue">{{ $order->order_number }}</td>
                        <td class="px-6 py-4">{{ $order->user->name }}</td>
                        <td class="px-6 py-4 font-medium">Rp {{ number_format($order->grand_total ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>