@props(['label' => null, 'required' => false, 'rows' => 4])

@if($label)
    <label @if($attributes->has('id')) for="{{ $attributes->get('id') }}" @endif class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>
@endif

<textarea 
    rows="{{ $rows }}"
    {{ $attributes->merge([
        'class' => 'w-full rounded-md border border-gray-300 px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:border-accent focus:ring-1 focus:ring-accent outline-none transition-colors resize-y'
    ]) }}
    @if($required) required @endif
>{{ $slot }}</textarea>
