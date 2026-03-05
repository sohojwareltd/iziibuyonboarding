<?php

namespace App\Http\Controllers\Merchant;

use App\Facades\KycFieldData;
use App\Http\Controllers\Controller;
use App\Models\Onboarding;
use App\Models\KycSection;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class KycController extends Controller
{
    private function resolveOnboardingByKycLink(?string $kyc_link): ?Onboarding
    {
        if (empty($kyc_link)) {
            return null;
        }

        return Onboarding::where('kyc_link', $kyc_link)->first();
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
            ->with(['kycFields' => function ($query) {
                $query->where('status', 'active')
                    ->where('visible_to_merchant', true)
                    ->orderBy('sort_order');
            }])
            ->firstOrFail();

        $savedValues = $onboarding
            ? KycFieldData::getForSection($onboarding, $section)
            : [];
        
        return view('merchant.kyc.company', [
            'kyc_link' => $kyc_link,
            'onboarding_id' => $onboarding?->id,
            'section' => $section,
            'fields' => $section->kycFields,
            'savedValues' => $savedValues,
        ]);
    }

    public function beneficialOwners($kyc_link = null): View
    {
        $onboarding = $this->resolveOnboardingByKycLink($kyc_link);

        $section = KycSection::where('slug', 'beneficial-owners')
            ->with(['kycFields' => function ($query) {
                $query->where('status', 'active')
                    ->where('visible_to_merchant', true)
                    ->orderBy('sort_order');
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
            ->with(['kycFields' => function ($query) {
                $query->where('status', 'active')
                    ->where('visible_to_merchant', true)
                    ->orderBy('sort_order');
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
            ->with(['kycFields' => function ($query) {
                $query->where('status', 'active')
                    ->where('visible_to_merchant', true)
                    ->orderBy('sort_order');
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
            ->with(['kycFields' => function ($query) {
                $query->where('status', 'active')
                    ->where('visible_to_merchant', true)
                    ->orderBy('sort_order');
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
            ->with(['kycFields' => function ($query) {
                $query->where('status', 'active')
                    ->where('visible_to_merchant', true)
                    ->orderBy('sort_order');
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
            ->with(['kycFields' => function ($query) {
                $query->where('status', 'active')
                    ->where('visible_to_merchant', true)
                    ->orderBy('sort_order');
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
            ->with(['kycFields' => function ($query) {
                $query->where('status', 'active')
                    ->where('visible_to_merchant', true)
                    ->orderBy('sort_order');
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

    public function review($kyc_link = null): View
    {
        $onboarding = $this->resolveOnboardingByKycLink($kyc_link);

        $sections = KycSection::where('status', 'active')
            ->with(['kycFields' => function ($query) {
                $query->where('status', 'active')
                    ->where('visible_to_merchant', true)
                    ->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
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
            $onboarding->kyc_completed_at = now();
            $onboarding->save();
        }

        $message = $isDraft
            ? 'Review draft saved successfully.'
            : 'KYC review submitted successfully.';

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
            $validated = $request->validate([
                'onboarding_id' => 'required|exists:onboardings,id',
                'dynamic_fields' => 'nullable|array',
                'bo_fields' => 'nullable|array',
                'bm_fields' => 'nullable|array',
                'as_fields' => 'nullable|array',
            ]);

            $sectionModel = KycSection::where('slug', $section)->firstOrFail();
            $onboarding = Onboarding::findOrFail((int) $validated['onboarding_id']);

            if ($onboarding->kyc_link !== $kyc_link) {
                return response()->json([
                    'success' => false,
                    'message' => 'Onboarding mismatch for this KYC link.',
                ], 403);
            }

            if (!empty($validated['bo_fields']) && is_array($validated['bo_fields'])) {
                foreach ($validated['bo_fields'] as $groupIndex => $groupFields) {
                    if (!is_array($groupFields)) {
                        continue;
                    }
                    KycFieldData::saveForSection($onboarding, $sectionModel, $groupFields, (int) $groupIndex);
                }
            } elseif (!empty($validated['bm_fields']) && is_array($validated['bm_fields'])) {
                foreach ($validated['bm_fields'] as $groupIndex => $groupFields) {
                    if (!is_array($groupFields)) {
                        continue;
                    }
                    KycFieldData::saveForSection($onboarding, $sectionModel, $groupFields, (int) $groupIndex);
                }
            } elseif (!empty($validated['as_fields']) && is_array($validated['as_fields'])) {
                foreach ($validated['as_fields'] as $groupIndex => $groupFields) {
                    if (!is_array($groupFields)) {
                        continue;
                    }
                    KycFieldData::saveForSection($onboarding, $sectionModel, $groupFields, (int) $groupIndex);
                }
            } elseif (!empty($validated['dynamic_fields']) && is_array($validated['dynamic_fields'])) {
                KycFieldData::saveForSection($onboarding, $sectionModel, $validated['dynamic_fields']);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No field data provided.',
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'KYC section fields saved successfully.',
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
                'message' => 'Unable to save KYC section fields.',
            ], 500);
        }
    }

    /**
     * Check authentication status and merchant role
     */
    public function checkAuth(): JsonResponse
    {
        $user = Auth::user();
        $authenticated = $user !== null;
        $isMerchant = $authenticated && (int) $user->role_id === 2;

        return response()->json([
            'authenticated' => $authenticated,
            'is_merchant' => $isMerchant,
            'user' => $isMerchant ? [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
            ] : null,
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

            // Regenerate session to prevent fixation attacks
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Logged in successfully',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role_id' => $user->role_id,
                ],
                'redirect_url' => route('merchant.kyc.company', ['kyc_link' => $validated['kyc_link'] ?? null]),
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
}
