<footer class="bg-surface border-t border-border-color pt-12 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-2">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 mb-4 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Sigmaven Logo" class="h-10 w-auto opacity-80 group-hover:opacity-100 transition-opacity duration-200">
                    <span class="text-2xl font-serif font-bold text-primary">Sigmaven.</span>
                </a>
                <p class="text-sm text-text-secondary max-w-sm leading-relaxed">
                    A modern literary platform uniting book lovers through curated collections, educational games, and rare book auctions.
                </p>
                @auth
                    <div class="mt-4">
                        @if(auth()->user()->isPremium())
                            <span class="inline-flex items-center px-2.5 py-1 rounded-xs text-xs font-semibold bg-highlight-100 text-highlight border border-highlight/20">
                                <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z" clip-rule="evenodd"></path>
                                </svg>
                                Premium Member
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-xs text-xs font-medium bg-background text-text-muted border border-border-color">
                                Regular Member
                            </span>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Navigation -->
            <div>
                <h3 class="text-label text-text-primary mb-4">Navigation</h3>
                <ul class="space-y-2.5">
                    <li>
                        <a href="{{ route('home') }}" class="text-sm text-text-secondary hover:text-primary transition-colors duration-200">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shop') }}" class="text-sm text-text-secondary hover:text-primary transition-colors duration-200">
                            Shop
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('upgrade.premium') }}" class="text-sm text-text-secondary hover:text-primary transition-colors duration-200">
                            Premium
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h3 class="text-label text-text-primary mb-4">Legal</h3>
                <ul class="space-y-2.5">
                    <li>
                        <a href="#" class="text-sm text-text-secondary hover:text-primary transition-colors duration-200">
                            Terms &amp; Conditions
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-text-secondary hover:text-primary transition-colors duration-200">
                            Privacy Policy
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="border-t border-border-color pt-6 flex flex-col sm:flex-row justify-between items-center gap-3">
            <p class="text-xs text-text-muted">&copy; {{ date('Y') }} Sigmaven Platform. All rights reserved.</p>
            <p class="text-xs text-text-muted">Made with ♥ for book lovers</p>
        </div>
    </div>
</footer>