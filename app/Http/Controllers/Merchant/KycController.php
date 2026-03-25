<?php

namespace App\Http\Controllers\Merchant;

use App\Facades\KycFieldData;
use App\Http\Controllers\Controller;
use App\Models\Onboarding;
use App\Models\KycSection;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class KycController extends Controller
{
    private function normalizeOnboardingCountry(?Onboarding $onboarding): ?string
    {
        if (! $onboarding || empty($onboarding->country_of_operation)) {
            return null;
        }

        return strtoupper((string) $onboarding->country_of_operation);
    }

    private function applyFieldVisibilityRules($query, ?Onboarding $onboarding)
    {
        $countryCode = $this->normalizeOnboardingCountry($onboarding);

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
            ->orderBy('sort_order')
            ->orderBy('id');
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
            ->with(['kycFields' => function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
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

    public function section(string $kyc_link, string $section): View
    {
        $onboarding = $this->resolveOnboardingByKycLink($kyc_link);

        $sectionModel = KycSection::where('slug', $section)
            ->where('status', 'active')
            ->with(['kycFields' => function ($query) use ($onboarding) {
                $this->applyFieldVisibilityRules($query, $onboarding);
            }])
            ->firstOrFail();

        $sections = KycSection::where('status', 'active')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'name', 'slug', 'sort_order']);

        $currentIndex = $sections->search(fn ($item) => $item->slug === $sectionModel->slug);
        $prevSection = $currentIndex !== false ? $sections->get($currentIndex - 1) : null;
        $nextSection = $currentIndex !== false ? $sections->get($currentIndex + 1) : null;

        $savedValues = $onboarding
            ? KycFieldData::getForSection($onboarding, $sectionModel)
            : [];

        return view('merchant.kyc.section', [
            'kyc_link' => $kyc_link,
            'onboarding_id' => $onboarding?->id,
            'section' => $sectionModel,
            'fields' => $sectionModel->kycFields->sortBy('sort_order'),
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
            $validated = $request->validate([
                'onboarding_id' => 'required|exists:onboardings,id',
                'dynamic_fields' => 'nullable|array',
                'bo_fields' => 'nullable|array',
                'bm_fields' => 'nullable|array',
                'as_fields' => 'nullable|array',
            ]);

            $sectionModel = KycSection::where('slug', $section)->firstOrFail();
            $sectionModel->load(['kycFields' => fn ($query) => $query->with('documentType')]);
            $onboarding = Onboarding::findOrFail((int) $validated['onboarding_id']);

            if ($onboarding->kyc_link !== $kyc_link) {
                return response()->json([
                    'success' => false,
                    'message' => 'Onboarding mismatch for this KYC link.',
                ], 403);
            }

            $fileRules = $this->buildDocumentTypeFileRules($sectionModel);
            if (!empty($fileRules)) {
                $request->validate($fileRules);
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
