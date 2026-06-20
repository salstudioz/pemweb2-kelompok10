<div>
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="text-3xl font-serif font-bold text-sigmaven-forest inline-block mb-2">Sigmaven.</a>
        <h2 class="text-2xl font-bold text-sigmaven-charcoal mt-4">Selamat Datang Kembali</h2>
        <p class="text-sm text-gray-500 mt-2">Silakan login ke akun Anda</p>
    </div>

    <form wire:submit.prevent="login" class="space-y-6">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input wire:model="email" id="email" type="email" required class="w-full rounded border-gray-300 focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20">
            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <div class="flex justify-between items-center mb-1">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            </div>
            <input wire:model="password" id="password" type="password" required class="w-full rounded border-gray-300 focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20">
            @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input wire:model="remember" id="remember" type="checkbox" class="h-4 w-4 text-sigmaven-forest focus:ring-sigmaven-forest border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat Saya</label>
            </div>
        </div>

        <button type="submit" class="w-full btn btn-primary py-2.5">Login</button>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
        Belum punya akun? <a href="{{ route('register') }}" class="text-sigmaven-gold hover:text-sigmaven-gold-dark font-medium">Daftar sekarang</a>
    </div>
</div>