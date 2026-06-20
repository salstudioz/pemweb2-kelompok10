<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sigmaven — A modern literary platform for book lovers. Shop books, play educational games, and join exclusive auctions.">
    <title>{{ config('app.name', 'Sigmaven') }} - Modern Literary Platform</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-sigmaven-cream text-sigmaven-charcoal font-sans flex flex-col min-h-screen">
    @include('layouts.partials.header')
    
    <main id="main-content" 
          x-data="{ loaded: false }" 
          x-init="setTimeout(() => loaded = true, 80)"
          x-show="loaded"
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-2"
          x-transition:enter-end="opacity-100 translate-y-0"
          class="min-h-[70vh] pt-16 flex-1">
        {{ $slot ?? '' }}
        @yield('content')
    </main>
    
    @include('layouts.partials.footer')
    @include('layouts.partials.toast')
    
    @livewireScripts
</body>
</html>