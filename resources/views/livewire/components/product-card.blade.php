<div class="card overflow-hidden flex flex-col group relative">
    <div class="absolute top-2 right-2 z-10">
        <button wire:click="toggleWishlist" class="p-2 bg-white rounded-full shadow hover:bg-gray-50 transition">
            <svg class="w-5 h-5 {{ $inWishlist ? 'text-red-500 fill-current' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </button>
    </div>
    
    <a href="{{ route('product.detail', $product->slug) }}" class="block aspect-w-3 aspect-h-4 bg-gray-200 overflow-hidden">
        @if($product->cover_image)
            <img src="{{ Storage::url($product->cover_image) }}" alt="{{ $product->title }}" class="object-cover w-full h-full group-hover:scale-105 transition duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-400 font-serif text-sm">No Cover</div>
        @endif
        
        @if($product->type == 'digital')
            <div class="absolute top-2 left-2 bg-sigmaven-admin-blue text-white text-xs px-2 py-1 rounded font-medium">Digital</div>
        @endif
    </a>
    
    <div class="p-4 flex flex-col flex-grow">
        <a href="{{ route('product.detail', $product->slug) }}">
            <h3 class="font-serif font-bold text-lg text-sigmaven-charcoal line-clamp-2 hover:text-sigmaven-forest transition">{{ $product->title }}</h3>
        </a>
        <p class="text-sm text-gray-500 mb-2">{{ $product->author }}</p>
        
        <div class="mt-auto">
            <div class="flex items-center justify-between mb-4">
                <div>
                    @if($product->discount_price)
                        <span class="text-lg font-bold text-sigmaven-forest">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                        <span class="text-xs text-gray-400 line-through block">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @else
                        <span class="text-lg font-bold text-sigmaven-forest">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @endif
                </div>
            </div>
            
            <button wire:click="addToCart" class="w-full btn btn-primary flex items-center justify-center" {{ $product->stock < 1 && $product->type == 'physical' ? 'disabled' : '' }}>
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                {{ $product->stock < 1 && $product->type == 'physical' ? 'Habis' : 'Add to Cart' }}
            </button>
        </div>
    </div>
</div>