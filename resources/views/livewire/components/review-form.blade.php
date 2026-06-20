<div class="review-form" x-data="{ 
    hoverRating: {{ $rating }},
    ratingText: '{{ $this->getRatingText($rating) }}'
}">
    @if($canReview)
        @if(!$showForm)
            <button wire:click="$set('showForm', true)" class="btn btn-primary mb-6">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                </svg>
                Tulis Review
            </button>
        @endif

        @if($showForm)
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-6">
                <h3 class="font-bold text-lg text-sigmaven-charcoal mb-4">Tulis Review Anda</h3>
                
                <div class="mb-6">
                    <p class="text-sm text-gray-600 mb-2">Rating:</p>
                    <div class="flex items-center gap-2 mb-1">
                        @for($i = 1; $i <= 5; $i++)
                            <button 
                                type="button"
                                wire:click="setRating({{ $i }})"
                                @mouseover="hoverRating = {{ $i }}; ratingText = '{{ $this->getRatingText($i) }}'"
                                @mouseleave="hoverRating = {{ $rating }}"
                                class="p-1 focus:outline-none transition-transform hover:scale-110"
                            >
                                <svg class="w-8 h-8 {{ $i <= (hoverRating ?: $rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </button>
                        @endfor
                    </div>
                    <p class="text-sm font-medium text-gray-800" x-text="ratingText"></p>
                </div>

                <form wire:submit="submitReview" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Review</label>
                        <input type="text" wire:model="title" class="w-full rounded-lg border-gray-300 focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20" placeholder="Misal: Buku yang sangat bagus!" required>
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Komentar</label>
                        <textarea wire:model="comment" rows="4" class="w-full rounded-lg border-gray-300 focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20" placeholder="Bagikan pengalaman Anda dengan produk ini..." required></textarea>
                        @error('comment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" wire:click="$set('showForm', false)" class="btn btn-secondary flex-1">Batal</button>
                        <button type="submit" class="btn btn-primary flex-1">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Kirim Review
                        </button>
                    </div>
                </form>
            </div>
        @endif
    @else
        @auth
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <p class="text-gray-600 text-sm">
                    @php
                        $user = auth()->user();
                        $hasPurchased = $user->orders()
                            ->whereHas('items', function($query) use ($productId) {
                                $query->where('product_id', $productId);
                            })
                            ->whereIn('status', ['completed', 'delivered'])
                            ->exists();
                        
                        $alreadyReviewed = \App\Models\Review::where('user_id', $user->id)
                            ->where('product_id', $productId)
                            ->exists();
                    @endphp

                    @if(!$hasPurchased)
                        Anda perlu membeli produk ini terlebih dahulu untuk dapat memberikan review.
                    @elseif($alreadyReviewed)
                        Anda sudah memberikan review untuk produk ini.
                    @endif
                </p>
            </div>
        @else
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <p class="text-gray-600 text-sm">
                    <a href="{{ route('login') }}" class="text-sigmaven-forest hover:underline">Login</a> 
                    untuk memberikan review produk.
                </p>
            </div>
        @endauth
    @endif
</div>