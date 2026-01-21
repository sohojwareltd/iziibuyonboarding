@props(['label' => null, 'required' => false, 'checked' => false])

<div class="flex items-center">
    <input 
        type="radio" 
        {{ $attributes->merge([
            'class' => 'w-4 h-4 text-accent bg-white border-gray-300 focus:ring-accent focus:ring-2 cursor-pointer'
        ]) }}
        @if($required) required @endif
        @if($checked) checked @endif
    >
    
    @if($label)
        <label @if($attributes->has('id')) for="{{ $attributes->get('id') }}" @endif class="ml-2 text-sm text-gray-700 cursor-pointer">
            {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif
</div>
