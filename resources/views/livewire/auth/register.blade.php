<div>
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="text-3xl font-serif font-bold text-sigmaven-forest inline-block mb-2">Sigmaven.</a>
        <h2 class="text-2xl font-bold text-sigmaven-charcoal mt-4">Buat Akun Baru</h2>
        <p class="text-sm text-gray-500 mt-2">Gabung dengan komunitas literasi Sigmaven</p>
    </div>

    <form wire:submit.prevent="register" class="space-y-5">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input wire:model="name" id="name" type="text" required class="w-full rounded border-gray-300 focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20">
            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input wire:model="email" id="email" type="email" required class="w-full rounded border-gray-300 focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20">
            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input wire:model="password" id="password" type="password" required class="w-full rounded border-gray-300 focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20">
            @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" required class="w-full rounded border-gray-300 focus:border-sigmaven-forest focus:ring focus:ring-sigmaven-forest/20">
        </div>

        <button type="submit" class="w-full btn btn-primary py-2.5 mt-2">Daftar Akun</button>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
        Sudah punya akun? <a href="{{ route('login') }}" class="text-sigmaven-gold hover:text-sigmaven-gold-dark font-medium">Login di sini</a>
    </div>
</div>