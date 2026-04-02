<?php

namespace App\Http\Controllers\Merchant;

use App\Facades\KycFieldData;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Onboarding;
use App\Models\KycSection;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class KycController extends Controller
{
    private const ARRAY_REQUIRED_TYPES = ['checkbox', 'multi-select'];

    private function normalizeOnboardingCountry(?Onboarding $onboarding): ?string
    {
        if (! $onboarding || empty($onboarding->country_of_operation)) {
            return null;
        }

        $rawCountry = trim((string) $onboarding->country_of_operation);
        if ($rawCountry === '') {
            return null;
        }

        $upperRawCountry = strtoupper($rawCountry);

        if (strlen($upperRawCountry) <= 3) {
            return $upperRawCountry;
        }

        $resolvedCountryCode = Country::query()
            ->where('name', $rawCountry)
            ->orWhere('name', strtoupper($rawCountry))
            ->orWhere('name', strtolower($rawCountry))
            ->value('code');

        return $resolvedCountryCode
            ? strtoupper((string) $resolvedCountryCode)
            : $upperRawCountry;
    }

    private function normalizeOnboardingAcquirers(?Onboarding $onboarding): array
    {
        if (! $onboarding) {
            return [];
        }

        $acquirers = $onboarding->acquirers;
        if (!is_array($acquirers)) {
            return [];
        }

        $normalized = [];
        foreach ($acquirers as $acquirer) {
            $value = trim((string) $acquirer);
            if ($value === '') {
                continue;
            }

            $normalized[] = $value;
            $normalized[] = strtolower($value);
            $normalized[] = strtoupper($value);
        }

        return array_values(array_unique($normalized));
    }

    private function applyFieldVisibilityRules($query, ?Onboarding $onboarding)
    {
        $countryCode = $this->normalizeOnboardingCountry($onboarding);
        $acquirerTokens = $this->normalizeOnboardingAcquirers($onboarding);

        return $query->with('documentType')
            ->where('status', 'active')
            ->where('visible_to_merchant', true)
            ->where(function ($q) use ($countryCode) {
                $q->whereNull('visible_countries')
                    ->orWhereJsonLength('visible_countries', 0);

                if ($countryCode) {
                    $q->orWhereJsonContains('visible_countries', $countryCode)
                        ->orWhereJsonContains('visible_countries', strtolower($countryCode));
                }
            })
            ->where(function ($q) use ($acquirerTokens) {
                $q->whereNull('visible_acquirers')
                    ->orWhereJsonLength('visible_acquirers', 0);

                foreach ($acquirerTokens as $token) {
                    $q->orWhereJsonContains('visible_acquirers', $token);
                }
            })
            ->orderBy('k_y_c_field_masters.sort_order')
            ->orderBy('k_y_c_field_masters.id');
    }

    private function buildDocumentTypeFileRules(KycSection $sectionModel): array
    {
        $rules = [];

        $fileFields = $sectionModel->kycFields
            ->where('data_type', 'file')
            ->filter(fn ($field) => $field->documentType !== null);

        foreach ($fileFields as $field) {
            $allowedTypes = collect((array) $field->documentType->allowed_file_types)
                ->filter(fn ($ext) => is_string($ext) && trim($ext) !== '')
                ->map(fn ($ext) => ltrim(strtolower(trim($ext)), '.'))
                ->unique()
                ->values()
                ->all();

            $maxSizeMb = max((int) ($field->documentType->max_file_size ?? 0), 1);
            $baseRules = ['sometimes', 'file', 'max:' . ($maxSizeMb * 1024)];

            if (!empty($allowedTypes)) {
                $baseRules[] = 'mimes:' . implode(',', $allowedTypes);
            }

            $fieldId = (string) $field->id;
            $rules['dynamic_fields.' . $fieldId . '.value'] = $baseRules;
            $rules['bo_fields.*.' . $fieldId . '.value'] = $baseRules;
            $rules['bm_fields.*.' . $fieldId . '.value'] = $baseRules;
            $rules['as_fields.*.' . $fieldId . '.value'] = $baseRules;
        }

        return $rules;
    }

    private function buildRequiredFieldRules(KycSection $sectionModel): array
    {
        $rules = [];

        $requiredFields = $sectionModel->kycFields
            ->where('is_required', true)
            ->values();

        foreach ($requiredFields as $field) {
            $fieldId = (string) $field->id;
            $isArrayType = in_array($field->data_type, self::ARRAY_REQUIRED_TYPES, true);
            $isFileType = $field->data_type === 'file';

            $singleFieldRules = $isArrayType ? ['required', 'array', 'min:1'] : ['required'];
            $groupFieldRules = $isArrayType ? ['required', 'array', 'min:1'] : ['required'];

            if ($isFileType) {
                $singleFieldRules = ['required_without:dynamic_fields.' . $fieldId . '.existing_value'];
                $groupFieldRules = [];
            }

            $rules['dynamic_fields.' . $fieldId . '.value'] = $singleFieldRules;
            $rules['bo_fields.*.' . $fieldId . '.value'] = $groupFieldRules;
            $rules['bm_fields.*.' . $fieldId . '.value'] = $groupFieldRules;
            $rules['as_fields.*.' . $fieldId . '.value'] = $groupFieldRules;

            if ($isFileType) {
                $rules['bo_fields.*.' . $fieldId . '.value'][] = 'required_without:bo_fields.*.' . $fieldId . '.existing_value';
                $rules['bm_fields.*.' . $fieldId . '.value'][] = 'required_without:bm_fields.*.' . $fieldId . '.existing_value';
                $rules['as_fields.*.' . $fieldId . '.value'][] = 'required_without:as_fields.*.' . $fieldId . '.existing_value';
            }
        }

        return $rules;
    }

    private function resolveOnboardingByKycLink(?string $kyc_link): ?Onboarding
    {
        if (empty($kyc_link)) {
            return null;
        }

        return Onboarding::where('kyc_link', $kyc_link)->first();
    }

    private function resolveFirstSectionRedirectUrl(?string $kycLink): string
    {
        $onboarding = $this->resolveOnboardingByKycLink($kycLink);

        $firstSection = KycSection::query()
            ->where('status', 'active')
            ->whereHas('kycFields', function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->first(['slug']);

        if ($firstSection) {
            if ($firstSection->slug === 'company-information') {
                return route('merchant.kyc.company', ['kyc_link' => $kycLink]);
            }
            return route('merchant.kyc.section', [
                'kyc_link' => $kycLink,
                'section' => $firstSection->slug,
            ]);
        }

        return route('merchant.kyc.company', ['kyc_link' => $kycLink]);
    }

    public function welcome($kyc_link = null): View
    {
        $onboarding = null;
        if ($kyc_link) {
            $onboarding = Onboarding::where('kyc_link', $kyc_link)->with('solution')->firstOrFail();
        }
        return view('merchant.kyc.welcome', ['onboarding' => $onboarding, 'kyc_link' => $kyc_link]);
    }

    public function company($kyc_link = null): View
    {
        $onboarding = $this->resolveOnboardingByKycLink($kyc_link);


        $section = KycSection::where('slug', 'company-information')
            ->with(['kycFields' => function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
            }])
            ->firstOrFail();

        $sections = KycSection::query()
            ->where('status', 'active')
            ->whereHas('kycFields', function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'name', 'slug', 'sort_order']);

        $currentIndex = $sections->search(fn ($item) => $item->slug === $section->slug);
        $nextSection = $currentIndex !== false ? $sections->get($currentIndex + 1) : null;

        $savedValues = $onboarding
            ? KycFieldData::getForSection($onboarding, $section)
            : [];
        
        return view('merchant.kyc.company', [
            'kyc_link' => $kyc_link,
            'onboarding_id' => $onboarding?->id,
            'onboarding' => $onboarding,
            'section' => $section,
            'fields' => $section->kycFields,
            'savedValues' => $savedValues,
            'nextSection' => $nextSection,
        ]);
    }

    public function saveCompany(Request $request, string $kyc_link): JsonResponse
    {
        try {
            $onboardingId = (int) $request->input('onboarding_id');
            if ($onboardingId <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid onboarding context.',
                ], 422);
            }

            $onboarding = Onboarding::find($onboardingId);

            if (! $onboarding) {
                return response()->json([
                    'success' => false,
                    'message' => 'Onboarding not found.',
                ], 422);
            }

            if ($onboarding->kyc_link !== $kyc_link) {
                return response()->json([
                    'success' => false,
                    'message' => 'Onboarding mismatch for this KYC link.',
                ], 403);
            }

            $onboarding->update($request->only([
                'legal_business_name',
                'registration_number',
                'tax_id_vat',
                'trading_name',
                'dba_address',
                'dba_zip_code',
                'dba_city',
                'business_website',
                'merchant_phone_number',
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Company information saved successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving.',
            ], 500);
        }
    }

    public function beneficialOwners($kyc_link = null): View
    {
        $onboarding = $this->resolveOnboardingByKycLink($kyc_link);

        $section = KycSection::where('slug', 'beneficial-owners')
            ->with(['kycFields' => function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
            }])
            ->firstOrFail();

        $savedGroups = $onboarding
            ? KycFieldData::getGroupedForSection($onboarding, $section)
            : [];
        
        return view('merchant.kyc.beneficial-owners', [
            'kyc_link' => $kyc_link,
            'onboarding_id' => $onboarding?->id,
            'section' => $section,
            'fields' => $section->kycFields,
            'savedGroups' => $savedGroups,
        ]);
    }

    public function boardMembers($kyc_link = null): View
    {
        $onboarding = $this->resolveOnboardingByKycLink($kyc_link);

        $section = KycSection::where('slug', 'board-members-gm')
            ->with(['kycFields' => function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
            }])
            ->firstOrFail();

        $savedGroups = $onboarding
            ? KycFieldData::getGroupedForSection($onboarding, $section)
            : [];
        
        return view('merchant.kyc.board-members', [
            'kyc_link' => $kyc_link,
            'onboarding_id' => $onboarding?->id,
            'section' => $section,
            'fields' => $section->kycFields,
            'savedGroups' => $savedGroups,
        ]);
    }

    public function contactPerson($kyc_link = null): View
    {
        $onboarding = $this->resolveOnboardingByKycLink($kyc_link);

        $section = KycSection::where('slug', 'contact-person')
            ->with(['kycFields' => function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
            }])
            ->firstOrFail();

        $savedValues = $onboarding
            ? KycFieldData::getForSection($onboarding, $section)
            : [];
        
        return view('merchant.kyc.contact-person', [
            'kyc_link' => $kyc_link,
            'onboarding_id' => $onboarding?->id,
            'section' => $section,
            'fields' => $section->kycFields,
            'savedValues' => $savedValues,
        ]);
    }

    public function purposeOfService($kyc_link = null): View
    {
        $onboarding = $this->resolveOnboardingByKycLink($kyc_link);

        $section = KycSection::where('slug', 'purpose-of-service')
            ->with(['kycFields' => function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
            }])
            ->firstOrFail();

        $savedValues = $onboarding
            ? KycFieldData::getForSection($onboarding, $section)
            : [];
        
        return view('merchant.kyc.purpose-of-service', [
            'kyc_link' => $kyc_link,
            'onboarding_id' => $onboarding?->id,
            'section' => $section,
            'fields' => $section->kycFields,
            'savedValues' => $savedValues,
        ]);
    }

    public function salesChannels($kyc_link = null): View
    {
        $onboarding = $this->resolveOnboardingByKycLink($kyc_link);

        $section = KycSection::where('slug', 'sales-channels')
            ->with(['kycFields' => function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
            }])
            ->firstOrFail();

        $savedValues = $onboarding
            ? KycFieldData::getForSection($onboarding, $section)
            : [];
        
        return view('merchant.kyc.sales-channels', [
            'kyc_link' => $kyc_link,
            'onboarding_id' => $onboarding?->id,
            'section' => $section,
            'fields' => $section->kycFields,
            'savedValues' => $savedValues,
        ]);
    }

    public function bankInformation($kyc_link = null): View
    {
        $onboarding = $this->resolveOnboardingByKycLink($kyc_link);

        $section = KycSection::where('slug', 'bank-information')
            ->with(['kycFields' => function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
            }])
            ->firstOrFail();

        $savedValues = $onboarding
            ? KycFieldData::getForSection($onboarding, $section)
            : [];
        
        return view('merchant.kyc.bank-information', [
            'kyc_link' => $kyc_link,
            'onboarding_id' => $onboarding?->id,
            'section' => $section,
            'fields' => $section->kycFields,
            'savedValues' => $savedValues,
        ]);
    }

    public function authorizedSignatories($kyc_link = null): View
    {
        $onboarding = $this->resolveOnboardingByKycLink($kyc_link);

        $section = KycSection::where('slug', 'authorized-signatories')
            ->with(['kycFields' => function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
            }])
            ->firstOrFail();

        $savedGroups = $onboarding
            ? KycFieldData::getGroupedForSection($onboarding, $section)
            : [];
        
        return view('merchant.kyc.authorized-signatories', [
            'kyc_link' => $kyc_link,
            'onboarding_id' => $onboarding?->id,
            'section' => $section,
            'fields' => $section->kycFields,
            'savedGroups' => $savedGroups,
        ]);
    }

    public function section(string $kyc_link, string $section): View|RedirectResponse
    {
        $onboarding = $this->resolveOnboardingByKycLink($kyc_link);

        $sectionModel = KycSection::where('slug', $section)
            ->where('status', 'active')
            ->with(['kycFields' => function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
            }])
            ->firstOrFail();

        $sections = KycSection::query()
            ->where('status', 'active')
            ->whereHas('kycFields', function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'name', 'slug', 'sort_order']);

        if ($sectionModel->kycFields->isEmpty()) {
            $fallbackSection = $sections->first();

            if ($fallbackSection && $fallbackSection->slug !== $sectionModel->slug) {
                return redirect()->route('merchant.kyc.section', [
                    'kyc_link' => $kyc_link,
                    'section' => $fallbackSection->slug,
                ]);
            }
        }

        $currentIndex = $sections->search(fn ($item) => $item->slug === $sectionModel->slug);
        $prevSection = $currentIndex !== false ? $sections->get($currentIndex - 1) : null;
        $nextSection = $currentIndex !== false ? $sections->get($currentIndex + 1) : null;

        $savedValues = $onboarding
            ? KycFieldData::getForSection($onboarding, $sectionModel)
            : [];

        return view('merchant.kyc.section', [
            'kyc_link' => $kyc_link,
            'onboarding_id' => $onboarding?->id,
            'onboardingAcquirers' => is_array($onboarding?->acquirers) ? $onboarding->acquirers : [],
            'section' => $sectionModel,
            'fields' => $sectionModel->kycFields->values(),
            'savedValues' => $savedValues,
            'prevSection' => $prevSection,
            'nextSection' => $nextSection,
        ]);
    }

    public function review($kyc_link = null): View
    {
        $onboarding = $this->resolveOnboardingByKycLink($kyc_link);

        $sections = KycSection::where('status', 'active')
            ->with(['kycFields' => function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
            }])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $groupedSectionSlugs = ['beneficial-owners', 'board-members-gm', 'authorized-signatories'];
        $reviewData = [];

        foreach ($sections as $section) {
            if (! $onboarding) {
                $reviewData[$section->id] = ['type' => 'single', 'values' => []];
                continue;
            }

            if (in_array($section->slug, $groupedSectionSlugs, true)) {
                $reviewData[$section->id] = [
                    'type' => 'grouped',
                    'values' => KycFieldData::getGroupedForSection($onboarding, $section),
                ];
            } else {
                $reviewData[$section->id] = [
                    'type' => 'single',
                    'values' => KycFieldData::getForSection($onboarding, $section),
                ];
            }
        }

        return view('merchant.kyc.review', [
            'kyc_link' => $kyc_link,
            'onboarding_id' => $onboarding?->id,
            'declarationAccepted' => !is_null($onboarding?->review_declaration_accepted_at),
            'sections' => $sections,
            'reviewData' => $reviewData,
        ]);
    }

    public function thankYou($kyc_link = null): View
    {
        $onboarding = $this->resolveOnboardingByKycLink($kyc_link);

        return view('merchant.kyc.thank-you', [
            'kyc_link' => $kyc_link,
            'onboarding' => $onboarding,
        ]);
    }

    public function submitReview(Request $request, string $kyc_link)
    {
        $validated = $request->validate([
            'onboarding_id' => 'required|exists:onboardings,id',
            'is_draft' => 'nullable|boolean',
            'declaration' => 'nullable|accepted',
        ]);

        $onboarding = Onboarding::findOrFail((int) $validated['onboarding_id']);

        if ($onboarding->kyc_link !== $kyc_link) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Onboarding mismatch for this KYC link.',
                ], 403);
            }

            abort(403, 'Onboarding mismatch for this KYC link.');
        }

        $isDraft = $request->boolean('is_draft');

        if (!$isDraft) {
            $request->validate([
                'declaration' => 'accepted',
            ]);

            $onboarding->review_declaration_accepted_at = now();
            $onboarding->status = 'in-review';
            $onboarding->save();
        }

        $message = $isDraft
            ? 'Review draft saved successfully.'
            : 'KYC review submitted successfully. Your application is now under review.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        return redirect()
            ->route($isDraft ? 'merchant.kyc.review' : 'merchant.kyc.thankyou', ['kyc_link' => $kyc_link])
            ->with('success', $message);
    }

    /**
     * Save dynamic fields for a specific KYC section.
     */
    public function saveSectionFields(Request $request, string $kyc_link, string $section): JsonResponse
    {
        try {
            $onboardingId = (int) $request->input('onboarding_id');
            if ($onboardingId <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid onboarding context.',
                ], 422);
            }

            $sectionModel = KycSection::where('slug', $section)->firstOrFail();
            $onboarding = Onboarding::find($onboardingId);

            if (! $onboarding) {
                return response()->json([
                    'success' => false,
                    'message' => 'Onboarding not found.',
                ], 422);
            }

            $sectionModel->load(['kycFields' => function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
            }]);

            if ($onboarding->kyc_link !== $kyc_link) {
                return response()->json([
                    'success' => false,
                    'message' => 'Onboarding mismatch for this KYC link.',
                ], 403);
            }

            // If all fields are hidden due to acquirer/country visibility, succeed immediately.
            if ($sectionModel->kycFields->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'KYC section fields saved successfully.',
                ]);
            }

            $boFields = $request->input('bo_fields', []);
            $bmFields = $request->input('bm_fields', []);
            $asFields = $request->input('as_fields', []);
            $dynamicFields = $request->input('dynamic_fields', []);

            if (!empty($boFields) && is_array($boFields)) {
                foreach ($boFields as $groupIndex => $groupFields) {
                    if (!is_array($groupFields)) {
                        continue;
                    }
                    KycFieldData::saveForSection($onboarding, $sectionModel, $groupFields, (int) $groupIndex);
                }
            } elseif (!empty($bmFields) && is_array($bmFields)) {
                foreach ($bmFields as $groupIndex => $groupFields) {
                    if (!is_array($groupFields)) {
                        continue;
                    }
                    KycFieldData::saveForSection($onboarding, $sectionModel, $groupFields, (int) $groupIndex);
                }
            } elseif (!empty($asFields) && is_array($asFields)) {
                foreach ($asFields as $groupIndex => $groupFields) {
                    if (!is_array($groupFields)) {
                        continue;
                    }
                    KycFieldData::saveForSection($onboarding, $sectionModel, $groupFields, (int) $groupIndex);
                }
            } elseif (!empty($dynamicFields) && is_array($dynamicFields)) {
                KycFieldData::saveForSection($onboarding, $sectionModel, $dynamicFields);
            } else {
                // All visible fields may be optional and merchant submitted nothing — that is valid.
                // (The empty-section early-return above already handles fully hidden sections.)
            }

            return response()->json([
                'success' => true,
                'message' => 'KYC section fields saved successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to save KYC section fields.',
            ], 500);
        }
    }

    /**
     * Check authentication status and merchant role
     */
    public function checkAuth(Request $request): JsonResponse
    {
        $user = Auth::user();
        $authenticated = $user !== null;
        $isMerchant = $authenticated && (int) $user->role_id === 2;
        $kycLink = (string) $request->query('kyc_link', '');

        $redirectUrl = $isMerchant
            ? $this->resolveFirstSectionRedirectUrl($kycLink !== '' ? $kycLink : null)
            : null;

        return response()->json([
            'authenticated' => $authenticated,
            'is_merchant' => $isMerchant,
            'user' => $isMerchant ? [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
            ] : null,
            'redirect_url' => $redirectUrl,
        ]);
    }

    /**
     * Handle merchant login
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
                'kyc_link' => 'nullable|string',
            ]);

            // Attempt authentication
            if (!Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], 
                               (bool) $request->input('remember'))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email or password.',
                ], 401);
            }

            $user = Auth::user();

            // Check if user has merchant role
            if ((int) $user->role_id !== 2) {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'This account does not have merchant access.',
                ], 403);
            }

            // If a kyc_link was provided, verify the authenticated user owns that onboarding
            $kycLink = $validated['kyc_link'] ?? null;
            if ($kycLink) {
                $onboarding = Onboarding::where('kyc_link', $kycLink)->first();
                if ($onboarding && (int) $onboarding->merchant_user_id !== (int) $user->id) {
                    Auth::logout();
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid email or password.',
                    ], 401);
                }
            }

            // Regenerate session to prevent fixation attacks
            $request->session()->regenerate();

            $redirectRoute = $this->resolveFirstSectionRedirectUrl($validated['kyc_link'] ?? null);

            return response()->json([
                'success' => true,
                'message' => 'Logged in successfully',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role_id' => $user->role_id,
                ],
                'redirect_url' => $redirectRoute,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during login',
            ], 500);
        }
    }

    /**
     * Send password reset link for merchant users.
     */
    public function sendResetLinkEmail(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
            ]);

            $merchantUser = User::where('email', $validated['email'])
                ->where('role_id', 2)
                ->first();

            // Return a generic success response to avoid exposing account existence.
            if (! $merchantUser) {
                return back()->with('status', 'If the email is registered, a reset link has been sent.');
            }

            $status = Password::sendResetLink([
                'email' => $validated['email'],
            ]);

            if ($status === Password::RESET_LINK_SENT) {
                return back()->with('status', __($status));
            }

            return back()->withErrors(['email' => __($status)]);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput($request->only('email'));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Unable to process forgot password request.']);
        }
    }

    /**
     * Display forgot password form.
     */
    public function showForgotPasswordForm(Request $request): View
    {
        return view('merchant.kyc.forgot-password', [
            'email' => (string) $request->query('email', ''),
            'kyc_link' => (string) $request->query('kyc_link', ''),
        ]);
    }

    /**
     * Display reset password form.
     */
    public function showResetPasswordForm(Request $request, string $token): View
    {
        return view('merchant.kyc.reset-password', [
            'token' => $token,
            'email' => (string) $request->query('email', ''),
        ]);
    }

    /**
     * Reset password from emailed token.
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            [
                'email' => $validated['email'],
                'password' => $validated['password'],
                'password_confirmation' => $request->input('password_confirmation'),
                'token' => $validated['token'],
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('admin.login')->with('success', __($status));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
