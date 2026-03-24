<?php

namespace App\Services;

use App\Models\Information;
use App\Models\KYCFieldMaster;
use App\Models\KycSection;
use App\Models\Onboarding;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class KycFieldDataService
{
    public function saveForSection(Onboarding|int $onboarding, KycSection|int|string $section, array $dynamicFields, int $groupIndex = 0): void
    {
        $onboardingId = $this->resolveOnboardingId($onboarding);
        $sectionId = $this->resolveSectionId($section);
        $normalized = $this->normalizeDynamicFields($dynamicFields);

        if (empty($normalized)) {
            return;
        }

        $fieldIds = array_column($normalized, 'field_id');
        $validFields = KYCFieldMaster::query()
            ->whereIn('id', $fieldIds)
            ->where('kyc_section_id', $sectionId)
            ->get()
            ->keyBy('id');

        foreach ($normalized as $entry) {
            $field = $validFields->get($entry['field_id']);

            if (! $field) {
                continue;
            }

            $value = $entry['value'];
            if ($value instanceof UploadedFile) {
                $value = $value->store('kyc/uploads', 'public');
            }

            $existing = Information::query()->where([
                'onboarding_id' => $onboardingId,
                'kyc_section_id' => $sectionId,
                'kyc_field_master_id' => $field->id,
                'group_index' => $groupIndex,
            ])->first();

            if (
                is_string($value)
                && str_starts_with($value, 'kyc/uploads/')
                && $existing?->field_value
                && is_string($existing->field_value)
                && $existing->field_value !== $value
                && str_starts_with($existing->field_value, 'kyc/uploads/')
            ) {
                Storage::disk('public')->delete($existing->field_value);
            }

            $storedValue = is_array($value)
                ? json_encode($value)
                : ($value === null ? null : (string) $value);

            Information::updateOrCreate(
                [
                    'onboarding_id' => $onboardingId,
                    'kyc_section_id' => $sectionId,
                    'kyc_field_master_id' => $field->id,
                    'group_index' => $groupIndex,
                ],
                [
                    'field_key' => $entry['key'] ?? $field->internal_key,
                    'field_value' => $storedValue,
                ]
            );
        }
    }

    public function getForSection(Onboarding|int $onboarding, KycSection|int|string $section, int $groupIndex = 0): array
    {
        $onboardingId = $this->resolveOnboardingId($onboarding);
        $sectionId = $this->resolveSectionId($section);

        return Information::query()
            ->where('onboarding_id', $onboardingId)
            ->where('kyc_section_id', $sectionId)
            ->where('group_index', $groupIndex)
            ->get(['kyc_field_master_id', 'field_value'])
            ->mapWithKeys(fn (Information $item) => [
                $item->kyc_field_master_id => $this->decodeValue($item->field_value),
            ])
            ->all();
    }

    public function getGroupedForSection(Onboarding|int $onboarding, KycSection|int|string $section): array
    {
        $onboardingId = $this->resolveOnboardingId($onboarding);
        $sectionId = $this->resolveSectionId($section);

        return Information::query()
            ->where('onboarding_id', $onboardingId)
            ->where('kyc_section_id', $sectionId)
            ->orderBy('group_index')
            ->get(['group_index', 'kyc_field_master_id', 'field_value'])
            ->groupBy('group_index')
            ->map(function ($rows) {
                return $rows->mapWithKeys(fn (Information $item) => [
                    $item->kyc_field_master_id => $this->decodeValue($item->field_value),
                ])->all();
            })
            ->all();
    }

    private function resolveOnboardingId(Onboarding|int $onboarding): int
    {
        return $onboarding instanceof Onboarding ? $onboarding->id : $onboarding;
    }

    private function normalizeDynamicFields(array $dynamicFields): array
    {
        $normalized = [];

        foreach ($dynamicFields as $index => $item) {
            if (is_array($item) && array_key_exists('field_id', $item)) {
                $fieldId = (int) $item['field_id'];
                $value = $item['value'] ?? null;
                $key = $item['key'] ?? null;
            } else {
                $fieldId = is_numeric($index) ? (int) $index : 0;
                $key = is_array($item) ? ($item['key'] ?? null) : null;

                if (is_array($item)) {
                    $value = $item['value'] ?? null;
                } else {
                    $value = $item;
                }
            }

            if ($fieldId <= 0) {
                continue;
            }

            $normalized[] = [
                'field_id' => $fieldId,
                'key' => $key,
                'value' => $value,
            ];
        }

        return $normalized;
    }

    private function resolveSectionId(KycSection|int|string $section): int
    {
        if ($section instanceof KycSection) {
            return $section->id;
        }

        if (is_int($section)) {
            return $section;
        }

        return (int) KycSection::query()->where('slug', $section)->value('id');
    }

    private function decodeValue(?string $value): mixed
    {
        if ($value === null || $value === '') {
            return $value;
        }

        $decoded = json_decode($value, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
    }
}
