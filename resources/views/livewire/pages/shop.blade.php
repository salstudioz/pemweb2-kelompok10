<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        
        <!-- Sidebar Filter -->
        <div class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white p-6 rounded-sm shadow-sm border border-gray-100 sticky top-28">
                <h3 class="font-serif font-bold text-lg mb-4 text-sigmaven-forest">Search</h3>
                <div class="mb-6">
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search title / author..." class="w-full rounded border-gray-300 focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20 text-sm">
                </div>
                
                <h3 class="font-serif font-bold text-lg mb-4 text-sigmaven-forest border-t pt-4">Genres</h3>
                <ul class="space-y-2">
                    <li>
                        <button wire:click="$set('genre', '')" class="text-sm {{ $genre === '' || $genre === null ? 'text-sigmaven-gold font-bold' : 'text-gray-600 hover:text-sigmaven-forest' }}">All Genres</button>
                    </li>
                    @foreach($genres as $g)
                    <li>
                        <button wire:click="$set('genre', '{{ $g->slug }}')" class="text-sm {{ $genre === $g->slug ? 'text-sigmaven-gold font-bold' : 'text-gray-600 hover:text-sigmaven-forest' }}">{{ $g->name }}</button>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="flex-1">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-serif font-bold text-sigmaven-charcoal">Book Collection</h2>
                <select wire:model.live="sort" class="rounded border-gray-300 text-sm focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20">
                    <option value="latest">Latest</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                </select>
            </div>
            
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($products as $product)
                        <livewire:components.product-card :product="$product" :wire:key="'shop-'.$product->id" />
                    @endforeach
                </div>
                
                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white p-12 text-center rounded shadow-sm border border-gray-100">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-500">Try changing your search term or genre filter.</p>
                    <button wire:click="$set('search', ''); $set('genre', '')" class="mt-4 text-sigmaven-forest hover:underline font-medium">Reset Filters</button>
                </div>
            @endif
        </div>
    </div>
</div>