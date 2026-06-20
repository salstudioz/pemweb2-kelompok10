@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center text-center px-4">
    <h1 class="text-6xl font-serif font-bold text-red-500 mb-4">500</h1>
    <h2 class="text-2xl font-semibold text-sigmaven-charcoal mb-4">Kesalahan Internal Server</h2>
    <p class="text-gray-500 max-w-md mx-auto mb-8">Maaf, ada sesuatu yang salah di sisi server kami. Tim teknis Sigmaven sedang berusaha memperbaikinya.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection