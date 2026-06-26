<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ openModal: false, selectedGameId: null, selectedGameName: '', selectedGamePoints: 0 }">
    <div class="bg-sigmaven-forest rounded-lg p-8 text-white mb-12 flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-3xl font-serif font-bold mb-2">Pusat Sigame</h1>
            <p class="text-sigmaven-cream/80">Tukar poin Anda dengan akses game literasi eksklusif. Bermain dan perluas wawasan budaya Anda.</p>
        </div>
        <div class="mt-6 md:mt-0 bg-white/10 p-4 rounded text-center min-w-[200px]">
            <p class="text-sm text-sigmaven-cream mb-1">Poin Tersedia</p>
            <p class="text-4xl font-bold text-sigmaven-gold">{{ number_format($userPoints) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($games as $game)
            @php $hasAccess = in_array($game->id, $userAccess); @endphp
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="aspect-video bg-sigmaven-admin-blue relative flex items-center justify-center">
                    <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    
                    @if($hasAccess)
                        <div class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded font-bold">Terbuka</div>
                    @else
                        <div class="absolute top-2 right-2 bg-gray-800/80 text-white text-xs px-2 py-1 rounded font-bold flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                            Terkunci
                        </div>
                    @endif
                </div>
                
                <div class="p-6">
                    <h3 class="font-serif font-bold text-xl text-sigmaven-charcoal mb-2">{{ $game->name }}</h3>
                    <p class="text-gray-600 text-sm mb-6">{{ $game->description }}</p>
                    
                    @if($hasAccess)
                        <a href="{{ route('sigame.play', $game->slug ?? $game->id) }}" class="btn btn-primary w-full text-center">Mainkan Sekarang</a>
                    @else
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-sigmaven-gold">{{ number_format($game->required_points) }} Poin</span>
                            <button @click="openModal = true; selectedGameId = {{ $game->id }}; selectedGameName = '{{ addslashes($game->name) }}'; selectedGamePoints = {{ $game->required_points }}" class="btn btn-secondary text-sm" {{ $userPoints < $game->required_points ? 'disabled' : '' }}>
                                {{ $userPoints < $game->required_points ? 'Poin Kurang' : 'Tukar Akses' }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="openModal" @click.away="openModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                        <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-yellow-600" />
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Konfirmasi Penukaran Poin</h3>
                        <div class="mt-2 text-sm text-gray-500">
                            <p>Anda akan menukarkan <span class="font-bold text-sigmaven-gold" x-text="selectedGamePoints"></span> poin untuk mendapatkan akses game <span class="font-bold text-sigmaven-charcoal" x-text="selectedGameName"></span>.</p>
                            <p class="mt-2">Sisa poin Anda setelah penukaran: <span class="font-bold">{{ number_format($userPoints) }}</span> - <span x-text="selectedGamePoints"></span>.</p>
                            <p class="mt-1 text-red-500">Aksi ini tidak dapat dibatalkan.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="$wire.redeemAccess(selectedGameId); openModal = false" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-sigmaven-gold text-base font-medium text-white hover:bg-yellow-600 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Ya, Tukar Poin
                    </button>
                    <button type="button" @click="openModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>