<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="sm:flex sm:items-center mb-6">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold leading-6 text-gray-900">Coupon Management</h1>
            <p class="mt-2 text-sm text-gray-600">Manage discount coupons for customers.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <button type="button" wire:click="create" class="block rounded-md bg-sigmaven-forest px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-green-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                Add Coupon
            </button>
        </div>
    </div>

    <!-- Search -->
    <div class="mb-6">
        <input type="text" wire:model.live="search" placeholder="Search coupons by code or name..." class="w-full max-w-md border-gray-300 rounded shadow-sm focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20" />
    </div>

    <!-- Coupons Table -->
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Code</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Value</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Uses</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Validity</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($coupons as $coupon)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                        <div class="font-mono font-bold text-sigmaven-forest">{{ $coupon->code }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                                        <div class="font-medium">{{ $coupon->name }}</div>
                                        @if($coupon->description)
                                            <div class="text-gray-500 text-xs mt-1">{{ Str::limit($coupon->description, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $coupon->type === 'percentage' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($coupon->type) }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                                        @if($coupon->type === 'percentage')
                                            {{ $coupon->value }}%
                                        @else
                                            Rp {{ number_format($coupon->value, 0, ',', '.') }}
                                        @endif
                                        @if($coupon->min_order)
                                            <div class="text-xs text-gray-500 mt-1">Min. order: Rp {{ number_format($coupon->min_order, 0, ',', '.') }}</div>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                                        {{ $coupon->uses_count }} @if($coupon->max_uses) / {{ $coupon->max_uses }} @endif
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium {{ $coupon->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                                        @if($coupon->starts_at && $coupon->ends_at)
                                            {{ $coupon->starts_at->format('d/m/Y') }} - {{ $coupon->ends_at->format('d/m/Y') }}
                                        @elseif($coupon->starts_at)
                                            From {{ $coupon->starts_at->format('d/m/Y') }}
                                        @elseif($coupon->ends_at)
                                            Until {{ $coupon->ends_at->format('d/m/Y') }}
                                        @else
                                            <span class="text-gray-400">Unlimited</span>
                                        @endif
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <button wire:click="edit({{ $coupon->id }})" class="text-sigmaven-forest hover:text-green-700 mr-4">Edit</button>
                                        <button wire:click="delete({{ $coupon->id }})" wire:confirm="Are you sure you want to delete this coupon?" class="text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-3 py-8 text-center text-sm text-gray-500">
                                        No coupons found. <button wire:click="create" class="text-sigmaven-forest hover:underline">Create your first coupon</button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $coupons->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    @if($showModal)
    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                    <div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-4" id="modal-title">
                                {{ $couponId ? 'Edit Coupon' : 'Add New Coupon' }}
                            </h3>
                            <div class="mt-2">
                                <form wire:submit.prevent="save" class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="code" class="block text-sm font-medium text-gray-700">Coupon Code *</label>
                                            <input type="text" wire:model="code" id="code" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20">
                                            @error('code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Coupon Name *</label>
                                            <input type="text" wire:model="name" id="name" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20">
                                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="type" class="block text-sm font-medium text-gray-700">Discount Type *</label>
                                            <select wire:model="type" id="type" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20">
                                                <option value="fixed">Fixed Amount</option>
                                                <option value="percentage">Percentage</option>
                                            </select>
                                            @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="value" class="block text-sm font-medium text-gray-700">
                                                Discount Value *
                                                @if($type === 'percentage')
                                                    (Percentage)
                                                @else
                                                    (Rp)
                                                @endif
                                            </label>
                                            <input type="number" wire:model="value" id="value" min="0" step="{{ $type === 'percentage' ? '0.01' : '1000' }}" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20">
                                            @error('value') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="min_order" class="block text-sm font-medium text-gray-700">Minimum Order (Rp)</label>
                                            <input type="number" wire:model="min_order" id="min_order" min="0" step="1000" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20">
                                            @error('min_order') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="max_uses" class="block text-sm font-medium text-gray-700">Maximum Uses</label>
                                            <input type="number" wire:model="max_uses" id="max_uses" min="1" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20">
                                            @error('max_uses') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="starts_at" class="block text-sm font-medium text-gray-700">Starts At</label>
                                            <input type="datetime-local" wire:model="starts_at" id="starts_at" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20">
                                            @error('starts_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label for="ends_at" class="block text-sm font-medium text-gray-700">Ends At</label>
                                            <input type="datetime-local" wire:model="ends_at" id="ends_at" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20">
                                            @error('ends_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea wire:model="description" id="description" rows="2" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20"></textarea>
                                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" wire:model="is_active" id="is_active" class="h-4 w-4 text-sigmaven-forest focus:ring-sigmaven-forest border-gray-300 rounded">
                                        <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
                                        @error('is_active') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                        <button type="button" wire:click="$set('showModal', false)" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Cancel</button>
                                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-sigmaven-forest px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 sm:col-start-2">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>