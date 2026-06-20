<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'profile' }">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar Profile -->
        <div class="w-full md:w-1/3 lg:w-1/4 flex-shrink-0">
            <div class="bg-white rounded-sm shadow-sm border border-gray-100 p-6 text-center mb-6">
                <div class="w-24 h-24 bg-sigmaven-cream rounded-full mx-auto mb-4 border-2 border-sigmaven-gold flex items-center justify-center text-2xl font-serif text-sigmaven-gold font-bold">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <h2 class="font-bold text-xl text-sigmaven-charcoal">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500 mb-4">{{ $user->email }}</p>
                
                <div class="bg-gray-50 p-3 rounded text-sm mb-4">
                    <span class="block text-gray-500 mb-1">Membership Status</span>
                    @if($user->isPremium())
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-sigmaven-gold text-white shadow-sm">
                            Premium Member
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-800">
                            Regular
                        </span>
                        <a href="{{ route('upgrade.premium') }}" class="block text-sigmaven-gold hover:underline mt-2 text-xs">Upgrade Now</a>
                    @endif
                </div>

                <div class="bg-green-50 border border-green-100 p-3 rounded text-sm">
                    <span class="block text-green-800 mb-1">Sigmaven Points</span>
                    <span class="text-2xl font-bold text-sigmaven-forest">{{ number_format($user->points) }}</span>
                </div>
            </div>

            <nav class="space-y-1">
                <button @click="activeTab = 'profile'" :class="{'bg-sigmaven-cream border-sigmaven-forest text-sigmaven-forest border-l-4': activeTab === 'profile', 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent': activeTab !== 'profile'}" class="w-full text-left px-4 py-3 font-medium transition">
                    My Profile
                </button>
                <button @click="activeTab = 'address'" :class="{'bg-sigmaven-cream border-sigmaven-forest text-sigmaven-forest border-l-4': activeTab === 'address', 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent': activeTab !== 'address'}" class="w-full text-left px-4 py-3 font-medium transition">
                    Address Book
                </button>
                <button @click="activeTab = 'orders'" :class="{'bg-sigmaven-cream border-sigmaven-forest text-sigmaven-forest border-l-4': activeTab === 'orders', 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent': activeTab !== 'orders'}" class="w-full text-left px-4 py-3 font-medium transition">
                    Order History
                </button>
                <button @click="activeTab = 'premium'" :class="{'bg-sigmaven-cream border-sigmaven-forest text-sigmaven-forest border-l-4': activeTab === 'premium', 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-l-4 border-transparent': activeTab !== 'premium'}" class="w-full text-left px-4 py-3 font-medium transition">
                    Premium Status
                </button>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            
            <!-- Tab Profile -->
            <div x-show="activeTab === 'profile'" x-transition>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="section-title mb-0">My Profile</h2>
                    @if(!$editingProfile)
                        <button wire:click="editProfile" class="btn btn-primary text-sm">Edit Profile</button>
                    @endif
                </div>
                
                @if($editingProfile)
                <div class="bg-white p-6 rounded shadow-sm border border-sigmaven-border mb-6">
                    <h3 class="font-bold mb-4">Edit Profile</h3>
                    <form wire:submit="saveProfile" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm mb-1">Full Name</label>
                                <input type="text" wire:model="profileForm.name" class="w-full border-gray-300 rounded focus:ring focus:ring-sigmaven-forest/20 focus:border-sigmaven-forest" required>
                            </div>
                            <div>
                                <label class="block text-sm mb-1">Email</label>
                                <input type="email" wire:model="profileForm.email" class="w-full border-gray-300 rounded focus:ring focus:ring-sigmaven-forest/20 focus:border-sigmaven-forest" required>
                            </div>
                            <div>
                                <label class="block text-sm mb-1">Phone Number</label>
                                <input type="text" wire:model="profileForm.phone" class="w-full border-gray-300 rounded focus:ring focus:ring-sigmaven-forest/20 focus:border-sigmaven-forest">
                            </div>
                        </div>
                        <div class="flex gap-2 mt-6 justify-end">
                            <button type="button" wire:click="cancelEditProfile" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
                @endif
                
                <div class="bg-white p-6 rounded shadow-sm border border-gray-100 space-y-4">
                    <div>
                        <label class="block text-sm text-gray-500">Full Name</label>
                        <p class="font-medium">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-500">Email</label>
                        <p class="font-medium">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-500">Phone Number</label>
                        <p class="font-medium">{{ $user->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-500">Member Since</label>
                        <p class="font-medium">{{ $user->created_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Tab Address -->
            <div x-show="activeTab === 'address'" x-transition style="display: none;">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="section-title mb-0">Address Book</h2>
                    <button wire:click="createAddress" class="btn btn-primary text-sm">Add Address</button>
                </div>

                @if($showAddressForm)
                <div class="bg-white p-6 rounded shadow-sm border border-sigmaven-border mb-6">
                    <h3 class="font-bold mb-4">{{ $editingAddressId ? 'Edit Address' : 'Add New Address' }}</h3>
                    <form wire:submit="saveAddress" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm mb-1">Label (Home/Office)</label>
                                <input type="text" wire:model="addressForm.label" class="w-full border-gray-300 rounded focus:ring focus:ring-sigmaven-forest/20 focus:border-sigmaven-forest" required>
                            </div>
                            <div>
                                <label class="block text-sm mb-1">Recipient Name</label>
                                <input type="text" wire:model="addressForm.recipient_name" class="w-full border-gray-300 rounded focus:ring focus:ring-sigmaven-forest/20 focus:border-sigmaven-forest" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm mb-1">Full Address</label>
                                <textarea wire:model="addressForm.full_address" rows="3" class="w-full border-gray-300 rounded focus:ring focus:ring-sigmaven-forest/20 focus:border-sigmaven-forest" required></textarea>
                            </div>
                            <div>
                                <label class="block text-sm mb-1">City</label>
                                <input type="text" wire:model="addressForm.city" class="w-full border-gray-300 rounded focus:ring focus:ring-sigmaven-forest/20 focus:border-sigmaven-forest" required>
                            </div>
                            <div>
                                <label class="block text-sm mb-1">Postal Code</label>
                                <input type="text" wire:model="addressForm.postal_code" class="w-full border-gray-300 rounded focus:ring focus:ring-sigmaven-forest/20 focus:border-sigmaven-forest" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm mb-1">Phone Number</label>
                                <input type="text" wire:model="addressForm.phone" class="w-full border-gray-300 rounded focus:ring focus:ring-sigmaven-forest/20 focus:border-sigmaven-forest" required>
                            </div>
                        </div>
                        <label class="flex items-center gap-2 mt-4 cursor-pointer">
                            <input type="checkbox" wire:model="addressForm.is_primary" class="rounded text-sigmaven-forest focus:ring-sigmaven-forest">
                            <span class="text-sm">Set as Default Address</span>
                        </label>
                        <div class="flex gap-2 mt-6 justify-end">
                            <button type="button" wire:click="$set('showAddressForm', false)" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                @endif

                <div class="space-y-4">
                    @forelse($addresses as $addr)
                        <div class="bg-white p-6 rounded shadow-sm border {{ $addr->is_primary ? 'border-sigmaven-forest ring-1 ring-sigmaven-forest/50' : 'border-gray-100' }}">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span class="font-bold text-sigmaven-charcoal">{{ $addr->label }}</span>
                                    @if($addr->is_primary)
                                        <span class="ml-2 bg-sigmaven-forest/10 text-sigmaven-forest text-xs px-2 py-1 rounded">Primary</span>
                                    @endif
                                </div>
                                <div class="flex gap-2 text-sm">
                                    <button wire:click="editAddress({{ $addr->id }})" class="text-sigmaven-forest hover:underline">Edit</button>
                                    <button wire:click="deleteAddress({{ $addr->id }})" wire:confirm="Delete this address?" class="text-red-500 hover:underline">Delete</button>
                                </div>
                            </div>
                            <p class="text-sm font-medium mt-2">{{ $addr->recipient_name }} - {{ $addr->phone }}</p>
                            <p class="text-sm text-gray-600 mb-1">{{ $addr->full_address }}</p>
                            <p class="text-sm text-gray-600">{{ $addr->city }} {{ $addr->postal_code }}</p>
                            @if(!$addr->is_primary)
                                <button wire:click="setDefaultAddress({{ $addr->id }})" class="text-xs text-sigmaven-gold mt-3 hover:underline">Set as Primary Address</button>
                            @endif
                        </div>
                    @empty
                        <div class="text-center p-8 bg-gray-50 rounded">
                            <p class="text-gray-500">You have no saved addresses.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Tab Orders -->
            <div x-show="activeTab === 'orders'" x-transition style="display: none;">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="section-title mb-0">Order History</h2>
                    <a href="{{ route('order.history') }}" class="btn btn-primary text-sm">View All Orders</a>
                </div>
                @if($orders->count() > 0)
                    <div class="space-y-4">
                        @foreach($orders as $order)
                            <div class="bg-white p-6 rounded shadow-sm border border-gray-100">
                                <div class="flex flex-col md:flex-row md:items-center justify-between border-b pb-4 mb-4 gap-4">
                                    <div>
                                        <span class="text-sm text-gray-500 block mb-1">Order Date: {{ $order->created_at->format('d M Y') }}</span>
                                        <span class="font-bold text-sigmaven-charcoal">{{ $order->order_number }}</span>
                                    </div>
                                    <div class="text-left md:text-right">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-medium {{ 
                                            $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                            ($order->status == 'processing' ? 'bg-blue-100 text-blue-800' : 
                                            ($order->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'))
                                        }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-sm text-gray-600">{{ $order->items->count() }} {{ $order->items->count() == 1 ? 'item' : 'items' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-400 mb-0.5">Total</p>
                                        <p class="font-bold text-lg text-sigmaven-forest">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white p-12 text-center rounded border border-gray-100 shadow-sm">
                        <p class="text-gray-500 mb-4">You have no orders yet.</p>
                        <a href="{{ route('shop') }}" class="btn btn-primary">Start Shopping</a>
                    </div>
                @endif
            </div>

            <!-- Tab Premium Status -->
            <div x-show="activeTab === 'premium'" x-transition style="display: none;">
                <h2 class="section-title">Premium Status</h2>
                <div class="bg-white p-6 rounded shadow-sm border border-gray-100">
                    @if($user->isPremium() && $user->currentSubscription)
                        <div class="text-center p-6 border-2 border-sigmaven-gold/30 rounded-lg bg-sigmaven-gold/5">
                            <x-heroicon-o-check-circle class="w-16 h-16 mx-auto text-sigmaven-gold mb-4" />
                            <h3 class="text-2xl font-serif text-sigmaven-gold font-bold mb-2">Active Premium Member</h3>
                            <p class="text-gray-600 mb-4">Valid until: <span class="font-bold">{{ \Carbon\Carbon::parse($user->currentSubscription->ends_at)->format('d F Y') }}</span></p>
                            <p class="text-sm text-gray-500 mb-6">Enjoy exclusive auction access, play Sigame, and special discounts for selected products.</p>
                            <a href="{{ route('upgrade.premium') }}" class="btn btn-primary bg-sigmaven-gold hover:bg-yellow-600 border-none">Extend Plan</a>
                        </div>
                    @else
                        <div class="text-center p-6">
                            <x-heroicon-o-x-circle class="w-16 h-16 mx-auto text-gray-400 mb-4" />
                            <h3 class="text-2xl font-serif text-gray-700 font-bold mb-2">Premium Inactive</h3>
                            <p class="text-gray-600 mb-6">Upgrade your account to get exclusive benefits from Sigmaven.</p>
                            <a href="{{ route('upgrade.premium') }}" class="btn btn-primary">View Plan Options</a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>