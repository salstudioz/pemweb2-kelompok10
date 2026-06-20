<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-serif font-bold text-sigmaven-forest mb-8">Checkout</h1>

    <form wire:submit.prevent="processCheckout" class="flex flex-col lg:flex-row gap-8">
        <!-- Main Form -->
        <div class="lg:w-2/3 space-y-6">
            
            <!-- Address Selection -->
            <div id="step-1" class="bg-white rounded shadow-sm border border-gray-100 p-6 transform transition-all duration-500 ease-out hover:shadow-lg">
                <h3 class="font-serif font-bold text-lg border-b pb-4 mb-4">1. Shipping Address</h3>
                
                @if($addresses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($addresses as $addr)
                            <label class="relative border rounded p-4 cursor-pointer transition-all duration-300 ease-in-out hover:shadow-md {{ $address_id == $addr->id ? 'border-sigmaven-forest ring-1 ring-sigmaven-forest bg-green-50/30 scale-[1.02] shadow-md' : 'border-gray-200 hover:border-gray-400' }}">
                                <input type="radio" wire:model.live="address_id" value="{{ $addr->id }}" class="absolute opacity-0">
                                
                                <!-- Icon centang jika dipilih -->
                                <div class="absolute top-2 right-2 transition-all duration-300 {{ $address_id == $addr->id ? 'scale-100' : 'scale-0' }}">
                                    <svg class="w-5 h-5 text-sigmaven-forest" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>

                                <div class="pr-6">
                                    <span class="font-bold text-sm text-sigmaven-charcoal">{{ $addr->recipient_name }}</span>
                                    @if($addr->label) <span class="bg-gray-100 text-xs px-2 py-0.5 rounded ml-2">{{ $addr->label }}</span> @endif
                                    <p class="text-sm text-gray-500 mt-1">{{ $addr->phone }}</p>
                                    <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ $addr->full_address }}, {{ $addr->city }} - {{ $addr->postal_code }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('address_id') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
                @else
                    <div class="text-center py-6 bg-yellow-50 rounded border border-yellow-100">
                        <p class="text-yellow-700 mb-4">You do not have a saved address.</p>
                        <a href="{{ route('account') }}" class="btn btn-secondary text-sm">Add Address in Profile</a>
                    </div>
                @endif
            </div>

            <!-- Payment Method -->
            <div id="step-2" class="bg-white rounded shadow-sm border border-gray-100 p-6 transform transition-all duration-500 ease-out hover:shadow-lg">
                <h3 class="font-serif font-bold text-lg border-b pb-4 mb-4">2. Payment Method</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($payment_methods as $key => $label)
                    <label class="relative border rounded-sm p-4 cursor-pointer transition-all duration-300 ease-in-out hover:shadow-md {{ $payment_method === $key ? 'border-sigmaven-forest ring-1 ring-sigmaven-forest bg-green-50/30 scale-[1.03] shadow-md' : 'border-gray-200 hover:border-gray-400' }}">
                        <input type="radio" wire:model.live="payment_method" value="{{ $key }}" class="hidden">
                        
                        <!-- Icon centang jika dipilih -->
                        <div class="absolute top-1 right-1 transition-all duration-300 {{ $payment_method === $key ? 'scale-100' : 'scale-0' }}">
                            <svg class="w-4 h-4 text-sigmaven-forest" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>

                        <div class="flex flex-col items-center">
                            @switch($key)
                                @case('bank_transfer')
                                    <x-heroicon-o-building-library class="w-8 h-8 text-sigmaven-forest" />
                                    @break
                                @case('credit_card')
                                    <x-heroicon-o-credit-card class="w-8 h-8 text-sigmaven-forest" />
                                    @break
                                @case('ewallet')
                                    <x-heroicon-o-wallet class="w-8 h-8 text-sigmaven-forest" />
                                    @break
                                @case('cash_on_delivery')
                                    <x-heroicon-o-banknotes class="w-8 h-8 text-sigmaven-forest" />
                                    @break
                            @endswitch
                            <span class="block text-sm text-center mt-2">{{ $label }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('payment_method') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror
            </div>
            
            <!-- Coupon Code -->
            <div id="step-3" class="bg-white rounded shadow-sm border border-gray-100 p-6 transform transition-all duration-500 ease-out hover:shadow-lg">
                <h3 class="font-serif font-bold text-lg border-b pb-4 mb-4">3. Coupon Code</h3>
                <div class="flex gap-2">
                    <input type="text" wire:model="coupon_code" placeholder="Enter coupon code" class="flex-1 border-gray-300 rounded focus:ring focus:ring-sigmaven-forest/20 focus:border-sigmaven-forest">
                    <button type="button" wire:click="applyCoupon" class="btn btn-secondary">Apply</button>
                </div>
                @if($applied_coupon)
                    <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded transition-all duration-300 ease-in-out animate-fade-in-up">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-bold text-green-800">{{ $applied_coupon->code }}</span>
                                <span class="text-sm text-green-700 ml-2">{{ $applied_coupon->name }}</span>
                            </div>
                            <button type="button" wire:click="removeCoupon" class="text-red-500 text-sm hover:text-red-700 transition-colors duration-200">
                                Remove
                            </button>
                        </div>
                        @if($applied_coupon->type === 'percentage')
                            <div class="text-sm text-green-700 mt-1">
                                {{ $applied_coupon->value }}% discount applied
                            </div>
                        @else
                            <div class="text-sm text-green-700 mt-1">
                                Rp {{ number_format($applied_coupon->value, 0, ',', '.') }} discount applied
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Notes -->
            <div id="step-4" class="bg-white rounded shadow-sm border border-gray-100 p-6 transform transition-all duration-500 ease-out hover:shadow-lg">
                <h3 class="font-serif font-bold text-lg border-b pb-4 mb-4">Order Notes (Optional)</h3>
                <textarea wire:model="notes" rows="3" class="w-full rounded border-gray-300 focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20 text-sm" placeholder="Special delivery instructions..."></textarea>
            </div>
            
        </div>

        <!-- Order Summary -->
        <div class="lg:w-1/3">
            <div class="bg-white rounded shadow-sm border border-gray-100 p-6 sticky top-24 transition-all duration-300">
                <h3 class="font-serif font-bold text-lg border-b pb-4 mb-4">Your Order</h3>
                
                <div class="space-y-4 mb-6 max-h-64 overflow-y-auto pr-2">
                    @foreach($items as $item)
                        @php $price = $item->product->discount_price ?? $item->product->price; @endphp
                        <div class="flex items-start justify-between transition-all duration-200 hover:bg-gray-50 px-1 py-0.5 rounded">
                            <div class="flex-1 pr-4">
                                <p class="text-sm font-medium text-gray-800 line-clamp-1">{{ $item->product->title }}</p>
                                <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($price, 0, ',', '.') }}</p>
                            </div>
                            <span class="text-sm font-medium text-gray-800">Rp {{ number_format($price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-gray-100 pt-4 space-y-3 mb-6">
                    <div class="flex justify-between text-gray-600 text-sm transition-colors duration-200">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600 text-sm transition-colors duration-200">
                        <span>Shipping</span>
                        <span>Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                    </div>
                    @if($discount > 0)
                    <div class="flex justify-between text-green-600 text-sm animate-fade-in-up transition-all duration-300">
                        <span>Discount</span>
                        <span>-Rp {{ number_format($discount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between font-bold text-lg text-sigmaven-charcoal pt-3 border-t border-gray-200 transition-all duration-300">
                        <span>Total Payment</span>
                        <span class="text-sigmaven-forest">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-full py-3 shadow-sm relative flex items-center justify-center overflow-hidden transition-all duration-300 hover:shadow-md active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed" wire:loading.attr="disabled" wire:target="processCheckout">
                    <span wire:loading.remove>Complete Order</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.4s ease-out forwards;
    }
</style>