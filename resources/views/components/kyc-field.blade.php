@props(['field', 'value' => null, 'nameOverride' => null])

@php
    $inputClass = 'w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm';
    $fieldName = $nameOverride ?? "dynamic_fields[{$field->id}][value]";
    $fieldLabel = $field->field_name;
    $isRequired = $field->is_required;
    $dataType = $field->data_type;
    $placeholder = $field->description ?? "Enter {$fieldLabel}";
    $rawOptions = $field->options ?? [];
    $fieldOptions = [];

    if (is_string($rawOptions) && $rawOptions !== '') {
        $decodedOptions = json_decode($rawOptions, true);
        $rawOptions = json_last_error() === JSON_ERROR_NONE ? $decodedOptions : [];
    }

    if (!is_array($rawOptions)) {
        $rawOptions = [];
    }

    foreach ($rawOptions as $opt) {
        if (is_array($opt)) {
            $label = (string) ($opt['label'] ?? $opt['value'] ?? '');
            $optionValue = (string) ($opt['value'] ?? $opt['label'] ?? '');
        } else {
            $label = (string) $opt;
            $optionValue = (string) $opt;
        }

        if ($label === '' && $optionValue === '') {
            continue;
        }

        $fieldOptions[] = [
            'label' => $label,
            'value' => $optionValue,
        ];
    }

    $arrayValue = [];
    if (is_array($value)) {
        $arrayValue = array_map('strval', $value);
    } elseif (is_string($value) && $value !== '') {
        $decodedValue = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decodedValue)) {
            $arrayValue = array_map('strval', $decodedValue);
        }
    }

    $scalarValue = is_array($value) ? null : (isset($value) ? (string) $value : null);
@endphp

<div class="kyc-field" data-field-id="{{ $field->id }}" data-field-type="{{ $dataType }}">
    @if(!$nameOverride)
        <input type="hidden" name="dynamic_fields[{{ $field->id }}][field_id]" value="{{ $field->id }}">
        <input type="hidden" name="dynamic_fields[{{ $field->id }}][key]" value="{{ $field->internal_key }}">
    @endif

    @switch($dataType)
        @case('text')
            <x-input.text 
                :label="$fieldLabel" 
                :placeholder="$placeholder"
                :class="$inputClass"
                :required="$isRequired"
                name="{{ $fieldName }}"
                value="{{ $value }}"
            />
            @break

        @case('email')
            <x-input.email 
                :label="$fieldLabel" 
                :placeholder="$placeholder"
                :class="$inputClass"
                :required="$isRequired"
                name="{{ $fieldName }}"
                value="{{ $value }}"
            />
            @break

        @case('tel')
            <x-input.tel 
                :label="$fieldLabel" 
                :placeholder="$placeholder"
                :class="$inputClass"
                :required="$isRequired"
                name="{{ $fieldName }}"
                value="{{ $value }}"
            />
            @break

        @case('url')
            <x-input.url 
                :label="$fieldLabel" 
                :placeholder="$placeholder"
                :class="$inputClass"
                :required="$isRequired"
                name="{{ $fieldName }}"
                value="{{ $value }}"
            />
            @break

        @case('password')
            <x-input.password 
                :label="$fieldLabel" 
                :placeholder="$placeholder"
                :class="$inputClass"
                :required="$isRequired"
                name="{{ $fieldName }}"
            />
            @break

        @case('number')
            <x-input.number 
                :label="$fieldLabel" 
                :placeholder="$placeholder"
                :class="$inputClass"
                :required="$isRequired"
                name="{{ $fieldName }}"
                value="{{ $value }}"
            />
            @break

        @case('date')
        @case('time')
        @case('datetime-local')
            <x-input.date 
                :label="$fieldLabel" 
                :class="$inputClass"
                :required="$isRequired"
                name="{{ $fieldName }}"
                value="{{ $value }}"
                type="{{ $dataType }}"
            />
            @break

        @case('textarea')
            <x-input.textarea 
                :label="$fieldLabel" 
                :placeholder="$placeholder"
                :class="$inputClass"
                :required="$isRequired"
                :rows="3"
                name="{{ $fieldName }}"
            >{{ $value }}</x-input.textarea>
            @break

        @case('dropdown')
        @case('multi-select')
            @php
                $selectName = $fieldName . ($dataType === 'multi-select' ? '[]' : '');
                $isMultiple = $dataType === 'multi-select';
            @endphp
            <label class="block text-sm font-medium text-gray-700 mb-1">
                {{ $fieldLabel }} @if($isRequired)<span class="text-red-500">*</span>@endif
            </label>
            <select
                name="{{ $selectName }}"
                class="{{ $inputClass }} {{ $isMultiple ? 'js-select2-multi' : '' }}"
                @if($isMultiple) multiple data-placeholder="{{ $placeholder }}" @endif
                @if($isRequired) required @endif
            >
                @if(!$isMultiple)
                    <option value="">{{ $placeholder }}</option>
                @endif
                @foreach($fieldOptions as $option)
                    @php
                        $isSelected = $isMultiple
                            ? in_array((string) $option['value'], $arrayValue, true)
                            : ((string) $option['value'] === (string) $scalarValue);
                    @endphp
                    <option value="{{ $option['value'] }}" @selected($isSelected)>{{ $option['label'] }}</option>
                @endforeach
            </select>
            @break

        @case('checkbox')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $fieldLabel }} @if($isRequired)<span class="text-red-500">*</span>@endif
                </label>
                @if(!empty($fieldOptions))
                    <div class="space-y-2">
                        @foreach($fieldOptions as $option)
                            <label class="flex items-center gap-2.5 cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="{{ $fieldName }}[]"
                                    value="{{ $option['value'] }}"
                                    class="w-4 h-4 border-gray-400 rounded text-blue-600"
                                    @checked(in_array((string) $option['value'], $arrayValue, true))
                                >
                                <span class="text-sm text-gray-700">{{ $option['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                @else
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input
                            type="checkbox"
                            name="{{ $fieldName }}"
                            value="1"
                            class="w-4 h-4 border-gray-400 rounded text-blue-600"
                            @checked($value == '1' || $value === true)
                        >
                        <span class="text-sm text-gray-700">{{ $placeholder }}</span>
                    </label>
                @endif
            </div>
            @break

        @case('radio')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $fieldLabel }} @if($isRequired)<span class="text-red-500">*</span>@endif
                </label>
                @if(!empty($fieldOptions))
                    <div class="space-y-2">
                        @foreach($fieldOptions as $option)
                            <label class="flex items-center gap-2.5 cursor-pointer">
                                <input
                                    type="radio"
                                    name="{{ $fieldName }}"
                                    value="{{ $option['value'] }}"
                                    class="w-4 h-4 border-gray-400 text-blue-600"
                                    @if($isRequired) required @endif
                                    @checked((string) $option['value'] === (string) $scalarValue)
                                >
                                <span class="text-sm text-gray-700">{{ $option['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                @else
                    <x-input.radio 
                        :label="$fieldLabel"
                        :required="$isRequired"
                        name="{{ $fieldName }}"
                        value="{{ $value }}"
                    />
                @endif
            </div>
            @break

        @case('file')
            <x-input.file-upload 
                :label="$fieldLabel"
                :required="$isRequired"
                name="{{ $fieldName }}"
                accept=".pdf,.jpg,.jpeg,.png"
                maxSize="5MB"
            />
            @break

        @case('signature')
            {{-- Custom signature component can be added later --}}
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-600">{{ $fieldLabel }}</p>
                <p class="text-xs text-gray-400 mt-1">Signature field (to be implemented)</p>
            </div>
            @break

        @case('country')
        @case('currency')
        @case('address')
            {{-- These can be specialized components --}}
            <x-input.text 
                :label="$fieldLabel" 
                :placeholder="$placeholder"
                :class="$inputClass"
                :required="$isRequired"
                name="{{ $fieldName }}"
                value="{{ $value }}"
            />
            @break

        @default
            <x-input.text 
                :label="$fieldLabel" 
                :placeholder="$placeholder"
                :class="$inputClass"
                :required="$isRequired"
                name="{{ $fieldName }}"
                value="{{ $value }}"
            />
    @endswitch

    @if($field->description && !in_array($dataType, ['checkbox', 'radio']))
        <p class="text-xs text-gray-500 mt-1">{{ $field->description }}</p>
    @endif
</div>

@once
    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-container .select2-selection--multiple {
                min-height: 42px;
                border: 1px solid #D1D5DB;
                border-radius: 0.5rem;
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
            }

            .select2-container--default.select2-container--focus .select2-selection--multiple {
                border-color: #4055A8;
                box-shadow: 0 0 0 3px rgba(64, 85, 168, 0.1);
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background: #4055A8;
                color: #fff;
                border: none;
                border-radius: 9999px;
                padding: 0 0.5rem;
                margin-top: 0.25rem;
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                color: #fff;
                margin-right: 0.35rem;
                border-right: none;
            }
        </style>
    @endpush
    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof window.jQuery === 'undefined' || typeof window.jQuery.fn.select2 === 'undefined') {
                    return;
                }

                window.jQuery('.js-select2-multi').each(function() {
                    const placeholder = this.dataset.placeholder || 'Select options';
                    window.jQuery(this).select2({
                        width: '100%',
                        placeholder,
                        allowClear: true,
                    });
                });
            });
        </script>
    @endpush
@endonce
