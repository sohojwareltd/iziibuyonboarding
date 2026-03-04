@props([
    'class' => '',
    'variant' => 'light', // 'light' for dark backgrounds (white logo), 'dark' for light backgrounds
    'size' => 'md', // 'sm', 'md', 'lg'
])

@php
    $imgHeight = match($size) { 'sm' => 'h-8', 'lg' => 'h-12', default => 'h-10' };
@endphp

@if ($appLogoUrl ?? null)
    <img src="{{ $appLogoUrl }}" alt="{{ config('app.name', '2iZii') }}" {{ $attributes->merge(['class' => $imgHeight . ' w-auto object-contain ' . $class]) }}>
@else
    <svg width="160" height="40" viewBox="0 0 160 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="2iZii Logo" {{ $attributes->merge(['class' => $class]) }}>
        <path d="M20 10C20 4.47715 24.4772 0 30 0H10C4.47715 0 0 4.47715 0 10V30C0 35.5228 4.47715 40 10 40H30C24.4772 40 20 35.5228 20 30V10Z" fill="{{ $variant === 'light' ? 'white' : '#2D3A74' }}"/>
        <circle cx="30" cy="10" r="4" fill="#FF7C00"/>
        <text x="40" y="28" fill="{{ $variant === 'light' ? 'white' : '#2D3A74' }}" font-family="Inter" font-weight="bold" font-size="24">2iZii</text>
    </svg>
@endif
