<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <h2 class="text-xl font-bold text-gray-800">Manajemen Sigame</h2>
        <button wire:click="create" class="bg-sigmaven-admin-blue text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Game</button>
    </div>



    <div class="mb-6">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama game..." class="border-gray-300 rounded focus:ring-sigmaven-admin-blue focus:border-sigmaven-admin-blue w-full md:w-1/3">
    </div>

    <div class="overflow-x-auto relative">
        <div wire:loading.delay wire:target="search" class="absolute inset-0 bg-white/50 z-10 flex items-center justify-center">
            <!-- Skeleton Loading -->
            <div class="animate-pulse flex space-x-4">
                <div class="flex-1 space-y-4 py-1">
                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                    <div class="space-y-2">
                        <div class="h-4 bg-gray-200 rounded"></div>
                        <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                    </div>
                </div>
            </div>
        </div>

        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-500 uppercase">
                <tr>
                    <th class="px-6 py-3 font-medium">Gambar</th>
                    <th class="px-6 py-3 font-medium">Nama Game</th>
                    <th class="px-6 py-3 font-medium">Poin Dibutuhkan</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($games as $game)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            @if($game->url)
                                <a href="{{ $game->url }}" target="_blank" class="text-blue-500 hover:underline">Mainkan</a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $game->title }}</td>
                        <td class="px-6 py-4 font-medium text-sigmaven-gold">{{ number_format($game->required_points) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $game->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $game->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="edit({{ $game->id }})" class="text-blue-600 hover:underline mr-3">Edit</button>
                            <button wire:click="delete({{ $game->id }})" wire:confirm="Yakin ingin menghapus game ini?" class="text-red-600 hover:underline">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada game.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $games->links() }}
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
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">{{ $gameId ? 'Edit Game' : 'Tambah Game' }}</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nama Game</label>
                            <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sigmaven-admin-blue focus:ring-sigmaven-admin-blue">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea wire:model="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sigmaven-admin-blue focus:ring-sigmaven-admin-blue"></textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-text-secondary">Poin Required</label>
                            <input type="number" wire:model="required_points" class="w-full rounded-sm border-border-color" required>
                            @error('required_points') <span class="text-error text-sm">{{ $message }}</span> @enderror
                        </div>
      
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">URL Game (Opsional)</label>
                            <input type="text" wire:model="url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sigmaven-admin-blue focus:ring-sigmaven-admin-blue">
                            @error('url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center mb-4">
                            <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-gray-300 text-sigmaven-admin-blue focus:ring-sigmaven-admin-blue">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktif</label>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-sigmaven-admin-blue text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan
                        </button>
                        <button type="button" wire:click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
