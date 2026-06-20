<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-serif font-bold text-sigmaven-charcoal mb-4">LegacyBid</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">Ruang eksklusif untuk memperebutkan buku-buku langka, edisi pertama, dan koleksi vintage yang tak akan Anda temukan di toko biasa.</p>
    </div>

    @if($auctions->count() > 0)
        <div class="space-y-8">
            @foreach($auctions as $auction)
                <div class="bg-white rounded border-2 border-sigmaven-gold/30 shadow-sm p-6 lg:p-8 flex flex-col lg:flex-row gap-8 relative overflow-hidden">
                    <!-- Timer Badge -->
                    <div x-data="{ 
                            endsAt: new Date('{{ $auction->ends_at->toIso8601String() }}').getTime(),
                            now: new Date().getTime(),
                            distance: 0,
                            days: 0, hours: 0, minutes: 0, seconds: 0,
                            init() {
                                this.updateTime();
                                setInterval(() => this.updateTime(), 1000);
                            },
                            updateTime() {
                                this.now = new Date().getTime();
                                this.distance = this.endsAt - this.now;
                                if (this.distance > 0) {
                                    this.days = Math.floor(this.distance / (1000 * 60 * 60 * 24));
                                    this.hours = Math.floor((this.distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    this.minutes = Math.floor((this.distance % (1000 * 60 * 60)) / (1000 * 60));
                                    this.seconds = Math.floor((this.distance % (1000 * 60)) / 1000);
                                } else {
                                    this.days = this.hours = this.minutes = this.seconds = 0;
                                }
                            }
                        }" class="absolute top-0 right-0 bg-red-500 text-white px-4 py-1 font-bold text-sm rounded-bl flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span x-text="days + 'h ' + hours + 'j ' + minutes + 'm ' + seconds + 'd'"></span>
                    </div>

                    <!-- Image -->
                    <div class="w-full lg:w-1/4">
                        <div class="aspect-w-3 aspect-h-4 bg-gray-100 rounded">
                            @if($auction->product->cover_image)
                                <img src="{{ Storage::url($auction->product->cover_image) }}" class="object-cover w-full h-full">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">No Cover</div>
                            @endif
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="w-full lg:w-1/2">
                        <span class="text-xs font-bold text-sigmaven-gold uppercase tracking-wider">Lelang Langsung</span>
                        <h2 class="text-2xl font-serif font-bold mt-1 mb-2">{{ $auction->product->title }}</h2>
                        <p class="text-gray-500 mb-4">Oleh {{ $auction->product->author }} | {{ $auction->product->publisher }}</p>
                        
                        <div class="prose prose-sm text-gray-600 mb-6">
                            <p>{{ $auction->product->description }}</p>
                        </div>

                        <div class="bg-gray-50 rounded p-4 border border-gray-100">
                            <h4 class="text-xs font-bold text-gray-400 uppercase mb-3">Riwayat Penawaran Terakhir</h4>
                            @if($auction->bids->count() > 0)
                                <div class="space-y-2">
                                    @foreach($auction->bids->sortByDesc('created_at')->take(3) as $bid)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ $bid->user->name }}</span>
                                            <span class="font-medium text-sigmaven-forest">Rp {{ number_format($bid->bid_amount, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Belum ada penawaran. Jadilah yang pertama!</p>
                            @endif
                        </div>
                    </div>

                    <!-- Bidding Box -->
                    <div class="w-full lg:w-1/4 flex flex-col justify-center border-t lg:border-t-0 lg:border-l border-gray-200 lg:pl-8 pt-6 lg:pt-0">
                        <p class="text-sm text-gray-500 mb-1">Penawaran Tertinggi Saat Ini</p>
                        <p class="text-3xl font-bold text-sigmaven-forest mb-6">Rp {{ number_format($auction->current_price, 0, ',', '.') }}</p>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Masukkan Tawaran (Rp)</label>
                                <input type="number" wire:model="bidAmounts.{{ $auction->id }}" min="{{ $auction->current_price + 1000 }}" step="1000" class="w-full rounded border-gray-300 focus:border-sigmaven-gold focus:ring focus:ring-sigmaven-gold/20 text-lg text-center font-bold">
                            </div>
                            
                            <label class="flex items-center text-sm text-gray-600 bg-gray-50 p-2 rounded border border-gray-200 cursor-pointer">
                                <input type="checkbox" wire:model="autoBids.{{ $auction->id }}" class="rounded text-sigmaven-gold focus:ring-sigmaven-gold mr-2">
                                Aktifkan Auto-bid (simulasi)
                            </label>

                            <button wire:click="placeBid({{ $auction->id }})" class="btn bg-sigmaven-gold hover:bg-sigmaven-gold-dark text-white w-full py-3">Pasang Tawaran</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white p-16 text-center rounded border border-gray-200">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Tidak Ada Lelang Aktif</h3>
            <p class="text-gray-500">Saat ini belum ada koleksi buku langka yang sedang dilelang. Silakan kembali lagi nanti.</p>
        </div>
    @endif
</div>