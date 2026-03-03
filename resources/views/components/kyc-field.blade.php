@props(['field', 'value' => null, 'nameOverride' => null])

@php
    $inputClass = 'w-full px-4 py-2.5 border border-brand-inputBorder rounded-lg text-sm';
    $fieldName = $nameOverride ?? $field->internal_key;
    $fieldLabel = $field->field_name;
    $isRequired = $field->is_required;
    $dataType = $field->data_type;
    $placeholder = $field->description ?? "Enter {$fieldLabel}";
@endphp

<div class="kyc-field" data-field-id="{{ $field->id }}" data-field-type="{{ $dataType }}">
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
            <x-input.select 
                :label="$fieldLabel" 
                :placeholder="$placeholder"
                :class="$inputClass"
                :required="$isRequired"
                :name="$selectName"
                :multiple="$isMultiple"
            >
                <option value="">{{ $placeholder }}</option>
                {{-- Options should be added from field configuration or separate table --}}
            </x-input.select>
            @break

        @case('checkbox')
            <div class="flex items-center">
                <x-input.checkbox 
                    :label="$fieldLabel"
                    :required="$isRequired"
                    name="{{ $fieldName }}"
                    value="1"
                    :checked="$value == '1' || $value === true"
                />
            </div>
            @break

        @case('radio')
            <x-input.radio 
                :label="$fieldLabel"
                :required="$isRequired"
                name="{{ $fieldName }}"
                value="{{ $value }}"
            />
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
