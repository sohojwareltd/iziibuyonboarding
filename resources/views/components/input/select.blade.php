@props(['label' => null, 'required' => false, 'placeholder' => 'Select an option'])

@if($label)
    <label @if($attributes->has('id')) for="{{ $attributes->get('id') }}" @endif class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
@endif

<div class="relative">
    <select 
        {{ $attributes->merge([
            'class' => 'w-full rounded-md border border-gray-300 px-4 py-2.5 text-sm text-gray-900 focus:border-accent focus:ring-1 focus:ring-accent outline-none bg-white appearance-none'
        ]) }}
        @if($required) required @endif
    >
        @if($placeholder)
            <option value="" disabled selected>{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>
</div>
