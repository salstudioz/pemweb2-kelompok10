<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Auction;
use App\Traits\WithToast;

#[Layout('layouts.admin')]
class Auctions extends Component {
    use WithPagination, WithToast;

    public $search = '';
    public $statusFilter = '';

    public $showModal = false;
    public $auctionId;
    public $product_id, $starting_price, $starts_at, $ends_at, $status = 'active';

    public function updatingSearch() {
        $this->resetPage();
    }

    public function updatingStatusFilter() {
        $this->resetPage();
    }

    public function create() {
        $this->resetInputFields();
        $this->showModal = true;
    }

    public function edit($id) {
        $auction = Auction::findOrFail($id);
        $this->auctionId = $id;
        $this->product_id = $auction->product_id;
        $this->starting_price = $auction->starting_price;
        $this->starts_at = \Carbon\Carbon::parse($auction->starts_at)->format('Y-m-d\TH:i');
        $this->ends_at = \Carbon\Carbon::parse($auction->ends_at)->format('Y-m-d\TH:i');
        $this->status = $auction->status;
        $this->showModal = true;
    }

    public function store() {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'starting_price' => 'required|numeric|min:0',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'status' => 'required|in:active,ended,cancelled',
        ]);

        Auction::updateOrCreate(['id' => $this->auctionId], [
            'product_id' => $this->product_id,
            'starting_price' => $this->starting_price,
            'current_price' => $this->auctionId ? Auction::find($this->auctionId)->current_price : $this->starting_price,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'status' => $this->status,
        ]);

        $this->notify($this->auctionId ? 'Auction updated.' : 'Auction added.', 'success');
        $this->closeModal();
    }

    public function delete($id) {
        Auction::findOrFail($id)->delete();
        $this->notify('Auction deleted.', 'success');
    }

    public function closeModal() {
        $this->showModal = false;
        $this->resetInputFields();
    }

    private function resetInputFields() {
        $this->auctionId = null;
        $this->product_id = '';
        $this->starting_price = '';
        $this->starts_at = '';
        $this->ends_at = '';
        $this->status = 'active';
    }

    public function render() {
        $auctions = Auction::with('product')
            ->when($this->search, function($query) {
                $query->whereHas('product', function($q) {
                    $q->where('title', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->statusFilter, function($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.auctions', [
            'auctions' => $auctions,
            'products' => \App\Models\Product::orderBy('title')->get()
        ]);
    }
}
