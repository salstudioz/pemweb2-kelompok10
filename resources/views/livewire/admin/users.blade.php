<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <h2 class="text-xl font-bold text-gray-800">User Management</h2>
    </div>

    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name or email..." class="border-gray-300 rounded-lg focus:ring-sigmaven-admin-blue focus:border-sigmaven-admin-blue flex-1 text-sm">
        <select wire:model.live="roleFilter" class="border-gray-300 rounded-lg focus:ring-sigmaven-admin-blue focus:border-sigmaven-admin-blue w-full md:w-48 text-sm">
            <option value="">All Roles</option>
            <option value="regular">Regular</option>
            <option value="premium">Premium</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 font-semibold">Name</th>
                    <th class="px-6 py-3 font-semibold">Email</th>
                    <th class="px-6 py-3 font-semibold">Role</th>
                    <th class="px-6 py-3 font-semibold">Points</th>
                    <th class="px-6 py-3 font-semibold">Joined</th>
                    <th class="px-6 py-3 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-sigmaven-admin-blue/10 rounded-full flex items-center justify-center text-xs font-bold text-sigmaven-admin-blue">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <select wire:change="updateRole({{ $user->id }}, $event.target.value)" class="text-xs rounded-full border-0 py-1 pl-2.5 pr-6 font-semibold cursor-pointer {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : ($user->role == 'premium' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600') }}">
                                <option value="regular" {{ $user->role == 'regular' ? 'selected' : '' }}>Regular</option>
                                <option value="premium" {{ $user->role == 'premium' ? 'selected' : '' }}>Premium</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 font-semibold text-sigmaven-gold">{{ number_format($user->points) }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <button wire:click="delete({{ $user->id }})" wire:confirm="Permanently delete this user? This cannot be undone." class="text-red-500 hover:text-red-700 font-medium transition text-sm">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
