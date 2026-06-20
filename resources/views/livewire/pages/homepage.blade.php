<div>
    <!-- Hero Slider -->
    <section x-data="{
            slide: 0,
            slides: [
                { title: 'Explore the World of Books with Sigmaven', text: 'Discover the finest books, join exclusive auctions, and play literary games.', cta: 'Start Shopping', ctaLink: '{{ route('shop') }}' },
                { title: 'Limited Premium Collections', text: 'Get access to rare and vintage books with our LegacyBid auction feature.', cta: 'Join Premium', ctaLink: '{{ route('upgrade.premium') }}' },
                { title: 'Challenge Yourself in Sigame', text: 'Play educational games, collect points, and redeem them for amazing rewards.', cta: 'Learn More', ctaLink: '{{ route('upgrade.premium') }}' }
            ],
            init() {
                setInterval(() => {
                    this.slide = (this.slide + 1) % this.slides.length;
                }, 5000);
            }
        }" class="bg-sigmaven-forest text-white relative overflow-hidden" style="height: 480px;">

        <div class="absolute inset-0 bg-sigmaven-forest/70"></div>

        <!-- Background pattern – menggunakan SVG tanpa backslash -->
        <!-- <div class="absolute inset-0 opacity-5" style="background-image: url(/public/images/book.svg); background-size: 80px;"></div> -->

        <div class="relative z-10 h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                @foreach([
                    ['title' => 'Explore the World of Books with Sigmaven', 'text' => 'Discover the finest books, join exclusive auctions, and play literary games.'],
                    ['title' => 'Limited Premium Collections', 'text' => 'Get access to rare and vintage books with our LegacyBid auction feature.'],
                    ['title' => 'Challenge Yourself in Sigame', 'text' => 'Play educational games, collect points, and redeem them for amazing rewards.']
                ] as $idx => $s)
                    <div x-show="slide === {{ $idx }}"
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-4"
                         class="text-center" @if($idx > 0) style="display:none;" @endif>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif font-bold mb-6 leading-tight">{{ $s['title'] }}</h1>
                        <p class="text-lg md:text-xl text-sigmaven-cream/90 mb-8 max-w-2xl mx-auto">{{ $s['text'] }}</p>
                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <a href="{{ route('shop') }}" class="btn bg-sigmaven-gold hover:bg-sigmaven-gold-dark text-white px-8 py-3 text-lg rounded shadow-lg transition-all hover:shadow-xl hover:-translate-y-0.5">Start Shopping</a>
                            <a href="{{ route('upgrade.premium') }}" class="btn border-2 border-white text-white hover:bg-white hover:text-sigmaven-forest px-8 py-3 text-lg rounded transition-all">Join Premium</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Slide dots -->
        <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-3 z-20">
            @for($i = 0; $i < 3; $i++)
                <button @click="slide = {{ $i }}"
                        :class="slide === {{ $i }} ? 'bg-white w-8' : 'bg-white/40 w-3'"
                        class="h-3 rounded-full transition-all duration-300"></button>
            @endfor
        </div>
    </section>

    <!-- Genre Slider -->
    <section class="py-12 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="section-title mb-0">Explore Genres</h2>
                <a href="{{ route('shop') }}" class="text-sm text-sigmaven-gold hover:underline font-medium">View All &rarr;</a>
            </div>
            <div class="relative group" x-data>
                <div x-ref="genreSlider" class="flex gap-4 overflow-x-auto scroll-smooth scrollbar-hide py-2">
                    @foreach($genres as $genre)
                        <a href="{{ route('shop', ['genre' => $genre->slug]) }}" class="flex-shrink-0 w-36 text-center group/card">
                            <div class="bg-sigmaven-cream rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 border border-transparent hover:border-sigmaven-gold/30 overflow-hidden">
                                @if($genre->image_url)
                                    <img src="{{ filter_var($genre->image_url, FILTER_VALIDATE_URL) ? $genre->image_url : asset($genre->image_url) }}" alt="{{ $genre->name }}" class="w-full h-28 object-cover opacity-85 group-hover/card:opacity-100 transition-opacity duration-300">
                                @else
                                    <div class="w-full h-28 bg-gradient-to-br from-sigmaven-forest/10 to-sigmaven-gold/20 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-sigmaven-forest/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                @endif
                                <div class="p-3 bg-white">
                                    <span class="block text-xs font-bold text-sigmaven-charcoal group-hover/card:text-sigmaven-forest transition-colors">{{ $genre->name }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <button @click="$refs.genreSlider.scrollBy({left: -400, behavior: 'smooth'})" class="absolute -left-3 top-1/2 -translate-y-1/2 bg-white text-sigmaven-forest shadow-lg p-2 rounded-full hover:bg-sigmaven-cream opacity-0 group-hover:opacity-100 transition z-10 border border-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="$refs.genreSlider.scrollBy({left: 400, behavior: 'smooth'})" class="absolute -right-3 top-1/2 -translate-y-1/2 bg-white text-sigmaven-forest shadow-lg p-2 rounded-full hover:bg-sigmaven-cream opacity-0 group-hover:opacity-100 transition z-10 border border-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    @if($featuredProducts->count() > 0)
        <section class="py-16 px-4 max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-8">
                <h2 class="section-title mb-0">Featured Collection</h2>
                <a href="{{ route('shop') }}" class="text-sigmaven-gold hover:underline font-medium text-sm">View All &rarr;</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                    <livewire:components.product-card :product="$product" :wire:key="'feat-'.$product->id" />
                @endforeach
            </div>
        </section>
    @endif

    <!-- Info Section -->
    <section class="bg-sigmaven-cream py-16 px-4 border-y border-sigmaven-border">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="p-6">
                <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center shadow-sm mb-4 text-sigmaven-forest">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="font-serif font-bold text-xl mb-2">Extensive Collection</h3>
                <p class="text-gray-600">Thousands of fiction and non-fiction books from leading publishers worldwide.</p>
            </div>
            <div class="p-6">
                <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center shadow-sm mb-4 text-sigmaven-gold">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="font-serif font-bold text-xl mb-2">Interactive Sigame</h3>
                <p class="text-gray-600">Premium exclusive: play literary games and collect amazing rewards.</p>
            </div>
            <div class="p-6">
                <div class="w-16 h-16 mx-auto bg-white rounded-full flex items-center justify-center shadow-sm mb-4 text-sigmaven-forest">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 11V9a2 2 0 00-2-2m2 4v4a2 2 0 104 0v-1m-4-3H9m2 0h4m6 1a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-serif font-bold text-xl mb-2">LegacyBid Auctions</h3>
                <p class="text-gray-600">Discover rare books and vintage collections through our exclusive auction system.</p>
            </div>
        </div>
    </section>

    <!-- Latest Products -->
    <section class="py-16 px-4 max-w-7xl mx-auto">
        <div class="flex justify-between items-end mb-8">
            <h2 class="section-title mb-0">Latest Releases</h2>
            <a href="{{ route('shop') }}" class="text-sigmaven-gold hover:underline font-medium text-sm">View All &rarr;</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($latestProducts as $product)
                <livewire:components.product-card :product="$product" :wire:key="'latest-'.$product->id" />
            @endforeach
        </div>
    </section>
</div>