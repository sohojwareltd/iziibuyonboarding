@props(['label' => null, 'name' => null, 'required' => false, 'accept' => '.pdf,.jpg,.jpeg,.png', 'maxSize' => '5MB', 'icon' => 'cloud-arrow-up'])

@php
    $inputId = 'file-upload-' . str_replace('.', '', uniqid('', true));
@endphp

<label
    for="{{ $inputId }}"
    data-file-upload
    {{ $attributes->merge([
        'class' => 'file-upload-zone bg-white rounded-xl border-2 border-dashed border-gray-300 p-6 text-center cursor-pointer hover:border-accent transition-colors block'
    ]) }}
>
    <div data-file-upload-empty>
        <i class="fa-solid fa-{{ $icon }} text-3xl text-gray-400 mb-3"></i>

        @if($label)
            <p class="text-sm font-medium text-gray-700 mb-1">
                {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
            </p>
        @endif

        <p class="text-xs text-gray-500">
            Upload {{ strtoupper(str_replace(['.', ','], '', $accept)) }} (Max {{ $maxSize }})
        </p>
    </div>
    
    <input 
        id="{{ $inputId }}"
        type="file" 
        class="hidden"
        data-file-upload-input
        @if($name) name="{{ $name }}" @endif
        accept="{{ $accept }}"
        @if($required) required @endif
    >

    <div class="mt-2 hidden" data-file-upload-preview>
        <div class="flex items-center justify-between gap-3 text-left">
            <div class="flex items-center gap-3 min-w-0">
                <i class="fa-solid fa-file text-xl text-brand-orange" data-file-upload-file-icon></i>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate" data-file-upload-name-preview></p>
                    <p class="text-xs text-gray-500">Uploaded successfully</p>
                </div>
            </div>
            <button
                type="button"
                data-file-upload-clear
                class="text-red-500 hover:text-red-700 p-1"
                aria-label="Remove file"
            >
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <img class="hidden mx-auto mt-3 max-h-40 rounded-md border border-gray-200" data-file-upload-image-preview alt="File preview">
    </div>
</label>

@once
    @php
        $fileUploadPreviewScript = <<<'JS'
<script>
    if (!window.__fileUploadPreviewBound) {
        window.__fileUploadPreviewBound = true;

        document.addEventListener('change', function(event) {
            const input = event.target;
            if (!input.matches('[data-file-upload-input]')) {
                return;
            }

            const wrapper = input.closest('[data-file-upload]');
            if (!wrapper) {
                return;
            }

            const previewWrap = wrapper.querySelector('[data-file-upload-preview]');
            const emptyWrap = wrapper.querySelector('[data-file-upload-empty]');
            const imagePreview = wrapper.querySelector('[data-file-upload-image-preview]');
            const namePreview = wrapper.querySelector('[data-file-upload-name-preview]');
            const file = input.files && input.files[0] ? input.files[0] : null;

            if (!previewWrap || !emptyWrap || !imagePreview || !namePreview) {
                return;
            }

            if (!file) {
                previewWrap.classList.add('hidden');
                emptyWrap.classList.remove('hidden');
                wrapper.classList.remove('bg-green-50', 'border-green-300');
                imagePreview.classList.add('hidden');
                imagePreview.src = '';
                namePreview.textContent = '';
                return;
            }

            previewWrap.classList.remove('hidden');
            emptyWrap.classList.add('hidden');
            wrapper.classList.add('bg-green-50', 'border-green-300');
            namePreview.textContent = file.name;

            if (file.type && file.type.startsWith('image/')) {
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.classList.remove('hidden');
                imagePreview.onload = function() {
                    URL.revokeObjectURL(imagePreview.src);
                };
            } else {
                imagePreview.classList.add('hidden');
                imagePreview.src = '';
            }
        });

        document.addEventListener('click', function(event) {
            const clearBtn = event.target.closest('[data-file-upload-clear]');
            if (!clearBtn) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();

            const wrapper = clearBtn.closest('[data-file-upload]');
            if (!wrapper) {
                return;
            }

            const input = wrapper.querySelector('[data-file-upload-input]');
            const previewWrap = wrapper.querySelector('[data-file-upload-preview]');
            const emptyWrap = wrapper.querySelector('[data-file-upload-empty]');
            const imagePreview = wrapper.querySelector('[data-file-upload-image-preview]');
            const namePreview = wrapper.querySelector('[data-file-upload-name-preview]');

            if (input) {
                input.value = '';
            }

            wrapper.classList.remove('bg-green-50', 'border-green-300');
            previewWrap?.classList.add('hidden');
            emptyWrap?.classList.remove('hidden');

            if (imagePreview) {
                imagePreview.src = '';
                imagePreview.classList.add('hidden');
            }

            if (namePreview) {
                namePreview.textContent = '';
            }
        });
    }
</script>
JS;
    @endphp

    @push('scripts')
        {!! $fileUploadPreviewScript !!}
    @endpush

    @push('js')
        {!! $fileUploadPreviewScript !!}
    @endpush
@endonce
