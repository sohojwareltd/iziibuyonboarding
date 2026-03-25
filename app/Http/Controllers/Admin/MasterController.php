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
use Illuminate\Support\Str;
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
        $kycSections = KycSection::active()
            ->ordered()
            ->with(['kycFields' => fn ($q) => $q->where('status', 'active')->orderBy('sort_order')])
            ->get();

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
            'sections' => 'nullable|array',
            'sections.*.section_id' => 'required|integer|exists:kyc_sections,id',
            'sections.*.sort_order' => 'required|integer|min:0',
        ]);

        $fieldIds = collect($validated['items'])->pluck('field_id')->unique()->values();
        $sectionIds = collect($validated['items'])->pluck('kyc_section_id')->unique()->values();
        $orderedSectionIds = collect($validated['sections'] ?? [])->pluck('section_id')->unique()->values();

        $fields = KYCFieldMaster::query()
            ->whereIn('id', $fieldIds)
            ->get()
            ->keyBy('id');

        $sections = KycSection::query()
            ->whereIn('id', $sectionIds->merge($orderedSectionIds))
            ->get()
            ->keyBy('id');

        $updatedFields = [];

        DB::transaction(function () use ($validated, $fields, $sections, &$updatedFields) {
            foreach ($validated['items'] as $item) {
                $field = $fields->get($item['field_id']);
                $section = $sections->get($item['kyc_section_id']);

                if (!$field || !$section) {
                    continue;
                }

                $field->fill([
                    'kyc_section_id' => $item['kyc_section_id'],
                    'sort_order' => $item['sort_order'],
                    'internal_key' => $this->generateSectionPrefixedInternalKey($section, $field),
                ]);
                $field->save();

                $updatedFields[] = [
                    'field_id' => $field->id,
                    'kyc_section_id' => $field->kyc_section_id,
                    'internal_key' => $field->internal_key,
                ];
            }

            foreach (($validated['sections'] ?? []) as $sectionItem) {
                $section = $sections->get($sectionItem['section_id']);

                if (! $section) {
                    continue;
                }

                if ((int) $section->sort_order !== (int) $sectionItem['sort_order']) {
                    $section->sort_order = $sectionItem['sort_order'];
                    $section->save();
                }
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Field mapping updated successfully.',
            'fields' => $updatedFields,
        ]);
    }

    private function generateSectionPrefixedInternalKey(KycSection $section, KYCFieldMaster $field): string
    {
        $sectionPrefix = Str::slug($section->slug ?: $section->name ?: 'section', '_');
        $fieldSlug = Str::slug($field->field_name ?: $field->internal_key ?: 'field', '_');
        $baseKey = trim($sectionPrefix . '_' . $fieldSlug, '_');

        if ($baseKey === '') {
            $baseKey = 'field';
        }

        $candidate = $baseKey;

        while (
            KYCFieldMaster::query()
                ->where('internal_key', $candidate)
                ->whereKeyNot($field->id)
                ->exists()
        ) {
            $candidate = $baseKey . '_' . random_int(1000, 9999);
        }

        return $candidate;
    }

    public function priceListMaster(): View
    {
        return view('admin.masters.price-list-master');
    }
}
