@props([
    'label' => null,
    'required' => false,
    'placeholder' => 'Select an option',
    'visibleForAcquirers' => [],
    'currentAcquirers' => [],
    'visibleForAcquirer' => null,
    'onboardingAcquirers' => [],
])

@php
    $normalizeTokens = function ($value) {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            $value = json_last_error() === JSON_ERROR_NONE ? $decoded : [$value];
        }

        if ($value instanceof \Illuminate\Support\Collection) {
            $value = $value->all();
        }

        if (!is_array($value)) {
            return [];
        }

        return collect($value)
            ->map(fn ($item) => strtolower(trim((string) $item)))
            ->filter()
            ->values()
            ->all();
    };

    $legacyVisible = is_string($visibleForAcquirer) && trim($visibleForAcquirer) !== ''
        ? [trim($visibleForAcquirer)]
        : [];
    $targetAcquirers = array_values(array_unique(array_merge(
        $normalizeTokens($visibleForAcquirers),
        $normalizeTokens($legacyVisible)
    )));

    $activeAcquirers = array_values(array_unique(array_merge(
        $normalizeTokens($currentAcquirers),
        $normalizeTokens($onboardingAcquirers)
    )));

    $hasVisibilityRule = !empty($targetAcquirers);
    $matchesAcquirer = !empty(array_intersect($targetAcquirers, $activeAcquirers));
    $shouldRender = !$hasVisibilityRule || $matchesAcquirer;

    $isMultiple = $attributes->has('multiple');
@endphp

@if($shouldRender)

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
        @if($placeholder && !$isMultiple)
            <option value="" disabled selected>{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>
</div>
@endif
