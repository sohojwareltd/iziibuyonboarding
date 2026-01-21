@props(['label' => null, 'required' => false, 'accept' => 'image/*', 'alt' => 'Upload image'])

@if($label)
    <label @if($attributes->has('id')) for="{{ $attributes->get('id') }}" @endif class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
@endif

<input 
    type="file" 
    {{ $attributes->merge([
        'class' => 'block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-white focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100'
    ]) }}
    accept="{{ $accept }}"
    @if($required) required @endif
>
