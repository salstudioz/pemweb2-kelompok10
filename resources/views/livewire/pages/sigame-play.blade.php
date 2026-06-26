<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <a href="{{ route('sigame') }}" class="inline-flex items-center text-sigmaven-gray hover:text-sigmaven-forest mb-8 transition">
        <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" /> Kembali ke Katalog Game
    </a>

    <div class="bg-white p-12 rounded shadow-sm border border-gray-100">
        @if($game->thumbnail)
            <img src="{{ Storage::url($game->thumbnail) }}" alt="{{ $game->name }}" class="w-32 h-32 object-cover rounded-full mx-auto mb-6 border-4 border-sigmaven-cream">
        @else
            <div class="w-32 h-32 bg-sigmaven-forest/10 rounded-full mx-auto mb-6 flex items-center justify-center text-sigmaven-forest">
                <x-heroicon-o-puzzle-piece class="w-16 h-16" />
            </div>
        @endif

        <h1 class="text-4xl font-serif font-bold text-sigmaven-forest mb-4">{{ $game->name }}</h1>
        <p class="text-gray-600 mb-8 max-w-2xl mx-auto">{{ $game->description }}</p>

        <div class="bg-green-50 border border-green-200 p-8 rounded-lg mb-8 max-w-lg mx-auto">
            <h3 class="font-bold text-xl text-green-800 mb-2">Selamat Bermain!</h3>
            <p class="text-green-700">Ini adalah halaman demo interaktif untuk game {{ $game->name }}. Pada versi rilis penuh, game akan termuat secara interaktif di area ini menggunakan HTML5 Canvas atau WebGL.</p>
        </div>

        <button onclick="alert('Demo game sedang berjalan... Anda memenangkan 10 Poin!')" class="btn btn-primary px-8 py-4 text-lg rounded-full shadow-md hover:shadow-lg transform transition hover:-translate-y-1">
            <x-heroicon-s-play class="w-6 h-6 mr-2" /> Mulai Mainkan Demo
        </button>
    </div>
</div>
