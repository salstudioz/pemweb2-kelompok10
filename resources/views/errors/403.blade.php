@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center text-center px-4">
    <div class="bg-sigmaven-gold/10 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-sigmaven-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
    </div>
    <h1 class="text-4xl font-serif font-bold text-sigmaven-forest mb-4">Akses Terbatas</h1>
    <p class="text-gray-500 max-w-md mx-auto mb-8">Halaman ini khusus untuk Member Premium Sigmaven. Tingkatkan paket Anda sekarang untuk membuka akses eksklusif ke Sigame dan LegacyBid.</p>
    <div class="flex space-x-4 justify-center">
        <a href="{{ route('upgrade.premium') }}" class="btn btn-accent">Upgrade ke Premium</a>
        <a href="{{ route('home') }}" class="btn btn-secondary">Kembali ke Beranda</a>
    </div>
</div>
@endsection