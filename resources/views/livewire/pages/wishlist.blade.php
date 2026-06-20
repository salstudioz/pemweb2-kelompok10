<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-serif font-bold text-sigmaven-forest mb-8">Wishlist Saya</h1>

    @if($wishlists->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($wishlists as $wishlist)
                <livewire:components.product-card :product="$wishlist->product" :wire:key="'wish-'.$wishlist->id" />
            @endforeach
        </div>
    @else
        <div class="text-center py-16 bg-white rounded shadow-sm border border-gray-100">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </div>
            <h2 class="text-xl font-medium text-gray-900 mb-2">Wishlist Kosong</h2>
            <p class="text-gray-500 mb-6">Tambahkan buku impian Anda ke daftar wishlist agar mudah ditemukan nanti.</p>
            <a href="{{ route('shop') }}" class="btn btn-secondary">Eksplorasi Buku</a>
        </div>
    @endif
</div>