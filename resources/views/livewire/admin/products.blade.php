<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Product Management</h2>
        <button wire:click="create" class="bg-sigmaven-admin-blue hover:bg-blue-800 text-white px-4 py-2 rounded text-sm font-medium transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Product
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6">
        <div class="p-4 border-b border-gray-100">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search products..." class="w-full md:w-1/3 rounded border-gray-300 text-sm focus:border-sigmaven-admin-blue focus:ring focus:ring-sigmaven-admin-blue/20">
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Product</th>
                        <th class="px-6 py-3 font-semibold">Genres</th>
                        <th class="px-6 py-3 font-semibold">Price</th>
                        <th class="px-6 py-3 font-semibold">Stock</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($product->cover_image)
                                    <img src="{{ Storage::url($product->cover_image) }}" class="w-10 h-14 rounded object-cover shadow-sm flex-shrink-0">
                                @else
                                    <div class="w-10 h-14 rounded bg-gray-200 flex-shrink-0 flex items-center justify-center text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"></path></svg>
                                    </div>
                                @endif
                                <div>
                                    <span class="font-medium text-gray-800 block line-clamp-1">{{ $product->title }}</span>
                                    <span class="text-xs text-gray-500">{{ $product->author }}</span>
                                    @if($product->is_featured)
                                        <span class="text-xs bg-yellow-100 text-yellow-700 px-1.5 py-0.5 rounded font-medium mt-0.5 inline-block">Featured</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($product->genres->take(2) as $genre)
                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-700 text-xs rounded-full font-medium">{{ $genre->name }}</span>
                                @endforeach
                                @if($product->genres->count() > 2)
                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-full">+{{ $product->genres->count() - 2 }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div>
                                <span class="font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                @if($product->discount_price)
                                    <span class="text-xs text-green-600 block">Sale: Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->type === 'digital')
                                <span class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded-full">Digital</span>
                            @else
                                <span class="{{ $product->stock < 5 ? 'text-red-600 font-bold' : 'text-gray-600' }}">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-500' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-3">
                            <button wire:click="edit({{ $product->id }})" class="text-blue-500 hover:text-blue-700 font-medium text-sm transition">Edit</button>
                            <button wire:click="delete({{ $product->id }})" wire:confirm="Delete this product permanently?" class="text-red-500 hover:text-red-700 font-medium text-sm transition">Delete</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    @if($showModal)
    <div class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" x-data @keydown.escape.window="$wire.set('showModal', false)">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center p-6 border-b border-gray-100 sticky top-0 bg-white z-10">
                <h3 class="text-xl font-bold text-gray-800">{{ $productId ? 'Edit Product' : 'Add New Product' }}</h3>
                <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600 transition p-1 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form wire:submit.prevent="save" class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Book Title *</label>
                        <input wire:model="title" type="text" class="w-full rounded-lg border-gray-300 text-sm focus:border-sigmaven-admin-blue focus:ring focus:ring-sigmaven-admin-blue/20">
                        @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Author *</label>
                        <input wire:model="author" type="text" class="w-full rounded-lg border-gray-300 text-sm focus:border-sigmaven-admin-blue focus:ring focus:ring-sigmaven-admin-blue/20">
                        @error('author') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Publisher</label>
                        <input wire:model="publisher" type="text" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                        <input wire:model="isbn" type="text" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Price (Rp) *</label>
                        <input wire:model="price" type="number" min="0" class="w-full rounded-lg border-gray-300 text-sm">
                        @error('price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Discount Price (Rp)</label>
                        <input wire:model="discount_price" type="number" min="0" placeholder="Leave empty for no discount" class="w-full rounded-lg border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select wire:model.live="type" class="w-full rounded-lg border-gray-300 text-sm">
                            <option value="physical">Physical Book</option>
                            <option value="digital">Digital / E-Book</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Physical Stock</label>
                        <input wire:model="stock" type="number" min="0" {{ $type === 'digital' ? 'disabled' : '' }} class="w-full rounded-lg border-gray-300 text-sm disabled:bg-gray-100 disabled:text-gray-400">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Genres * <span class="text-gray-400 font-normal">(Ctrl/Cmd + click to select multiple)</span></label>
                        <select wire:model="genre_ids" multiple class="w-full rounded-lg border-gray-300 text-sm h-36">
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                            @endforeach
                        </select>
                        @error('genre_ids') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Cover Image</label>
                        @if($cover_image && !$new_cover_image)
                            <div class="mb-2 flex items-center gap-3">
                                <img src="{{ Storage::url($cover_image) }}" class="w-16 h-20 object-cover rounded shadow-sm">
                                <span class="text-xs text-gray-500">Current cover</span>
                            </div>
                        @endif
                        @if($new_cover_image)
                            <div class="mb-2 flex items-center gap-3">
                                <img src="{{ $new_cover_image->temporaryUrl() }}" class="w-16 h-20 object-cover rounded shadow-sm">
                                <span class="text-xs text-green-600">New cover preview</span>
                            </div>
                        @endif
                        <input wire:model="new_cover_image" type="file" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <div wire:loading wire:target="new_cover_image" class="text-xs text-blue-500 mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            Uploading...
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                    <textarea wire:model="description" rows="4" class="w-full rounded-lg border-gray-300 text-sm" placeholder="Enter book description..."></textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="is_active" class="rounded text-sigmaven-admin-blue focus:ring-sigmaven-admin-blue">
                        <span class="text-sm font-medium text-gray-700">Active (visible in shop)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="is_featured" class="rounded text-sigmaven-admin-blue focus:ring-sigmaven-admin-blue">
                        <span class="text-sm font-medium text-gray-700">Featured on homepage</span>
                    </label>
                </div>
                
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" wire:click="$set('showModal', false)" class="px-5 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition">Cancel</button>
                    <button type="submit" class="px-5 py-2 bg-sigmaven-admin-blue text-white rounded-lg text-sm hover:bg-blue-800 transition flex items-center gap-2" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $productId ? 'Save Changes' : 'Create Product' }}</span>
                        <span wire:loading>Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>