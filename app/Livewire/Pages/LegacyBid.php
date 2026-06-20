<?php
namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Auction;
use App\Models\AuctionBid;
use Illuminate\Support\Facades\Auth;
use App\Traits\WithToast;

#[Layout('layouts.app')]
class LegacyBid extends Component {
    use WithToast;

    public $bidAmounts = [];
    public $autoBids = [];

    public function mount() {
        $auctions = Auction::where('status', 'active')->where('ends_at', '>', now())->get();
        foreach ($auctions as $auction) {
            $this->bidAmounts[$auction->id] = $auction->current_price + 10000;
        }
    }

    public function placeBid($auctionId) {
        $auction = Auction::findOrFail($auctionId);
        $amount = $this->bidAmounts[$auctionId] ?? 0;

        if ($amount <= $auction->current_price) {
            $this->notify('Tawaran harus lebih tinggi dari harga saat ini!', 'error');
            return;
        }

        AuctionBid::create([
            'auction_id' => $auctionId,
            'user_id' => Auth::id(),
            'bid_amount' => $amount
        ]);

        $auction->update(['current_price' => $amount]);
        $this->notify('Berhasil menempatkan tawaran!', 'success');
        
        $this->bidAmounts[$auctionId] = $amount + 10000;

        if (isset($this->autoBids[$auctionId]) && $this->autoBids[$auctionId]) {
            $this->notify('Auto-bid aktif, sistem akan menawar otomatis jika ada yang menyalip.', 'info');
        }
    }

    public function render() {
        $auctions = Auction::with(['product', 'bids.user'])->where('status', 'active')->where('ends_at', '>', now())->get();
        return view('livewire.pages.legacybid', ['auctions' => $auctions]);
    }
}