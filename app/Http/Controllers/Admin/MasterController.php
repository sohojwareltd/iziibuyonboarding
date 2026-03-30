<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcquirerMaster;
use App\Models\Country;
use App\Models\KYCFieldMaster;
use App\Models\KycSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MasterController extends Controller
{
    public function solutionMaster(): View
    {
        return view('admin.masters.solution-master');
    }

    public function acquirerMaster(): View
    {
        return view('admin.masters.acquirer-master');
    }

    public function paymentMethodMaster(): View
    {
        return view('admin.masters.payment-method-master');
    }

    public function documentTypeMaster(): View
    {
        return view('admin.masters.document-type-master');
    }

    public function kycFieldMaster(): View
    {
        return view('admin.masters.kyc-field-master');
    }

    public function acquirerFieldMapping(): View
    {
        $this->ensureSectionFieldMappings();

        $kycSections = KycSection::active()->ordered()->get();

        $fieldsBySection = KYCFieldMaster::query()
            ->select('k_y_c_field_masters.*', 'm.kyc_section_id as mapped_section_id', 'm.sort_order as mapped_sort_order')
            ->join('kyc_section_field_mappings as m', 'm.field_id', '=', 'k_y_c_field_masters.id')
            ->where('k_y_c_field_masters.status', 'active')
            ->orderBy('m.sort_order')
            ->orderBy('k_y_c_field_masters.id')
            ->get()
            ->groupBy('mapped_section_id');

        $kycSections->each(function ($section) use ($fieldsBySection) {
            $section->setRelation('kycFields', $fieldsBySection->get($section->id, collect())->values());
        });

        $acquirers = AcquirerMaster::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();

        return view('admin.masters.acquirer-field-mapping', compact('kycSections', 'acquirers', 'countries'));
    }

    public function syncAcquirerFieldMapping(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.field_id' => 'required|integer|exists:k_y_c_field_masters,id',
            'items.*.kyc_section_id' => 'required|integer|exists:kyc_sections,id',
            'items.*.sort_order' => 'required|integer|min:0',
            'field_visibility' => 'nullable|array',
            'field_visibility.*.field_id' => 'required|integer|exists:k_y_c_field_masters,id',
            'field_visibility.*.visible_countries' => 'nullable|array',
            'field_visibility.*.visible_countries.*' => 'string|max:10',
            'field_visibility.*.visible_acquirers' => 'nullable|array',
            'field_visibility.*.visible_acquirers.*' => 'string|max:255',
            'sections' => 'nullable|array',
            'sections.*.section_id' => 'required|integer|exists:kyc_sections,id',
            'sections.*.sort_order' => 'required|integer|min:0',
        ]);

        $upsertRows = collect($validated['items'])
            ->map(fn ($item) => [
                'kyc_section_id' => (int) $item['kyc_section_id'],
                'field_id' => (int) $item['field_id'],
                'sort_order' => (int) $item['sort_order'],
                'created_at' => now(),
                'updated_at' => now(),
            ])
            ->unique(fn ($item) => $item['kyc_section_id'] . ':' . $item['field_id'])
            ->values();

        $fieldVisibility = collect($validated['field_visibility'] ?? [])
            ->keyBy(fn ($item) => (int) $item['field_id']);

        $updatedFields = DB::transaction(function () use ($validated, $upsertRows, $fieldVisibility) {
            DB::table('kyc_section_field_mappings')->delete();

            if ($upsertRows->isNotEmpty()) {
                DB::table('kyc_section_field_mappings')->insert($upsertRows->all());
            }

            $primarySectionIds = $upsertRows
                ->sortBy(['field_id', 'sort_order'])
                ->groupBy('field_id')
                ->map(fn ($rows) => (int) $rows->first()['kyc_section_id']);

            $fieldsToUpdate = KYCFieldMaster::query()
                ->whereIn('id', $primarySectionIds->keys()->all())
                ->get()
                ->keyBy('id');

            foreach ($primarySectionIds as $fieldId => $sectionId) {
                $field = $fieldsToUpdate->get((int) $fieldId);

                if (!$field) {
                    continue;
                }

                $field->kyc_section_id = $sectionId;
                $field->save();
            }

            if ($fieldVisibility->isNotEmpty()) {
                $fields = KYCFieldMaster::query()
                    ->whereIn('id', $fieldVisibility->keys())
                    ->get();

                foreach ($fields as $field) {
                    $visibility = $fieldVisibility->get($field->id, []);
                    $visibleCountries = collect($visibility['visible_countries'] ?? [])
                        ->map(fn ($value) => strtoupper(trim((string) $value)))
                        ->filter()
                        ->unique()
                        ->values()
                        ->all();
                    $visibleAcquirers = collect($visibility['visible_acquirers'] ?? [])
                        ->map(fn ($value) => strtolower(trim((string) $value)))
                        ->filter()
                        ->unique()
                        ->values()
                        ->all();

                    $field->visible_countries = empty($visibleCountries) ? null : $visibleCountries;
                    $field->visible_acquirers = empty($visibleAcquirers) ? null : $visibleAcquirers;
                    $field->save();
                }
            }

            foreach (($validated['sections'] ?? []) as $sectionItem) {
                KycSection::query()
                    ->whereKey($sectionItem['section_id'])
                    ->update(['sort_order' => (int) $sectionItem['sort_order']]);
            }

            return $fieldsToUpdate
                ->map(fn (KYCFieldMaster $field) => [
                    'field_id' => (int) $field->id,
                    'kyc_section_id' => (int) $field->kyc_section_id,
                    'internal_key' => (string) $field->internal_key,
                ])
                ->values()
                ->all();
        });

        return response()->json([
            'success' => true,
            'message' => 'Field mapping updated successfully.',
            'fields' => $updatedFields,
        ]);
    }

    private function ensureSectionFieldMappings(): void
    {
        $mappedFieldIds = DB::table('kyc_section_field_mappings')->pluck('field_id')->all();

        $missingFields = KYCFieldMaster::query()
            ->where('status', 'active')
            ->when(!empty($mappedFieldIds), fn ($query) => $query->whereNotIn('id', $mappedFieldIds))
            ->get(['id', 'kyc_section_id', 'sort_order']);

        if ($missingFields->isEmpty()) {
            return;
        }

        $now = now();
        $rows = $missingFields->map(fn ($field) => [
            'kyc_section_id' => (int) $field->kyc_section_id,
            'field_id' => (int) $field->id,
            'sort_order' => (int) $field->sort_order,
            'created_at' => $now,
            'updated_at' => $now,
        ])->all();

        DB::table('kyc_section_field_mappings')->insert($rows);
    }

    public function priceListMaster(): View
    {
        return view('admin.masters.price-list-master');
    }
}
