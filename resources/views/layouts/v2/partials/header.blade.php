<header x-data="{ mobileMenuOpen: false }" class="bg-surface/95 backdrop-blur-md border-b border-border-color fixed w-full z-50 top-0 transition-all duration-300 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Sigmaven Logo" class="h-10 w-auto">
                    <span class="text-2xl font-serif font-bold text-primary tracking-tight">Sigmaven.</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}" 
                   class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-primary font-semibold' : 'text-text-secondary hover:text-primary' }}">
                    Home
                </a>
                <a href="{{ route('shop') }}" 
                   class="text-sm font-medium transition-colors duration-200 {{ request()->routeIs('shop') ? 'text-primary font-semibold' : 'text-text-secondary hover:text-primary' }}">
                    Shop
                </a>
                @auth
                    @if(auth()->user()->isPremium())
                        <a href="{{ route('sigame') }}" 
                           class="text-sm font-medium text-secondary hover:text-secondary-dark transition-colors duration-200 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z" clip-rule="evenodd"></path>
                            </svg>
                            Sigame
                        </a>
                        <a href="{{ route('legacybid') }}" 
                           class="text-sm font-medium text-secondary hover:text-secondary-dark transition-colors duration-200">
                            LegacyBid
                        </a>
                    @else
                        <a href="{{ route('upgrade.premium') }}" 
                           class="text-sm font-medium text-highlight hover:text-highlight-dark font-semibold transition-colors duration-200 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z" clip-rule="evenodd"></path>
                            </svg>
                            Get Premium
                        </a>
                    @endif
                @endauth
            </nav>

            <!-- Actions (Desktop) -->
            <div class="hidden md:flex items-center space-x-3">
                @auth
                    <!-- Cart Badge -->
                    <livewire:components.cart-badge />
                    
                    <!-- User Dropdown -->
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen" 
                                class="flex items-center gap-2 text-sm font-medium text-text-primary hover:text-primary transition-colors duration-200 focus:outline-none">
                            <div class="w-7 h-7 bg-primary-100 rounded-full flex items-center justify-center text-xs font-bold text-primary">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="hidden lg:inline">{{ auth()->user()->name }}</span>
                            <span class="text-xs bg-highlight text-white px-2 py-0.5 rounded-xs font-semibold">
                                {{ auth()->user()->points }} pts
                            </span>
                            <svg class="w-4 h-4 text-text-muted transition-transform duration-200" 
                                 :class="dropdownOpen ? 'rotate-180' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="dropdownOpen" 
                             @click.away="dropdownOpen = false" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                             class="absolute right-0 mt-2 w-52 bg-surface rounded-md shadow-dropdown py-1 border border-border-color z-50"
                             style="display: none;">
                            <a href="{{ route('account') }}" 
                               class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-text-secondary hover:text-text-primary hover:bg-background transition-colors duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                My Account
                            </a>
                            <a href="{{ route('wishlist') }}" 
                               class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-text-secondary hover:text-text-primary hover:bg-background transition-colors duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                Wishlist
                            </a>
                            @if(auth()->user()->isAdmin())
                                <div class="border-t border-border-color my-1"></div>
                                <a href="{{ route('admin.dashboard') }}" 
                                   class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-primary font-semibold hover:bg-primary-50 transition-colors duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Admin Panel
                                </a>
                            @endif
                            <div class="border-t border-border-color my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-error hover:bg-error-light transition-colors duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" 
                       class="text-sm font-medium text-text-secondary hover:text-primary transition-colors duration-200">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary text-sm">
                        Register
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Toggle -->
            <div class="flex items-center gap-3 md:hidden">
                @auth
                    <livewire:components.cart-badge />
                @endauth
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="text-text-secondary hover:text-primary focus:outline-none transition-colors duration-200 p-1">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-collapse 
         class="md:hidden bg-surface border-b border-border-color shadow-dropdown">
        <div class="px-4 pt-3 pb-4 space-y-1">
            <a href="{{ route('home') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition-colors duration-150 {{ request()->routeIs('home') ? 'bg-primary-50 text-primary' : 'text-text-secondary hover:bg-background hover:text-text-primary' }}">
                Home
            </a>
            <a href="{{ route('shop') }}" 
               class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium transition-colors duration-150 {{ request()->routeIs('shop') ? 'bg-primary-50 text-primary' : 'text-text-secondary hover:bg-background hover:text-text-primary' }}">
                Shop
            </a>
            @auth
                @if(auth()->user()->isPremium())
                    <a href="{{ route('sigame') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-secondary hover:bg-secondary-50 transition-colors duration-150">
                        Sigame
                    </a>
                    <a href="{{ route('legacybid') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-secondary hover:bg-secondary-50 transition-colors duration-150">
                        LegacyBid
                    </a>
                @else
                    <a href="{{ route('upgrade.premium') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-semibold text-highlight hover:bg-highlight-50 transition-colors duration-150">
                        Get Premium
                    </a>
                @endif
                <div class="border-t border-border-color my-2"></div>
                <a href="{{ route('account') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-text-secondary hover:bg-background hover:text-text-primary transition-colors duration-150">
                    My Account
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-error hover:bg-error-light transition-colors duration-150">
                        Logout
                    </button>
                </form>
            @else
                <div class="border-t border-border-color my-2"></div>
                <a href="{{ route('login') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium text-text-secondary hover:bg-background hover:text-text-primary transition-colors duration-150">
                    Log in
                </a>
                <a href="{{ route('register') }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm font-medium bg-primary text-white hover:bg-primary-dark transition-colors duration-150">
                    Register
                </a>
            @endauth
        </div>
    </div>
</header>