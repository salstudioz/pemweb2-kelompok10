<div class="flex flex-wrap items-center justify-between gap-4">
    <div class="flex items-center gap-3">
        <a href="/" class="text-2xl font-bold text-sigmaven-text-main">Sigmaven</a>
        <span class="text-sm text-sigmaven-text-muted hidden md:inline">| Platform Literasi</span>
    </div>

    <form action="{{ route('shop') }}" method="GET" class="flex flex-1 max-w-md items-center gap-2">
        <input type="text" name="search" placeholder="<x-heroicon-o-magnifying-glass class="w-5 h-5 text-sigmaven-text-muted inline-block" /> Cari buku..." class="search-bar flex-1" value="{{ request('search') }}">
        <button type="submit" class="search-btn text-sm">Cari</button>
    </form>

    <div class="flex items-center gap-4">
        @auth
            <a href="{{ route('account') }}" class="text-sigmaven-text-main hover:text-sigmaven-coral">
                <span class="hidden md:inline">Halo, {{ auth()->user()->name }}</span>
                <span class="md:hidden"><x-heroicon-o-user class="w-5 h-5 inline-block" /></span>
            </a>
            <a href="{{ route('cart') }}" class="relative text-sigmaven-text-main hover:text-sigmaven-coral">
                <x-heroicon-o-shopping-cart class="w-5 h-5 inline-block" />
                @if($cartCount = session('cart_count', 0))
                    <span class="absolute -top-1 -right-2 bg-sigmaven-coral text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $cartCount }}</span>
                @endif
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-sm text-sigmaven-text-muted hover:text-sigmaven-coral">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="text-sigmaven-text-main hover:text-sigmaven-coral">Login</a>
            <a href="{{ route('register') }}" class="btn-coral text-sm py-2 px-4">Daftar</a>
        @endauth
    </div>
</div>