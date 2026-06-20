<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="flex mb-8 text-sm text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-sigmaven-forest">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('shop') }}" class="hover:text-sigmaven-forest">Shop</a>
        <span class="mx-2">/</span>
        <span class="text-sigmaven-charcoal">{{ $product->title }}</span>
    </nav>

    <div class="bg-white rounded-sm shadow-sm border border-gray-100 p-6 md:p-8 mb-12">
        <div class="flex flex-col md:flex-row gap-12">
            <!-- Product Image -->
            <div class="w-full md:w-1/3 flex-shrink-0">
                <div class="bg-gray-100 rounded overflow-hidden" style="aspect-ratio: 3/4;">
                    @if($product->cover_image)
                        <img src="{{ Storage::url($product->cover_image) }}" alt="{{ $product->title }}" class="object-cover w-full h-full">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 flex-col gap-2">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <span class="text-sm">No Cover</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="w-full md:w-2/3 flex flex-col">
                <div class="mb-2 flex flex-wrap gap-2">
                    @foreach($product->genres->take(3) as $genre)
                        <a href="{{ route('shop', ['genre' => $genre->slug]) }}" class="text-xs font-bold tracking-wider text-sigmaven-gold uppercase bg-sigmaven-gold/10 px-2 py-1 rounded hover:bg-sigmaven-gold/20 transition">{{ $genre->name }}</a>
                    @endforeach
                </div>
                <h1 class="text-3xl md:text-4xl font-serif font-bold text-sigmaven-forest mb-2">{{ $product->title }}</h1>
                <p class="text-lg text-gray-600 mb-4">by <span class="font-medium text-sigmaven-charcoal">{{ $product->author }}</span></p>
                
                <div class="flex items-center mb-6">
                    <livewire:components.rating-stars :rating="ceil($product->reviews->avg('rating') ?: 0)" :count="$product->reviews->count()" />
                </div>

                <div class="mb-6">
                    @if($product->discount_price)
                        <div class="flex items-end gap-3">
                            <span class="text-3xl font-bold text-sigmaven-forest">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            <span class="text-lg text-gray-400 line-through mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-sm bg-red-100 text-red-600 px-2 py-0.5 rounded font-medium mb-1">
                                {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
                            </span>
                        </div>
                    @else
                        <span class="text-3xl font-bold text-sigmaven-forest">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @endif
                </div>

                <div class="prose prose-sm text-gray-600 mb-8 max-w-none">
                    <p>{{ $product->description }}</p>
                </div>

                <div class="mt-auto border-t pt-6">
                    <div class="flex flex-wrap items-center gap-4">
                        @if($product->type == 'physical')
                            <div class="flex items-center border border-gray-300 rounded">
                                <button wire:click="decrement" class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition">−</button>
                                <span class="px-4 py-2 font-medium text-center min-w-[3rem] border-x border-gray-300">{{ $quantity }}</span>
                                <button wire:click="increment" class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition">+</button>
                            </div>
                        @endif
                        
                        @if($product->stock > 0 || $product->type == 'digital')
                            <button wire:click="addToCart" class="btn btn-primary px-8 py-3 text-base shadow-sm" wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    @if($product->type == 'digital')
                                        Buy Digital Book
                                    @else
                                        Add to Cart
                                    @endif
                                </span>
                                <span wire:loading>Adding...</span>
                            </button>
                        @else
                            <button disabled class="btn btn-secondary px-8 py-3 text-base opacity-60 cursor-not-allowed">Out of Stock</button>
                        @endif
                    </div>
                    
                    @if($product->type == 'physical')
                        <p class="text-sm text-gray-500 mt-4">
                            <svg class="w-4 h-4 inline mr-1 text-sigmaven-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            {{ $product->stock }} copies in stock
                        </p>
                    @else
                        <p class="text-sm text-sigmaven-admin-blue mt-4 flex items-center font-medium">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Digital product — instantly available after purchase
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Details & Reviews -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2">
            <h3 class="section-title">Customer Reviews</h3>
            @php
                $approvedReviews = $product->reviews()->where('is_approved', true)->paginate(5);
            @endphp
            <x-review-list :reviews="$approvedReviews" :productId="$product->id" />
        </div>
        
        <div>
            <h3 class="section-title">Book Details</h3>
            <div class="bg-white p-6 rounded border border-gray-100 shadow-sm">
                <ul class="space-y-4 text-sm">
                    <li class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">Publisher</span>
                        <span class="font-medium text-sigmaven-charcoal text-right">{{ $product->publisher ?? '-' }}</span>
                    </li>
                    <li class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">ISBN</span>
                        <span class="font-medium text-sigmaven-charcoal text-right">{{ $product->isbn ?? '-' }}</span>
                    </li>
                    <li class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">Format</span>
                        <span class="font-medium text-sigmaven-charcoal text-right capitalize">{{ $product->type }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-500">Genres</span>
                        <span class="font-medium text-sigmaven-charcoal text-right">{{ $product->genres->pluck('name')->join(', ') ?: '-' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    @if($relatedProducts->count() > 0)
    <div class="mt-16">
        <h2 class="section-title">Related Books</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $rel)
                <livewire:components.product-card :product="$rel" :wire:key="'rel-'.$rel->id" />
            @endforeach
        </div>
    </div>
    @endif
</div>