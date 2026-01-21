@props(['label' => null, 'required' => false, 'icon' => null, 'prefix' => null, 'suffix' => null, 'min' => null, 'max' => null])

@if($label)
    <label @if($attributes->has('id')) for="{{ $attributes->get('id') }}" @endif class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
@endif

<div class="relative">
    @if($icon)
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
            <i class="fa-solid fa-{{ $icon }}"></i>
        </span>
    @endif
    
    @if($prefix)
        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm">{{ $prefix }}</span>
    @endif
    
    <input 
        type="number" 
        {{ $attributes->merge([
            'class' => 'w-full rounded-md border border-gray-300 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors' . 
            ($icon ? ' pl-10' : ($prefix ? ' pl-14' : ' px-4')) . 
            ($suffix ? ' pr-8' : ' pr-4')
        ]) }}
        @if($required) required @endif
        @if($min !== null) min="{{ $min }}" @endif
        @if($max !== null) max="{{ $max }}" @endif
    >
    
    @if($suffix)
        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">{{ $suffix }}</span>
    @endif
</div>
