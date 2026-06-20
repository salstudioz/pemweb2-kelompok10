@props(['rating' => 0, 'size' => 'md', 'showText' => false])

@php
    $sizes = [
        'sm' => 'w-4 h-4',
        'md' => 'w-5 h-5',
        'lg' => 'w-6 h-6',
        'xl' => 'w-8 h-8',
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    
    $ratingText = match(round($rating)) {
        1 => 'Sangat Buruk',
        2 => 'Buruk',
        3 => 'Cukup',
        4 => 'Bagus',
        5 => 'Sangat Bagus',
        default => 'Belum dinilai',
    };
@endphp

<div class="flex items-center gap-1">
    @for($i = 1; $i <= 5; $i++)
        @if($i <= floor($rating))
            <!-- Full star -->
            <svg class="{{ $sizeClass }} text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
        @elseif($i - 0.5 <= $rating)
            <!-- Half star -->
            <svg class="{{ $sizeClass }} text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <defs>
                    <linearGradient id="half-{{ $i }}-{{ uniqid() }}">
                        <stop offset="50%" stop-color="currentColor"></stop>
                        <stop offset="50%" stop-color="#e5e7eb"></stop>
                    </linearGradient>
                </defs>
                <path fill="url(#half-{{ $i }}-{{ uniqid() }})" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
        @else
            <!-- Empty star -->
            <svg class="{{ $sizeClass }} text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
        @endif
    @endfor
    
    @if($showText)
        <span class="ml-2 text-sm text-gray-600 font-medium">{{ $ratingText }}</span>
        <span class="ml-1 text-sm text-gray-500">({{ number_format($rating, 1) }})</span>
    @endif
</div>