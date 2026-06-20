@props(['reviews', 'productId'])

<div class="mt-8">
    <h3 class="text-xl font-bold text-sigmaven-charcoal mb-4">Review Pelanggan</h3>
    
    @if($reviews->count() > 0)
        <div class="space-y-6">
            @foreach($reviews as $review)
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-sigmaven-cream rounded-full flex items-center justify-center text-sigmaven-forest font-bold text-lg">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $review->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $review->formatted_date }}</p>
                                </div>
                            </div>
                            @if($review->title)
                                <h4 class="font-bold text-lg text-sigmaven-charcoal mb-1">{{ $review->title }}</h4>
                            @endif
                        </div>
                        <div class="text-right">
                            <x-review-stars :rating="$review->rating" size="md" show-text="true" />
                        </div>
                    </div>
                    
                    <p class="text-gray-700 mb-3">{{ $review->comment }}</p>
                    
                    @if($review->rating_text)
                        <div class="flex items-center gap-2 text-sm">
                            <span class="text-gray-500">Rating:</span>
                            <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-full font-medium">{{ $review->rating_text }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        
        @if($reviews->hasPages())
            <div class="mt-6">
                {{ $reviews->links() }}
            </div>
        @endif
    @else
        <div class="bg-gray-50 p-8 text-center rounded-lg border border-gray-100">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
            <p class="text-gray-500 mb-2">Belum ada review untuk produk ini.</p>
            <p class="text-sm text-gray-400">Jadilah yang pertama memberikan review!</p>
        </div>
    @endif
    
    <!-- Review Form -->
    <div class="mt-8 pt-6 border-t border-gray-100">
        <livewire:components.review-form :productId="$productId" />
    </div>
</div>