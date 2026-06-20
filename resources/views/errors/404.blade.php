@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center text-center px-4">
    <h1 class="text-6xl font-serif font-bold text-sigmaven-forest mb-4">404</h1>
    <h2 class="text-2xl font-semibold text-sigmaven-charcoal mb-4">Halaman Tidak Ditemukan</h2>
    <p class="text-gray-500 max-w-md mx-auto mb-8">Maaf, halaman yang Anda cari mungkin telah dihapus, namanya diubah, atau sementara tidak tersedia.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection