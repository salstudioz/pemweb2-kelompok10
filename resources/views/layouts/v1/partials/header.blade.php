<header x-data="{ mobileMenuOpen: false }" class="bg-white/90 backdrop-blur-md border-b border-sigmaven-border fixed w-full z-50 top-0 transition-all duration-300 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Sigmaven Logo" class="h-10 w-auto">
                    <span class="text-2xl font-serif font-bold text-sigmaven-forest tracking-tight">Sigmaven.</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}" class="text-sm font-medium text-sigmaven-charcoal hover:text-sigmaven-gold transition {{ request()->routeIs('home') ? 'text-sigmaven-gold' : '' }}">Home</a>
                <a href="{{ route('shop') }}" class="text-sm font-medium text-sigmaven-charcoal hover:text-sigmaven-gold transition {{ request()->routeIs('shop') ? 'text-sigmaven-gold' : '' }}">Shop</a>
                @auth
                    @if(auth()->user()->isPremium())
                        <a href="{{ route('sigame') }}" class="text-sm font-medium text-sigmaven-gold flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z" clip-rule="evenodd"></path></svg>
                            Sigame
                        </a>
                        <a href="{{ route('legacybid') }}" class="text-sm font-medium text-sigmaven-gold">LegacyBid</a>
                    @else
                        <a href="{{ route('upgrade.premium') }}" class="text-sm font-medium text-sigmaven-forest hover:text-sigmaven-gold font-bold transition">Get Premium</a>
                    @endif
                @endauth
            </nav>

            <!-- Actions -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <!-- Cart Badge Component -->
                    <livewire:components.cart-badge />
                    
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 text-sm font-medium focus:outline-none">
                            <span>{{ auth()->user()->name }}</span>
                            <span class="text-xs bg-sigmaven-gold text-white px-2 py-0.5 rounded-full">{{ auth()->user()->points }} pts</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition.opacity class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-dropdown py-1 border border-gray-100 z-50">
                            <a href="{{ route('account') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">My Account</a>
                            <a href="{{ route('wishlist') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Wishlist</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-sigmaven-forest font-bold hover:bg-gray-50">Admin Panel</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-sigmaven-charcoal hover:text-sigmaven-gold">Log in</a>
                    <a href="{{ route('register') }}" class="btn btn-primary text-sm">Register</a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-sigmaven-charcoal hover:text-sigmaven-gold focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-collapse class="md:hidden bg-white border-b border-sigmaven-border">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-sigmaven-charcoal">Home</a>
            <a href="{{ route('shop') }}" class="block px-3 py-2 rounded-md text-base font-medium text-sigmaven-charcoal">Shop</a>
            @auth
                @if(auth()->user()->isPremium())
                    <a href="{{ route('sigame') }}" class="block px-3 py-2 rounded-md text-base font-medium text-sigmaven-gold">Sigame</a>
                    <a href="{{ route('legacybid') }}" class="block px-3 py-2 rounded-md text-base font-medium text-sigmaven-gold">LegacyBid</a>
                @else
                    <a href="{{ route('upgrade.premium') }}" class="block px-3 py-2 rounded-md text-base font-medium text-sigmaven-forest font-bold">Get Premium</a>
                @endif
                <a href="{{ route('cart') }}" class="block px-3 py-2 rounded-md text-base font-medium text-sigmaven-forest">Cart</a>
                <a href="{{ route('account') }}" class="block px-3 py-2 rounded-md text-base font-medium text-sigmaven-charcoal">My Account</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-sigmaven-charcoal">Log in</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-sigmaven-forest">Register</a>
            @endauth
        </div>
    </div>
</header>