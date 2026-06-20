<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-serif font-bold text-sigmaven-forest mb-8">Keranjang Belanja</h1>

    @if($items->count() > 0)
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 text-sm uppercase tracking-wider">
                            <tr>
                                <th class="p-4 font-medium">Produk</th>
                                <th class="p-4 font-medium text-center">Kuantitas</th>
                                <th class="p-4 font-medium text-right">Total</th>
                                <th class="p-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($items as $item)
                                @php $price = $item->product->discount_price ?? $item->product->price; @endphp
                                <tr>
                                    <td class="p-4 flex items-center gap-4">
                                        <div class="w-16 h-20 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                            @if($item->product->cover_image)
                                                <img src="{{ Storage::url($item->product->cover_image) }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('product.detail', $item->product->slug) }}" class="font-medium text-sigmaven-charcoal hover:text-sigmaven-forest block line-clamp-1">{{ $item->product->title }}</a>
                                            <span class="text-sm text-gray-500">Rp {{ number_format($price, 0, ',', '.') }}</span>
                                        </div>
                                    </td>
                                    <td class="p-4 text-center">
                                        @if($item->product->type == 'physical')
                                            <div class="inline-flex items-center border border-gray-300 rounded">
                                                <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" class="px-2 py-1 text-gray-600 hover:bg-gray-100">-</button>
                                                <span class="px-4 py-1 text-sm border-x border-gray-300">{{ $item->quantity }}</span>
                                                <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" class="px-2 py-1 text-gray-600 hover:bg-gray-100" {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>+</button>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded">Digital (1)</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-right font-medium text-sigmaven-charcoal">
                                        Rp {{ number_format($price * $item->quantity, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 text-right">
                                        <button wire:click="removeItem({{ $item->id }})" class="text-red-400 hover:text-red-600 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h3 class="font-serif font-bold text-lg border-b pb-4 mb-4">Ringkasan Pesanan</h3>
                    <div class="flex justify-between mb-2 text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mb-4 text-gray-600">
                        <span>Estimasi Ongkir</span>
                        <span class="text-sm">Dihitung saat checkout</span>
                    </div>
                    <div class="border-t pt-4 flex justify-between font-bold text-lg mb-6">
                        <span>Total Belanja</span>
                        <span class="text-sigmaven-forest">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn btn-primary w-full text-center py-3">Lanjut ke Pembayaran</a>
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('shop') }}" class="text-sm text-sigmaven-gold hover:underline">Lanjutkan Belanja</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-16 bg-white rounded shadow-sm border border-gray-100">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h2 class="text-xl font-medium text-gray-900 mb-2">Keranjang Anda Kosong</h2>
            <p class="text-gray-500 mb-6">Belum ada buku yang ditambahkan ke keranjang belanja Anda.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary px-8">Mulai Belanja</a>
        </div>
    @endif
</div>