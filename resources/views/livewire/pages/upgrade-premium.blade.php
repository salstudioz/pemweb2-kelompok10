<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" x-data>
    <div class="text-center max-w-3xl mx-auto mb-16">
        <h1 class="text-4xl md:text-5xl font-serif font-bold text-sigmaven-forest mb-6">Tingkatkan Pengalaman Membacamu</h1>
        <p class="text-lg text-gray-600">Bergabunglah dengan keanggotaan Premium Sigmaven. Nikmati akses lelang buku langka, mainkan Sigame untuk kumpulkan poin, dan dapatkan diskon eksklusif.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto mb-12">
        @foreach($plans as $plan)
            <div wire:click="selectPlan({{ $plan->id }})" class="card p-8 text-center relative overflow-hidden border-2 cursor-pointer transition-transform duration-300 {{ $selectedPlanId == $plan->id ? 'border-sigmaven-gold scale-105 shadow-xl' : 'border-transparent hover:scale-105' }}">
                @if($plan->slug == 'yearly-premium')
                    <div class="absolute top-0 right-0 bg-sigmaven-gold text-white text-xs font-bold px-3 py-1 rounded-bl">TERPOPULER</div>
                @endif
                
                <h3 class="text-2xl font-serif font-bold text-sigmaven-charcoal mb-2">{{ $plan->name }}</h3>
                <div class="mb-6">
                    <span class="text-4xl font-bold text-sigmaven-forest">Rp {{ number_format($plan->price, 0, ',', '.') }}</span>
                    <span class="text-gray-500">/ {{ $plan->duration_days }} hari</span>
                </div>
                
                <div class="bg-green-50 text-green-800 text-sm font-medium py-2 px-4 rounded-full inline-block mb-8">
                    + {{ number_format($plan->bonus_points) }} Poin Sigmaven
                </div>

                <ul class="text-left space-y-4 mb-4">
                    @if(is_array($plan->features))
                        @foreach($plan->features as $feature)
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span class="text-gray-600">{{ $feature }}</span>
                            </li>
                        @endforeach
                    @endif
                </ul>
                
                <div class="mt-6">
                    @if($selectedPlanId == $plan->id)
                        <button type="button" class="w-full bg-sigmaven-gold text-white font-bold py-2 px-4 rounded shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Terpilih
                        </button>
                    @else
                        <button type="button" class="w-full border border-sigmaven-forest text-sigmaven-forest font-bold py-2 px-4 rounded hover:bg-sigmaven-forest hover:text-white transition">
                            Pilih Paket
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if($selectedPlanId)
        <div class="max-w-3xl mx-auto bg-white p-8 rounded shadow-sm border border-gray-100" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <h3 class="font-serif font-bold text-xl mb-6 text-center border-b pb-4">Pilih Metode Pembayaran</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <label class="border p-4 rounded-sm cursor-pointer hover:border-sigmaven-forest transition {{ $paymentMethod === 'bank_transfer' ? 'border-sigmaven-forest ring-2 ring-sigmaven-forest/20 bg-green-50/10' : '' }}">
                    <input type="radio" wire:model.live="paymentMethod" value="bank_transfer" class="hidden">
                    <x-heroicon-o-building-library class="w-8 h-8 mx-auto text-sigmaven-forest" />
                    <span class="block text-sm text-center mt-2">Transfer Bank</span>
                </label>
                <label class="border p-4 rounded-sm cursor-pointer hover:border-sigmaven-forest transition {{ $paymentMethod === 'credit_card' ? 'border-sigmaven-forest ring-2 ring-sigmaven-forest/20 bg-green-50/10' : '' }}">
                    <input type="radio" wire:model.live="paymentMethod" value="credit_card" class="hidden">
                    <x-heroicon-o-credit-card class="w-8 h-8 mx-auto text-sigmaven-forest" />
                    <span class="block text-sm text-center mt-2">Kartu Kredit</span>
                </label>
                <label class="border p-4 rounded-sm cursor-pointer hover:border-sigmaven-forest transition {{ $paymentMethod === 'e_wallet' ? 'border-sigmaven-forest ring-2 ring-sigmaven-forest/20 bg-green-50/10' : '' }}">
                    <input type="radio" wire:model.live="paymentMethod" value="e_wallet" class="hidden">
                    <x-heroicon-o-wallet class="w-8 h-8 mx-auto text-sigmaven-forest" />
                    <span class="block text-sm text-center mt-2">Dompet Digital</span>
                </label>
            </div>
            
            <button wire:click="processUpgrade" class="w-full btn btn-primary py-3 text-lg relative" wire:loading.attr="disabled">
                <span wire:loading.remove>Bayar Sekarang</span>
                <span wire:loading>Memproses Pembayaran...</span>
            </button>
        </div>
    @endif
</div>