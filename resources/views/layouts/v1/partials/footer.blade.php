<footer class="bg-white border-t border-sigmaven-border pt-12 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <div class="col-span-1 md:col-span-2">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Sigmaven Logo" class="h-10 w-auto grayscale opacity-80">
                    <span class="text-2xl font-serif font-bold text-sigmaven-forest">Sigmaven.</span>
                </a>
                <p class="text-sm text-gray-500 max-w-sm">
                    A modern literary platform uniting book lovers through curated collections, educational games, and rare book auctions.
                </p>
                @auth
                    <div class="mt-4">
                        @if(auth()->user()->isPremium())
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-sigmaven-gold/10 text-sigmaven-gold border border-sigmaven-gold/20">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z" clip-rule="evenodd"></path></svg>
                                Premium Member
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                Regular Member
                            </span>
                        @endif
                    </div>
                @endauth
            </div>
            <div>
                <h3 class="text-sm font-semibold text-sigmaven-charcoal tracking-wider uppercase mb-4">Navigation</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-sigmaven-gold transition">Home</a></li>
                    <li><a href="{{ route('shop') }}" class="text-sm text-gray-500 hover:text-sigmaven-gold transition">Shop</a></li>
                    <li><a href="{{ route('upgrade.premium') }}" class="text-sm text-gray-500 hover:text-sigmaven-gold transition">Premium</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-sigmaven-charcoal tracking-wider uppercase mb-4">Legal</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm text-gray-500 hover:text-sigmaven-gold transition">Terms & Conditions</a></li>
                    <li><a href="#" class="text-sm text-gray-500 hover:text-sigmaven-gold transition">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-xs text-gray-400">&copy; {{ date('Y') }} Sigmaven Platform. All rights reserved.</p>
        </div>
    </div>
</footer>