<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sigmaven') }} — Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-background text-text-primary font-sans flex h-screen overflow-hidden min-w-[320px]">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-admin-sidebar text-white flex flex-col flex-shrink-0 hidden md:flex">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-white/10 gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Sigmaven" class="h-8 w-auto brightness-0 invert opacity-90">
            <span class="text-lg font-bold tracking-wide font-serif hidden lg:inline">Admin</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-5 space-y-0.5 overflow-y-auto scrollbar-hide">
            <p class="text-label text-white/30 px-4 pt-2 pb-3">Main Menu</p>

            <a href="{{ route('admin.dashboard') }}" 
               class="{{ request()->routeIs('admin.dashboard') ? 'admin-nav-link-active' : 'admin-nav-link' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="hidden lg:inline">Dashboard</span>
                <span class="lg:hidden text-xs">Dash</span>
            </a>

            <a href="{{ route('admin.products') }}" 
               class="{{ request()->routeIs('admin.products') ? 'admin-nav-link-active' : 'admin-nav-link' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <span class="hidden lg:inline">Products</span>
                <span class="lg:hidden text-xs">Prod</span>
            </a>

            <a href="{{ route('admin.genres') }}" 
               class="{{ request()->routeIs('admin.genres') ? 'admin-nav-link-active' : 'admin-nav-link' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <span class="hidden lg:inline">Genres</span>
                <span class="lg:hidden text-xs">Genr</span>
            </a>

            <a href="{{ route('admin.orders') }}" 
               class="{{ request()->routeIs('admin.orders') ? 'admin-nav-link-active' : 'admin-nav-link' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span class="hidden lg:inline">Orders</span>
                <span class="lg:hidden text-xs">Ord</span>
            </a>

            <a href="{{ route('admin.users') }}" 
               class="{{ request()->routeIs('admin.users') ? 'admin-nav-link-active' : 'admin-nav-link' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span class="hidden lg:inline">Users</span>
                <span class="lg:hidden text-xs">Usr</span>
            </a>

            <p class="text-label text-white/30 px-4 pt-4 pb-3">Features</p>

            <a href="{{ route('admin.games') }}" 
               class="{{ request()->routeIs('admin.games') ? 'admin-nav-link-active' : 'admin-nav-link' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path>
                </svg>
                <span class="hidden lg:inline">Sigame</span>
                <span class="lg:hidden text-xs">Game</span>
            </a>

            <a href="{{ route('admin.auctions') }}" 
               class="{{ request()->routeIs('admin.auctions') ? 'admin-nav-link-active' : 'admin-nav-link' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="hidden lg:inline">Auctions</span>
                <span class="lg:hidden text-xs">Auct</span>
            </a>

            <a href="{{ route('admin.coupons') }}" 
               class="{{ request()->routeIs('admin.coupons') ? 'admin-nav-link-active' : 'admin-nav-link' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path>
                </svg>
                <span class="hidden lg:inline">Coupons</span>
                <span class="lg:hidden text-xs">Coup</span>
            </a>
        </nav>

        <!-- User & Logout -->
        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3 mb-3 px-2">
                <div class="w-8 h-8 bg-accent/30 rounded-full flex items-center justify-center text-sm font-bold text-white">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate text-white">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-white/50 truncate">Administrator</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-white/60 hover:text-white hover:bg-error/20 rounded-md transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden">
        <!-- Admin Header -->
        <header class="h-16 bg-admin-header shadow-sm flex items-center px-4 sm:px-6 border-b border-white/10 flex-shrink-0">
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-2 text-sm">
                    <a href="{{ route('home') }}" target="_blank" 
                       class="text-white/60 hover:text-white transition flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        View Site
                    </a>
                    <span class="text-white/30">/</span>
                    <span class="font-semibold text-white">
                        @if(request()->routeIs('admin.dashboard')) Dashboard
                        @elseif(request()->routeIs('admin.products')) Products
                        @elseif(request()->routeIs('admin.genres')) Genres
                        @elseif(request()->routeIs('admin.orders')) Orders
                        @elseif(request()->routeIs('admin.users')) Users
                        @elseif(request()->routeIs('admin.games')) Sigame
                        @elseif(request()->routeIs('admin.auctions')) Auctions
                        @elseif(request()->routeIs('admin.coupons')) Coupons
                        @else Admin Panel
                        @endif
                    </span>
                </div>

                <!-- Mobile menu trigger (shown on mobile only) -->
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2">
                        <div class="w-7 h-7 bg-accent/30 rounded-full flex items-center justify-center text-xs font-bold text-white">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <span class="text-sm text-white/80 hidden md:inline">{{ auth()->user()->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </div>
        </header>
        
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 bg-background">
            {{ $slot }}
        </div>
    </main>

    <!-- Mobile Admin Menu Button -->
    <div class="md:hidden fixed bottom-5 right-5 z-50">
        <button id="adminMobileMenuBtn" 
                class="bg-primary text-white p-3.5 rounded-full shadow-modal hover:bg-primary-dark transition-all duration-200 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="adminMobileMenu" class="md:hidden fixed inset-0 bg-black/60 z-40 hidden backdrop-blur-sm" onclick="closeAdminMobileMenu()">
        <div class="absolute right-0 top-0 h-full w-72 bg-admin-sidebar text-white shadow-modal" onclick="event.stopPropagation()">
            <!-- Mobile Header -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Sigmaven" class="h-7 w-auto brightness-0 invert opacity-90">
                    <span class="text-base font-bold tracking-wide font-serif text-white">Menu</span>
                </div>
                <button onclick="closeAdminMobileMenu()" 
                        class="text-white/50 hover:text-white transition p-1 rounded-md hover:bg-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <nav class="px-3 py-4 space-y-0.5 overflow-y-auto max-h-[calc(100vh-64px)] scrollbar-hide">
                @include('layouts.partials.admin-mobile-menu')
            </nav>
        </div>
    </div>

    <script>
        function toggleAdminMobileMenu() {
            document.getElementById('adminMobileMenu').classList.toggle('hidden');
        }
        
        function closeAdminMobileMenu() {
            document.getElementById('adminMobileMenu').classList.add('hidden');
        }
        
        document.getElementById('adminMobileMenuBtn').addEventListener('click', toggleAdminMobileMenu);
    </script>

    @include('layouts.partials.toast')
    @livewireScripts
</body>
</html>