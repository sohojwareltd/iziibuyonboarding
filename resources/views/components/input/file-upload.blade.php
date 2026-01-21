@props(['label' => null, 'required' => false, 'accept' => '.pdf,.jpg,.jpeg,.png', 'maxSize' => '5MB', 'icon' => 'cloud-arrow-up'])

<div 
    {{ $attributes->merge([
        'class' => 'upload-zone bg-white rounded-xl border-2 border-dashed border-gray-300 p-6 text-center cursor-pointer hover:border-accent transition-colors'
    ]) }}
    onclick="this.querySelector('input[type=file]').click()"
>
    <i class="fa-solid fa-{{ $icon }} text-3xl text-gray-400 mb-3"></i>
    
    @if($label)
        <p class="text-sm font-medium text-gray-700 mb-1">
            {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
        </p>
    @endif
    
    <p class="text-xs text-gray-500">
        Upload {{ strtoupper(str_replace(['.', ','], '', $accept)) }} (Max {{ $maxSize }})
    </p>
    
    <input 
        type="file" 
        class="hidden" 
        accept="{{ $accept }}"
        @if($required) required @endif
    >
</div>
