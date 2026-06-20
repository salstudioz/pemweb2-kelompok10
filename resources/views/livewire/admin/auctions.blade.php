<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <h2 class="text-xl font-bold text-gray-800">Auction Management</h2>
        <button wire:click="create" class="bg-sigmaven-admin-blue text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Auction
        </button>
    </div>



    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search book name..." class="border-gray-300 rounded-lg focus:ring-sigmaven-admin-blue focus:border-sigmaven-admin-blue flex-1 text-sm">
        <select wire:model.live="statusFilter" class="border-gray-300 rounded-lg focus:ring-sigmaven-admin-blue focus:border-sigmaven-admin-blue w-full md:w-48 text-sm">
            <option value="">All Statuses</option>
            <option value="active">Active</option>
            <option value="ended">Ended</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-500 uppercase">
                <tr>
                    <th class="px-6 py-3 font-semibold">Book</th>
                    <th class="px-6 py-3 font-semibold">Starting Price</th>
                    <th class="px-6 py-3 font-semibold">Current Bid</th>
                    <th class="px-6 py-3 font-semibold">Ends At</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($auctions as $auction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $auction->product->title ?? $auction->product->name }}</td>
                        <td class="px-6 py-4 text-gray-500">Rp {{ number_format($auction->starting_price) }}</td>
                        <td class="px-6 py-4 font-medium text-sigmaven-gold">Rp {{ number_format($auction->current_price) }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($auction->ends_at)->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $auction->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($auction->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="edit({{ $auction->id }})" class="text-blue-600 hover:underline mr-3 font-medium">Edit</button>
                            <button wire:click="delete({{ $auction->id }})" wire:confirm="Permanently delete this auction?" class="text-red-600 hover:underline font-medium">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">No auction data found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $auctions->links() }}
    </div>

    <!-- Modal Form -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form wire:submit.prevent="store">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">{{ $auctionId ? 'Edit Auction' : 'Add Auction' }}</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Book (Product)</label>
                            <select wire:model="product_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sigmaven-admin-blue focus:ring-sigmaven-admin-blue">
                                <option value="">Pilih Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->title }}</option>
                                @endforeach
                            </select>
                            @error('product_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Starting Price (Rp)</label>
                            <input type="number" wire:model="starting_price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sigmaven-admin-blue focus:ring-sigmaven-admin-blue">
                            @error('starting_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Start Time</label>
                                <input type="datetime-local" wire:model="starts_at" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sigmaven-admin-blue focus:ring-sigmaven-admin-blue">
                                @error('starts_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">End Time</label>
                                <input type="datetime-local" wire:model="ends_at" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sigmaven-admin-blue focus:ring-sigmaven-admin-blue">
                                @error('ends_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select wire:model="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sigmaven-admin-blue focus:ring-sigmaven-admin-blue">
                                <option value="active">Active</option>
                                <option value="ended">Ended</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-sigmaven-admin-blue text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Save
                        </button>
                        <button type="button" wire:click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
