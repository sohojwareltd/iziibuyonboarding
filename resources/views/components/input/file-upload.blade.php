@props(['label' => null, 'name' => null, 'value' => null, 'required' => false, 'accept' => '.pdf,.jpg,.jpeg,.png', 'maxSize' => '5MB', 'icon' => 'cloud-arrow-up'])

@php
    $inputId = 'file-upload-' . str_replace('.', '', uniqid('', true));
    $existingFilePath = is_string($value) && trim($value) !== '' ? trim($value) : null;
    $existingFileName = $existingFilePath ? basename($existingFilePath) : '';
    $existingFileExtension = strtolower(pathinfo($existingFileName, PATHINFO_EXTENSION));
    $existingImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
    $isExistingImage = in_array($existingFileExtension, $existingImageExtensions, true);
    $existingFileUrl = null;

    $existingFileIcon = match(true) {
        $isExistingImage                               => 'fa-file-image',
        $existingFileExtension === 'pdf'               => 'fa-file-pdf',
        in_array($existingFileExtension, ['doc', 'docx']) => 'fa-file-word',
        in_array($existingFileExtension, ['xls', 'xlsx']) => 'fa-file-excel',
        default                                        => 'fa-file',
    };

    if ($existingFilePath) {
        if (\Illuminate\Support\Str::startsWith($existingFilePath, ['http://', 'https://', '/storage/'])) {
            $existingFileUrl = $existingFilePath;
        } else {
            $existingFileUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($existingFilePath);
        }
    }

    $acceptDisplay = collect(explode(',', (string) $accept))
        ->map(fn ($item) => strtoupper(trim((string) $item, " .\t\n\r\0\x0B")))
        ->filter()
        ->implode(', ');

    $existingValueInputName = $name ? str_replace('[value]', '[existing_value]', $name) : null;
@endphp

<label
    for="{{ $inputId }}"
    data-file-upload
    {{ $attributes->merge([
        'class' => 'file-upload-zone bg-white rounded-xl border-2 border-dashed border-gray-300 p-6 text-center cursor-pointer hover:border-accent transition-colors block'
    ]) }}
>
    <div data-file-upload-empty class="{{ $existingFilePath ? 'hidden' : '' }}">
        <i class="fa-solid fa-{{ $icon }} text-3xl text-gray-400 mb-3"></i>

        @if($label)
            <p class="text-sm font-medium text-gray-700 mb-1">
                {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
            </p>
        @endif

        <p class="text-xs text-gray-500">
            Upload {{ $acceptDisplay }} (Max {{ $maxSize }})
        </p>
    </div>
    
    <input 
        id="{{ $inputId }}"
        type="file" 
        class="hidden"
        data-file-upload-input
        @if($name) name="{{ $name }}" @endif
        accept="{{ $accept }}"
        @if($required && !$existingFilePath) required @endif
    >

    @if($existingValueInputName)
        <input
            type="hidden"
            name="{{ $existingValueInputName }}"
            value="{{ $existingFilePath }}"
            data-file-upload-existing-input
        >
    @endif

    <div class="mt-2 {{ $existingFilePath ? '' : 'hidden' }}" data-file-upload-preview>
        <img
            class="{{ $isExistingImage && $existingFileUrl ? '' : 'hidden' }} mx-auto mb-3 max-h-48 w-full object-contain rounded-lg border border-gray-200 bg-gray-50"
            data-file-upload-image-preview
            alt="Image preview"
            @if($existingFileUrl) src="{{ $existingFileUrl }}" @endif
        >

        <div class="flex items-center justify-between gap-3 text-left">
            <div class="flex items-center gap-3 min-w-0">
                <i class="fa-solid {{ $existingFileIcon }} text-xl text-brand-orange" data-file-upload-file-icon></i>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate" data-file-upload-name-preview>{{ $existingFileName }}</p>
                    <p class="text-xs text-gray-500" data-file-upload-status-text>{{ $existingFilePath ? 'Previously uploaded' : 'Ready to upload' }}</p>
                </div>
            </div>
            <button
                type="button"
                data-file-upload-clear
                class="text-red-500 hover:text-red-700 p-1 shrink-0"
                aria-label="Remove file"
            >
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
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
            const existingInput = wrapper.querySelector('[data-file-upload-existing-input]');
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

            const fileIcon = wrapper.querySelector('[data-file-upload-file-icon]');
            const statusText = wrapper.querySelector('[data-file-upload-status-text]');

            previewWrap.classList.remove('hidden');
            emptyWrap.classList.add('hidden');
            wrapper.classList.add('bg-green-50', 'border-green-300');
            namePreview.textContent = file.name;

            if (existingInput) {
                existingInput.value = '';
            }

            if (fileIcon) {
                if (file.type && file.type.startsWith('image/')) {
                    fileIcon.className = 'fa-solid fa-file-image text-xl text-brand-orange';
                } else if (file.type === 'application/pdf') {
                    fileIcon.className = 'fa-solid fa-file-pdf text-xl text-brand-orange';
                } else if (file.type && (file.type.includes('word') || file.type.includes('document'))) {
                    fileIcon.className = 'fa-solid fa-file-word text-xl text-brand-orange';
                } else {
                    fileIcon.className = 'fa-solid fa-file text-xl text-brand-orange';
                }
            }

            if (statusText) {
                const sizeKB = (file.size / 1024).toFixed(1);
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                statusText.textContent = file.size > 1024 * 1024
                    ? `Ready to upload · ${sizeMB} MB`
                    : `Ready to upload · ${sizeKB} KB`;
            }

            if (file.type && file.type.startsWith('image/')) {
                const objectUrl = URL.createObjectURL(file);
                imagePreview.src = objectUrl;
                imagePreview.classList.remove('hidden');
                imagePreview.onload = function() {
                    URL.revokeObjectURL(objectUrl);
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
            const existingInput = wrapper.querySelector('[data-file-upload-existing-input]');

            if (input) {
                input.value = '';
            }

            if (existingInput) {
                existingInput.value = '';
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
