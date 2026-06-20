<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Genre Management</h2>
        <button wire:click="create" class="bg-sigmaven-admin-blue hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Genre
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 mb-6">
        <div class="p-4 border-b border-gray-100">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search genres..." class="w-full md:w-1/3 rounded border-gray-300 text-sm focus:border-sigmaven-admin-blue focus:ring focus:ring-sigmaven-admin-blue/20">
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-gray-500 uppercase">
                    <tr>
                        <th class="px-6 py-3 font-medium">Image</th>
                        <th class="px-6 py-3 font-medium">Name</th>
                        <th class="px-6 py-3 font-medium">Products Count</th>
                        <th class="px-6 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($genres as $genre)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <img src="{{ filter_var($genre->image_url, FILTER_VALIDATE_URL) ? $genre->image_url : asset($genre->image_url) }}" class="w-12 h-12 object-cover rounded shadow-sm">
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $genre->name }}</td>
                            <td class="px-6 py-4">{{ $genre->products()->count() }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button wire:click="edit({{ $genre->id }})" class="text-blue-500 hover:text-blue-700 font-medium">Edit</button>
                                <button wire:click="delete({{ $genre->id }})" wire:confirm="Are you sure you want to delete this genre?" class="text-red-500 hover:text-red-700 font-medium">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No genres found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100">
            {{ $genres->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
            <div class="bg-white rounded-lg w-full max-w-md shadow-xl">
                <div class="flex justify-between items-center p-4 border-b">
                    <h3 class="text-lg font-bold text-gray-800">{{ $genreId ? 'Edit Genre' : 'Add Genre' }}</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <x-heroicon-o-x-mark class="w-5 h-5"/>
                    </button>
                </div>
                
                <form wire:submit.prevent="save" class="p-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                        <input type="text" wire:model="name" class="w-full rounded border-gray-300 text-sm focus:border-sigmaven-admin-blue focus:ring-sigmaven-admin-blue" required>
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image (Optional)</label>
                        <input type="file" wire:model="image" class="w-full text-sm border border-gray-300 rounded p-1">
                        @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        
                        <div wire:loading wire:target="image" class="text-xs text-blue-500 mt-1">Uploading...</div>
                        
                        @if ($image)
                            <div class="mt-2">
                                <img src="{{ $image->temporaryUrl() }}" class="w-20 h-20 object-cover rounded shadow-sm">
                            </div>
                        @elseif ($oldImage)
                            <div class="mt-2">
                                <img src="{{ filter_var($oldImage, FILTER_VALIDATE_URL) ? $oldImage : asset($oldImage) }}" class="w-20 h-20 object-cover rounded shadow-sm">
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-end gap-2 pt-4 border-t">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-50">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-sigmaven-admin-blue text-white rounded text-sm hover:bg-blue-800">Save</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
